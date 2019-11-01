<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class FixOrderProductTableName extends Migration
{
    public function up()
    {
        Schema::rename('order_products', 'order_product');
    }

    public function down()
    {
        Schema::rename('order_product', 'order_products');
    }
}
