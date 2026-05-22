<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('membership_id')->constrained('memberships')->onDelete('cascade');
            $table->foreignId('gym_id')->constrained('gyms')->onDelete('cascade');
            $table->date('visit_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visit_logs');
    }
};