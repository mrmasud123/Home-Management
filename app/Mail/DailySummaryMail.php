<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DailySummaryMail extends Mailable
{
    use SerializesModels;

    public $member;
    public $mealCount;
    public $bazarTotal;
    public $date;

    public function __construct($member, $mealCount, $bazarTotal, $date)
    {
        $this->member = $member;
        $this->mealCount = $mealCount;
        $this->bazarTotal = $bazarTotal;
        $this->date = $date;
    }

    public function build()
    {
        return $this->subject('Your Daily Meal & Bazar Summary — ' . $this->date)
            ->view('emails.daily-summary');
    }
}
