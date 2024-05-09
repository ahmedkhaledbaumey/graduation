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
        Schema::create('students', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('english_name');
                // $table->string('last_name');
                $table->integer('age');
                $table->string('SSN');
                $table->string('password'); // الرقم القومي  
                $table->string('email')->unique();   
                $table->string('account')->unique()->nullable();   
                $table->string('phone')->nullable();    
                $table->string('nationality')->nullable();    
                $table->string('religion')->nullable();    
                $table->string('job')->nullable();    
                $table->string('address')->nullable();    
                $table->string('idea')->nullable();    
                $table->enum('type', ['moed', 'external'])->nullable()->default('moed');    
                $table->enum('degree', ['master', 'phd'])->default('master');    
                $table->enum('level', ['first_level', 'second_level'])->default('first_level'); 
                $table->string('enrollment_papers')->nullable();    
                $table->string('original_bachelors_degree')->nullable();  
                $table->enum('status', ['pending', 'accept'])->default('pending'); 
                $table->enum('time',['first','last']);   
                $table->enum('marital_status',['married','divorce','other']);   
                $table->enum('gender',['male','female']);   
                $table->foreignId('department_id')->constrained('departments')->onDelete('cascade')->onUpdate('cascade')->nullable() ;//ابقي غيرها من الgui null;
                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
