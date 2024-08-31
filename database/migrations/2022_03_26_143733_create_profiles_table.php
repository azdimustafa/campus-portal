<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_profiles', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->primary();
            $table->string('salary_no');
            $table->char('ptj_id', 36)->nullable();
            $table->char('department_id', 36)->nullable();
            $table->string('office_no')->nullable();
            $table->string('hp_no', 20)->nullable();
            $table->string('status')->nullable();
            $table->string("grade")->nullable();
            $table->string("grade_desc")->nullable();
            $table->string("position")->nullable();
            $table->timestamps();

            $table->foreign('user_id')->on('sys_users')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_profiles');
    }
}
