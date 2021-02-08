<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->tinyInteger('status');
            $table->string('client_email');
            $table->unsignedBigInteger('partner_id');

            $table->timestamp('delivery_at');
            $table->timestamps();

            $table->foreign('partner_id')->references('id')->on('partners')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
