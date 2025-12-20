<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('inventory_stocks', function (Blueprint $table) {
            $table->foreignId('warehouse_id')
                ->nullable()
                ->after('stockable_id');

            $table->integer('reserved_quantity')
                ->default(0)
                ->after('quantity');

            $table->unique(
                ['stockable_type', 'stockable_id', 'warehouse_id'],
                'inventory_stock_unique'
            );
        });
    }

    public function down()
    {
        Schema::table('inventory_stocks', function (Blueprint $table) {
            $table->dropUnique('inventory_stock_unique');
            $table->dropColumn(['warehouse_id', 'reserved_quantity']);
        });
    }
};
