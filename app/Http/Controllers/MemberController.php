<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Bazar;
use App\Models\Meal;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Services\CurrentMonthSummaryService;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CurrentMonthSummaryService $currentMonth)
    {
        $reportData = $currentMonth->getDataForMonth();

        return view('components.member.index', $reportData);        
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
    public function store(Request $request)
    {
       $actionType = $request->input('action_type');

        if ($actionType === 'create') {
            $validated = $request->validate([
                'name'        => 'required|string|max:255',
                'email'       => 'required|email|unique:members,email',
                'joined_date' => 'required|date',
                'status'      => 'required',
                'seat_rent'   => 'required|numeric'
            ]);

            Member::create($validated);

            return redirect()->back()->with('success', "Member Created Successfully");

        } elseif ($actionType === 'update') {
            $memberId = (int) $request->input('member_id'); 
            $validated = $request->validate([
                'name'        => 'required|string|max:255',
                'email'       => 'required|email|unique:members,email,' . $memberId . ',id',
                'joined_date' => 'required|date',
                'status'      => 'required',
                'seat_rent'   => 'required|numeric'
            ]);

            $member = Member::findOrFail($memberId);
            $member->update($validated);

            return redirect()->back()->with('success', "Member Updated Successfully");


        } elseif ($actionType === 'delete') {
            $memberId = $request->input('member_id');
            $member = Member::findOrFail($memberId);
            $member->delete();

            return redirect()->back()->with('success', "Member Deleted Successfully");
        } else {
            return redirect()->back()->with('error', "Invalid action type");
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $member = Member::findOrFail($id);

        return response()->json($member);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function updateStatus(Request $request, $id)
{
    $member = Member::findOrFail($id);
    $member->status = $request->status;
    $member->save();

    return response()->json(['success' => true]);
}

}
