<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserContextsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_user_contexts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('role_id')->nullable();
            $table->integer('level');
            $table->string('model_type')->nullable();
            $table->string("model_id")->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->on('sys_users')->references('id')->onDelete('cascade');
            $table->foreign('role_id')->on('sys_roles')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_user_contexts');
    }
}
