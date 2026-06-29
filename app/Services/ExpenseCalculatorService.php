<?php

namespace App\Services;

use App\Models\Member;

class ExpenseCalculatorService
{
    public function calculate(array $data): array
    {
        $flatRent        = $data['flat_rent'];
        $serviceCharge   = $data['service_charge'];
        $garbageCharge   = $data['garbage_charge'];
        $electricityBill = $data['electricity_bill'];
        $gasBill         = $data['gas_bill'];
        $wifiBill        = $data['wifi_bill'];
        $khalaSalary     = $data['khala_salary'];

        $allMembers   = Member::where('status', 1)->get();
        $totalMembers = $allMembers->count();

        if ($totalMembers === 0) {
            return ['status' => false, 'message' => 'No active members found.'];
        }

        $perPersonGarbage     = ceil($garbageCharge / $totalMembers);
        $perPersonKhala       = $khalaSalary / $totalMembers;
        $perPersonWifi        = $wifiBill / $totalMembers;
        $perPersonElectricity = $electricityBill / $totalMembers;
        $perPersonService     = $serviceCharge / $totalMembers;
        $perPersonGas         = $gasBill / $totalMembers;

        $monthlyExpenses = [];
        $grandTotal      = 0;

        foreach ($allMembers as $member) {
            $seatRent = $member->seat_rent != 0
                ? round($member->seat_rent / 100 * $flatRent)
                : 0;

            $totalExpense = $seatRent
                + ceil($perPersonService)
                + $perPersonGarbage
                + ceil($perPersonGas)
                + ceil($perPersonKhala)
                + ceil($perPersonWifi)
                + ceil($perPersonElectricity);

            $monthlyExpenses[] = [
                'member'           => $member->name,
                'flat_rent'        => $seatRent,
                'service_charge'   => ceil($perPersonService),
                'garbage_charge'   => $perPersonGarbage,
                'electricity_bill' => ceil($perPersonElectricity),
                'gas_bill'         => ceil($perPersonGas),
                'khala_salary'     => ceil($perPersonKhala),
                'wifi_bill'        => ceil($perPersonWifi),
                'total_amt'        => ceil($totalExpense),
            ];

            $grandTotal += ceil($totalExpense);
        }

        return [
            'status'           => true,
            'monthly_expenses' => $monthlyExpenses,
            'grand_total'      => $grandTotal,
            'amounts'          => $data,
        ];
    }
}
