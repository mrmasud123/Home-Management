<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Bazar;
use App\Models\Meal;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Services\CurrentMonthSummaryService;


class CredentialsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CurrentMonthSummaryService $currentMonth)
    {
        $reportData = $currentMonth->getDataForMonth();

        return view('components.meal.index', $reportData);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return $request->input();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request){
        $meals = $request->input('meals'); 
        
        
        if(!$meals || !is_array($meals)) {
            return response()->json(['success' => false, 'message' => 'No meal data provided.'], 400);
        }

        $mealDate = $meals[0]['meal_date']; 
        $existing = \App\Models\Meal::where('meal_date', $mealDate)->exists();

        if($existing) {
            return response()->json(['success' => false, 'message' => 'Record already inserted for this date.'], 409);
        }

        // Insert meals
        foreach($meals as $meal) {
            \App\Models\Meal::create([
                'member_name' => $meal['member_name'],
                'member_id'   => $meal['member_id'], 
                'meal_count'  => $meal['meal_count'],
                'meal_date'   => $meal['meal_date'],
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Meals saved successfully']);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function calculateMonthlyExpense(Request $request){

        $flatRent        = $request->input('flat_rent', null);
        $serviceCharge   = $request->input('service_charge', null);
        $garbageCharge   = $request->input('garbage_charge', null);
        $electricityBill = $request->input('electricity_bill', null);
        $gasBill         = $request->input('gas_bill', null);
        $khalaSalary     = $request->input('khala_salary', null);
        $wifiBill        = $request->input('wifi_bill', null);

        $fields = [
            'flat_rent'        => $flatRent,
            'service_charge'   => $serviceCharge,
            'garbage_charge'   => $garbageCharge,
            'electricity_bill' => $electricityBill,
            'gas_bill'         => $gasBill,
            'wifi_bill'        => $wifiBill,
            'khala_salary'     => $khalaSalary,
        ];

        foreach ($fields as $name => $value) {
            if (empty($value)) {
                return response()->json([
                    'status' => false,
                    'message' => "The field '{$name}' is required."
                ]);
            }
        }


        $allMembers = Member::where('status', 1)->get();
        $totalMembers = $allMembers->count();

        $khalaSalaryExcluded = [];
        $wifiBillExcluded = [];
        $electricityExcluded = [];

        foreach ($allMembers as $member) {
            $khalaKey      = 'khala_member' . ($member->id + 999);
            $wifiKey       = 'wifi_member' . ($member->id + 888);
            $electricityKey = 'electricity_member' . ($member->id + 777);

            if ($request->has($khalaKey)) {
                $khalaSalaryExcluded[$member->id] = $member->name;
            }
            if ($request->has($wifiKey)) {
                $wifiBillExcluded[$member->id] = $member->name;
            }
            if ($request->has($electricityKey)) {
                $electricityExcluded[$member->id] = $member->name;
            }
        }

        $totalIncludedKhala = $totalMembers - count($khalaSalaryExcluded);
        $perPersonKhala = $totalIncludedKhala > 0 ? $khalaSalary / $totalIncludedKhala : 0;

        $totalIncludedWifi = $totalMembers - count($wifiBillExcluded);
        $perPersonWifi = $totalIncludedWifi > 0 ? $wifiBill / $totalIncludedWifi : 0;

        $totalIncludedElectricity = $totalMembers - count($electricityExcluded);
        $perPersonElectricity = $totalIncludedElectricity > 0 ? $electricityBill / $totalIncludedElectricity : 0;

        $perPersonService = $totalMembers > 0 ? ceil($serviceCharge / $totalMembers) : 0;
        $perPersonGarbage = $totalMembers > 0 ? ceil($garbageCharge / $totalMembers) : 0;
        $perPersonGas     = $totalMembers > 0 ? ceil($gasBill / $totalMembers) : 0;

        $monthlyExpenses = [];
        $grandTotal = 0;

        foreach ($allMembers as $member) {
            $seatRent = $member->seat_rent ?? 0;

            $perMemberKhala       = isset($khalaSalaryExcluded[$member->id]) ? 0 : $perPersonKhala;
            $perMemberWifi        = isset($wifiBillExcluded[$member->id]) ? 0 : $perPersonWifi;
            $perMemberElectricity = isset($electricityExcluded[$member->id]) ? 0 : $perPersonElectricity;

            $totalExpense = $seatRent + $perPersonService + $perPersonGarbage
                + $perPersonGas + $perMemberKhala + $perMemberWifi + $perMemberElectricity;

            $monthlyExpenses[] = [
                'member'          => $member->name,
                'flat_rent'       => $seatRent,
                'service_charge'  => $perPersonService,
                'garbage_charge'  => $perPersonGarbage,
                'electricity_bill'=> ceil($perMemberElectricity),
                'gas_bill'        => $perPersonGas,
                'khala_salary'    => ceil($perMemberKhala),
                'wifi_bill'       => ceil($perMemberWifi),
                'total_amt'       => ceil($totalExpense),
            ];

            $grandTotal += ceil($totalExpense);
        }

        return response()->json([
            'status' => true,
            'monthly_expenses' => $monthlyExpenses,
            'grand_total' => $grandTotal,
            'amounts'=>[
                'flat_rent'        => $flatRent,
                'service_charge'   => $serviceCharge,
                'garbage_charge'   => $garbageCharge,
                'electricity_bill' => $electricityBill,
                'gas_bill'         => $gasBill,
                'wifi_bill'        => $wifiBill,
                'khala_salary'     => $khalaSalary,
            ]
        ]);
    }

}
