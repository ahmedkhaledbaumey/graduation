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
        Schema::create('department_profesors', function (Blueprint $table) {
            $table->id();
           
            $table->foreignId('prof_id')->constrained('profs')->onDelete('cascade')->onUpdate('cascade') ;
            $table->foreignId('vice_dean_id')->constrained('vice_deans')->onDelete('cascade')->onUpdate('cascade') ;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('department_profesors');
    }
};
