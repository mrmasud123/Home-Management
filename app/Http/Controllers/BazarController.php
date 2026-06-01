<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bazar;
use App\Models\Member;
use Carbon\Carbon;
use Mpdf\Mpdf;

class BazarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('components.bazar.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request){
        $bazars = $request->input('bazars'); 
        // return $bazars;
        if(!$bazars || !is_array($bazars)) {
            return response()->json(['success' => false, 'message' => 'No bazar data provided.'], 400);
        }

        $bazarDate = $bazars[0]['bazar_date']; 
        $existing = \App\Models\Bazar::where('bazar_amt_date', $bazarDate)->exists();

        if($existing) {
            return response()->json(['success' => false, 'message' => 'Record already inserted for this date.'], 409);
        }

        // Insert meals
        foreach($bazars as $bazar) {
            \App\Models\Bazar::create([
                'member_name' => $bazar['member_name'],
                'bazar_amt_date'   => $bazar['bazar_date'], 
                'member_id'   => $bazar['member_id'], 
                'amount'  => $bazar['bazar_amount']
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Bazar saved successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $bazar = Bazar::find($id);
        // return $bazar;
        if (!$bazar) {
            return response()->json(['success' => false, 'message' => 'Bazar not found'], 404);
        }
    
        if ($request->has('bazarAmount')) {
            $bazar->amount = $request->bazarAmount;
        }

        $bazar->save();

        return response()->json([
            'success' => true,
            'message' => 'Bazar updated successfully',
            'meal' => $bazar
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function generateReport($date)
    {
        date_default_timezone_set('Asia/Dhaka');
        $month= Carbon::parse($date)->format('m');
        $year =Carbon::parse($date)->format('Y');
        $record = Member::where('status',1)

        ->withSum(['bazar'=> function($query) use ($year,$month){
            return $query->whereMonth('bazar_amt_date', $month)->whereYear('bazar_amt_date', $year);
        }], 'amount')
        ->withSum(['meals'=>function($query) use ($year,$month){
            return $query->whereMonth('meal_date', $month)->whereYear('meal_date', $year);
        }], 'meal_count')
        ->with(['bazar'=> function($query) use ($year,$month) {
            return $query->whereYear('bazar_amt_date', $year)->whereMonth('bazar_amt_date', $month);
        }])->get(); 
        $pdfMonth=Carbon::parse($date)->format('F');
        $html = view('bazar-report', compact('record','pdfMonth'))->render();
       
        $mpdf = new Mpdf(['format' => 'A5-L',]);

        // Write HTML content
        $mpdf->WriteHTML($html);
        $pdfMonth=Carbon::parse($date)->format('F');
        // Output PDF directly
        return response($mpdf->Output($pdfMonth.'-report.pdf', 'I'))
            ->header('Content-Type', 'application/pdf');
    }
}
