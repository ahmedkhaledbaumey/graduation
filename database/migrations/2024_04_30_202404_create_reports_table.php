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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('content') ; 
            $table->date('date') ; 
            $table->foreignId('prof_id')->constrained('profs')->onDelete('cascade')->onUpdate('cascade')->nullable();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade')->onUpdate('cascade')->nullable() ;
            $table->foreignId('department_id')->constrained('departments')->onDelete('cascade')->onUpdate('cascade')->nullable(); 


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
