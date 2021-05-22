<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('resort_id');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('guest_id');
            $table->string('invoice_no');
            $table->double('sub_total', 8, 2)->default(0);
            $table->double('vat', 8, 2)->default(0);
            $table->double('vat_amount', 8, 2)->default(0);
            $table->double('discount', 8, 2)->default(0);
            $table->double('grand_total', 8, 2)->default(0);
            $table->integer('adult')->default(0);
            $table->integer('child')->default(0);
            $table->date('issue_date');
            $table->date('check_in');
            $table->date('check_out');
            $table->enum('booked_by', ['admin', 'resort', 'customer', 'guest']);
            $table->enum('status', ['pending', 'approved', 'cancelled']);
            $table->enum('booking_type', ['booking', 'quick_booking', 'guest_booking', 'customer_booking']);
            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->foreign('resort_id')->references('id')->on('resorts')->onDelete('cascade');
            $table->foreign('guest_id')->references('id')->on('guests')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
