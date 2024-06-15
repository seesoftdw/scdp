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
        Schema::create('soe_master', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('majorhead_id');
            $table->unsignedBigInteger('scheme_id');
            $table->string('soe_name');
            $table->timestamps();
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('majorhead_id')->references('id')->on('majorhead');
            $table->foreign('scheme_id')->references('id')->on('scheme_master');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('soe_master');
    }
};
