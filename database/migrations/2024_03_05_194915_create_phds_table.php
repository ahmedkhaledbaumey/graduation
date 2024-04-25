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
        Schema::create('phds', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->integer('age');
            $table->integer('SSN');
            $table->string('password'); // الرقم القومي  
            $table->string('email')->unique();   
            $table->string('account')->unique();   
            $table->string('phone')->nullable();    
            $table->string('magester_certificate');    
            $table->string('address')->nullable();    
            $table->string('idea')->nullable();    
            $table->enum('type', ['moed', 'external'])->nullable()->default('moed');    
            $table->enum('department', ['moed', 'external'])->nullable()->default('moed');    
            // $table->enum('level', ['first_level' , 'secound_level'])->default('first_level'); 
            $table->foreignId('department_id')->constrained('departments')->onDelete('cascade')->onUpdate('cascade') ;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phds');
    }
};
