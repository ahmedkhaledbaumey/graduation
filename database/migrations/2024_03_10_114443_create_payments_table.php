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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            // $table->date('date');
            // $table->double('amount', 8, 2); 
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade')->onUpdate('cascade') ;
            $table->foreignId('master_id')->constrained('masters')->onDelete('cascade')->onUpdate('cascade') ;
            $table->foreignId('phds_id')->constrained('phds')->onDelete('cascade')->onUpdate('cascade') ;
            $table->enum('type'  , ['master' , 'phd']) ; 
            $table->enum('status'  , ['pending' , 'complete']) ; 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
