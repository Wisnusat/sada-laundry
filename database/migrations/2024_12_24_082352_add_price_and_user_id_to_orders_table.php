<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriceAndUserIdToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Adding price and user_id columns
            $table->decimal('price', 10, 2)->default(0); // Price with 2 decimal places
            $table->unsignedBigInteger('user_id')->nullable(); // Foreign key for user (nullable)

            // Optionally, you can add a foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Dropping the price and user_id columns
            $table->dropColumn('price');
            $table->dropForeign(['user_id']); // Drop the foreign key
            $table->dropColumn('user_id');
        });
    }
}
