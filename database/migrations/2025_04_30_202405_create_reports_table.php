<?php 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('content');
            $table->date('date');
            $table->foreignId('prof_id')->constrained('profs')->onDelete('cascade')->nullable();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade')->nullable();
            
            // Add the foreign key constraint for head_id referencing departments.head_id
            $table->unsignedBigInteger('head_id')->nullable();
            $table->foreign('head_id')->references('head_id')->on('departments')->onDelete('cascade')->onUpdate('cascade');

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
}
