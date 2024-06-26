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
        Schema::create('profs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
                   $table->string('email')->unique()->nullable();
            $table->string('phone');
            $table->string('password')->nullable();
            $table->string('degree');
            $table->string('specialization');
            $table->foreignId('department_id')->constrained('departments')->onDelete('cascade')->onUpdate('cascade') ; 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profs');
    }
};
