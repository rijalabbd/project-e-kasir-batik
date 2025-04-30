<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPreorderFieldsToProductsTableV2 extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('is_preorder')->default(false); // Default false
            $table->date('preorder_available_date')->nullable(); // Nullable, karena bisa kosong
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('is_preorder');
            $table->dropColumn('preorder_available_date');
        });
    }
}
