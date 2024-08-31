<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_login_logs', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable();
            $table->string('ip_address', 255)->nullable();
            $table->string('device', 255)->nullable();
            $table->string('platform', 255)->nullable();
            $table->string('user_agent', 255)->nullable();
            $table->string('status', 20)->default('success');
            $table->string('message', 255)->nullable();
            $table->string('type', 50)->default('local');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_login_logs');
    }
};
