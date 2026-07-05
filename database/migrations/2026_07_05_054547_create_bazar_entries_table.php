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
        Schema::create('bazar_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('members')->cascadeOnDelete();
            $table->string('items')->nullable();
            $table->decimal('amount', 10, 2);
            $table->date('bazar_date');
            $table->timestamps();
            $table->index(['bazar_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bazar_entries');
    }
};
