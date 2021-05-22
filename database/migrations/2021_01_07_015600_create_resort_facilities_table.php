<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResortFacilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resort_facilities', function (Blueprint $table) {
            $table->unsignedBigInteger('resort_id');
            $table->unsignedBigInteger('facility_resort_id');
            $table->foreign('resort_id')->references('id')->on('resorts')->onDelete('cascade');
            $table->foreign('facility_resort_id')->references('id')->on('facility_resorts')->onDelete('cascade');
            $table->primary(['resort_id', 'facility_resort_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resort_facilities');
    }
}
