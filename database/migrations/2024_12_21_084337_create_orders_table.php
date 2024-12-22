<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('name');         // 'name' column
            $table->string('email');        // 'email' column
            $table->text('address');        // 'address' column
            $table->text('items');          // 'items' column (store serialized/cart items as JSON or text)
            $table->decimal('total_price', 8, 2); // 'total_price' column
            $table->string('status')->default('pending'); // 'status' column
            $table->timestamps();          // 'created_at' and 'updated_at' columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
