<?php

use App\Http\Controllers\BazarController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CredentialsController;
use App\Http\Controllers\MemberController;
use App\Models\Bazar;
use App\Models\Meal;
use App\Models\Member;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Mpdf\Mpdf;
use App\Http\Controllers\AIChatConttroller;

use Carbon\Carbon;

Route::get('/login', function(){
    return view('login');
});
Route::get('/', function(Request $request){

    date_default_timezone_set('Asia/Dhaka');
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;


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

            $months = Meal::selectRaw("DISTINCT DATE_FORMAT(meal_date, '%M %Y') as month_name , DATE_FORMAT(meal_date, '%Y-%m') as month_value")->orderBy('month_value', 'asc')->get();

            $totals=Meal::select('member_name', DB::raw("COUNT(meal_count) as total"))->groupBy('member_name')->orderBy('member_name')->get();
                $currentMonthFull = Carbon::now()->format('F');

                // return $members;
    return view('components.home', compact('members','meals', 'bazars','totals','months', 'currentMonthFull'));
})->name('meal.home');

Route::resource('/members', MemberController::class);
Route::resource('/credentials', CredentialsController::class);
Route::resource('/bazar', BazarController::class);
Route::post('/credentials/calculateMonthlyExpense', [CredentialsController::class, 'calculateMonthlyExpense'])->name('credentials.calculateMonthlyExpense');

Route::get('/meal/{date}', function($date){
    return collect(Meal::where('meal_date', $date)->get());
});

Route::get('/get-bazar/{date}', function ($date) {
    return collect(Bazar::where('bazar_amt_date', $date)->get());
});

Route::put('/meal/update/{id}', function($id, Request $request){
    $meal = Meal::find($id);
    if (!$meal) {
        return response()->json(['success' => false, 'message' => 'Meal not found'], 404);
    }

    if ($request->has('mealCount')) {
        $meal->meal_count = $request->mealCount;
    }

    $meal->save();

    return response()->json([
        'success' => true,
        'message' => 'Meal updated successfully',
        'meal' => $meal
    ]);
});


Route::post('/generate-pdf', function (Request $request) {
    date_default_timezone_set('Asia/Dhaka');
    $data = [
        'month' =>$request->month,
        'monthly_expenses' => json_decode($request->monthly_expenses, true),
        'grand_total' => $request->grand_total,
        'amounts'=> json_decode($request->amounts, true),
    ];

    $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
    $fontDirs = $defaultConfig['fontDir'];

    $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
    $fontData = $defaultFontConfig['fontdata'];

    $mpdf = new Mpdf([
        'mode' => 'utf-8',
        'format' => 'A6',

    ]);


    $html = view('expense-report', compact('data'))->render();
    $mpdf->WriteHTML($html);
        $currentMonth = $data['month'] ?? date('F');
        $currentMonthTimestamp = strtotime("first day of $currentMonth");
        $month = date('F', strtotime('+1 month', $currentMonthTimestamp));
    return response($mpdf->Output($month.'_expense.pdf', 'I'), 200)
        ->header('Content-Type', 'application/pdf');
});
Route::get('/bazar-report/{date}', [BazarController::class, 'generateReport'])->name('bazar.report');


Route::get('/test', function ($date='2025-09-01'){
    return Bazar::where('bazar_amt_date', $date)->get();
});

Route::get('/history/{date}', function($date){
    $currentMonth = Carbon::parse($date)->format('m');
    $currentYear = Carbon::parse($date)->format('Y');
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

            $months = Meal::selectRaw("DISTINCT DATE_FORMAT(meal_date, '%M %Y') as month_name , DATE_FORMAT(meal_date, '%Y-%m') as month_value")->orderBy('month_value', 'asc')->get();

            $totals=Meal::select('member_name', DB::raw("COUNT(meal_count) as total"))->groupBy('member_name')->orderBy('member_name')->get();


    $currentMonthFull = Carbon::parse($date)->format('F');
    return view('components.history', compact('months','members','meals','bazars', 'currentMonthFull','date'));

})->name('meal.history');

Route::post('/members/update-status/{id}', [MemberController::class, 'updateStatus']);
Route::get('/ai-chat', [\App\Http\Controllers\AIChatController::class, 'index'])->name('ai.chat.index');
Route::post('/continue-chat', [\App\Http\Controllers\AIChatController::class, 'continueChat'])->name('admin.ai-chat.continue');
