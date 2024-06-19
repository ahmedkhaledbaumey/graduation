<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('course_students', function (Blueprint $table) {
            $table->unsignedBigInteger('department_id')->after('course_id'); // أضف العمود بعد عمود course_id
        });
    }
    
    public function down()
    {
        Schema::table('course_students', function (Blueprint $table) {
            $table->dropColumn('department_id');
        });
    }
    
};
