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
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['is', 'cs', 'ai', 'sc']);
            $table->string('research_plan')->nullable();         
            $table->foreignId('head_id')->constrained('heads')->onDelete('cascade')->onUpdate('cascade') ; 

            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
