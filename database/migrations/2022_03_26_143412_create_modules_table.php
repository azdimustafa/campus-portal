<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_modules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('code', 10);
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('booking_available_for')->nullable();
            $table->boolean('active')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('sys_modules', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by')->after('created_at')->nullable();
            $table->unsignedBigInteger('updated_by')->after('updated_at')->nullable();

            $table->foreign('parent_id')->on('sys_modules')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_modules');
    }
}
