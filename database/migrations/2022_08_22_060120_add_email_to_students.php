<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmailToStudents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->after('gender', function($table){
                $table->string('email')->nullable()->unique();
            });
        });
    }

    public function down()
    {
        if (Schema::hasColumn('students', 'email')){
            Schema::table('students', function (Blueprint $table)
            {
                $table->dropColumn('email');
            });
        }
    }
}
