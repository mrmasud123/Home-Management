<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Member;
use App\Models\Meal;
use App\Models\Bazar;
use App\Mail\DailySummaryMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendDailySummary extends Command
{
    protected $signature = 'meal:send-daily-summary';
    protected $description = 'Send each active member their daily meal & bazar summary';

    public function handle()
    {
        $today = Carbon::now()->format('Y-m-d');

        $members = Member::where('status', 1)
            ->whereNotNull('email')
            ->get();

        foreach ($members as $member) {
            $mealCount = Meal::where('member_name', $member->name)
                ->where('meal_date', $today)
                ->sum('meal_count');

            $bazarTotal = Bazar::where('member_name', $member->name)
                ->where('bazar_amt_date', $today)
                ->sum('amount');

            Mail::to($member->email)->send(
                new DailySummaryMail($member, $mealCount, $bazarTotal, $today)
            );

            $this->info("Sent to {$member->email}");
        }

        return 0;
    }
}
