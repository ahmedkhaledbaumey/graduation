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
        Schema::create('presinting_students', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();     
            $table->string('SSN')->nullable();    //الرقم القومي  
            $table->string('address')->nullable();    
            $table->enum('type', ['belong', 'not_belong'])->nullable();    
            $table->enum('level', ['first_level' , 'secound_level'])->default('first_level'); 
            $table->string('enrollment_papers')->nullable();    
            $table->string('original_bachelrios_degree')->nullable();    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presinting_students');
    }
};
