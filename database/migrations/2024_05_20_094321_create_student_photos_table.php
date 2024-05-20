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
        Schema::create('student_photos', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade')->onUpdate('cascade');
            $table->string('enrollment_papers')->nullable();    
            $table->string('original_bachelors_degree')->nullable();  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_photos');
    }
};
