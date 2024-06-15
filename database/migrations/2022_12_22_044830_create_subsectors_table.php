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
        Schema::create('subsectors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id')->require();
            $table->unsignedBigInteger('sector_id')->require();
            $table->string('subsectors_name')->require()->unique();
            $table->timestamps();
            $table->foreign('service_id')->references('id')->on('services');
            $table->foreign('sector_id')->references('id')->on('sectors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subsectors');
    }
};