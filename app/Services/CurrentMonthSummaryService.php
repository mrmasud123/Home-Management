<?php

// app/Services/MonthlyReportService.php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Member;
use App\Models\Meal;
use App\Models\Bazar;
use Illuminate\Support\Facades\DB;

class CurrentMonthSummaryService
{
    public function getDataForMonth($year = null, $month = null)
    {
        $currentMonth = $month ?? Carbon::now()->month;
        $currentYear = $year ?? Carbon::now()->year;

        $members = Member::withSum(['meals' => function ($query) use ($currentMonth, $currentYear) {
                        $query->whereMonth('meal_date', $currentMonth)
                            ->whereYear('meal_date', $currentYear);
                    }], 'meal_count')
                    ->withSum(['bazar' => function ($query) use ($currentMonth, $currentYear) {
                        $query->whereMonth('bazar_amt_date', $currentMonth)
                            ->whereYear('bazar_amt_date', $currentYear);
                    }], 'amount')
                    ->where('status', 1)
                    ->orderBy('name')
                    ->get();

        $meals = Meal::whereMonth('meal_date', $currentMonth)
            ->whereYear('meal_date', $currentYear)
            ->orderBy('member_name')
            ->orderBy('meal_date')
            ->get(['id', 'member_name', 'meal_count', 'meal_date'])
            ->groupBy('meal_date');

        $bazars = Bazar::whereMonth('bazar_amt_date', $currentMonth)
            ->whereYear('bazar_amt_date', $currentYear)
            ->orderBy('member_name')
            ->get(['member_name', 'amount', 'bazar_amt_date'])
            ->groupBy('bazar_amt_date');

        $months = Meal::selectRaw("DISTINCT DATE_FORMAT(meal_date, '%M %Y') as month_name , DATE_FORMAT(meal_date, '%Y-%m') as month_value")
            ->orderBy('month_value', 'asc')
            ->get();

        $totals = Meal::select('member_name', DB::raw("COUNT(meal_count) as total"))
            ->groupBy('member_name')
            ->orderBy('member_name')
            ->get();

        $currentMonthFull = Carbon::create()->month($currentMonth)->format('F');
        
        $inActiveMembers = Member::where('status', 0)->get();
        return compact('members', 'meals', 'bazars', 'months', 'totals', 'currentMonthFull', 'inActiveMembers');
    }
}
