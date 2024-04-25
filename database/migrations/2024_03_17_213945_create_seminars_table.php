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
        Schema::create('seminars', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['seminar1','semeinar2']);  
            $table->date('date');  
            $table->string('supervisor');  
            $table->string('idea');  
            $table->foreignId('master_id')->constrained('masters')->onDelete('cascade')->onUpdate('cascade') ;
            $table->foreignId('phds_id')->constrained('phds')->onDelete('cascade')->onUpdate('cascade') ;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seminars');
    }
};
