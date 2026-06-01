<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('monthly_expenses', function (Blueprint $table) {
            $table->id();
            $table->string('member');
            $table->double('flat_rent');
            $table->double('service_charge');
            $table->double('garbage_charge');
            $table->double('electricity_bill');
            $table->double('wifi_bill');
            $table->double('gas_bill');
            $table->double('khala_salary');
            $table->double('total_amt');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monthly_expenses');
    }
};
