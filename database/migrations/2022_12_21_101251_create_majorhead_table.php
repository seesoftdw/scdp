<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('majorhead', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('department_id');
            $table->string('mjr_head');
            $table->string('sm_head');
            $table->string('min_head');
            $table->string('sub_head');
            $table->string('bdgt_head');
            $table->string('complete_head')->unique();
            $table->timestamps();
            $table->foreign('department_id')->references('id')->on('departments');
        });
    }

    public function down()
    {
        Schema::dropIfExists('majorhead');
    }
};
