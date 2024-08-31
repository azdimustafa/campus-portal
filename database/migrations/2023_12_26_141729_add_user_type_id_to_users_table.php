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
        Schema::table('sys_users', function (Blueprint $table) {
            $table->unsignedBigInteger('user_type_id')->nullable()->after('id');
            $table->foreign('user_type_id')->references('id')->on('sys_user_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sys_users', function (Blueprint $table) {
            // drop foreign
            $table->dropForeign(['user_type_id']);
            $table->dropColumn('user_type_id');
        });
    }
};
