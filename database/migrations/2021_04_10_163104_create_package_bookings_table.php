<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_no');
            $table->unsignedBigInteger('assign_package_id');
            $table->unsignedBigInteger('guest_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->integer('member')->nullable();
            $table->unsignedBigInteger('package_route_id');
            $table->string('boarding_point')->nullable();
            $table->double('price', 8, 2)->default(0);
            $table->double('total_price', 8, 2)->default(0);
            $table->text('note')->nullable();
            $table->enum('status', ['pending', 'approved', 'cancelled'])->default('pending');
            $table->timestamps();
            $table->foreign('assign_package_id')->references('id')->on('assign_packages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('package_bookings');
    }
}
