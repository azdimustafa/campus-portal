<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDescriptionToRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sys_roles', function (Blueprint $table) {
            $table->string('description')->nullable()->after('name');
            $table->integer('level')->after('description')->nullable();
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
            $table->dropColumn(['description', 'level']);
        });
    }
}
