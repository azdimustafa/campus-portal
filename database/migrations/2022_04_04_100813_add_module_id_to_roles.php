<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddModuleIdToRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sys_roles', function (Blueprint $table) {
            $table->unsignedBigInteger('module_id')->after('id')->nullable();

            $table->foreign('module_id')->on('sys_modules')->references('id')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sys_roles', function (Blueprint $table) {
            $table->dropForeign('sys_roles_module_id_foreign');
            $table->dropColumn(['module_id']);
        });
    }
}
