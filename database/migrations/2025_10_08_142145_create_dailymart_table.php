<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['admin', 'staff', 'guest'])->default('guest');
            $table->timestamps();
        });
        Schema::create('categories', function (Blueprint $table) {
            $table->id('id_cat');
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
        });
        Schema::create('products', function (Blueprint $table) {
            $table->id('id_product');
            $table->foreignId('category_id')->constrained('categories', 'id_cat')->onDelete('cascade');
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->decimal('price', 12);
            $table->integer('stock');
            $table->string('image')->nullable();
            $table->timestamps();
        });
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id('id_variant');
            $table->foreignId('product_id')->constrained('products', 'id_product')->onDelete('cascade');
            $table->string('name');
            $table->integer('stock');
            $table->decimal('price', 12);
            $table->timestamps();
        });
        Schema::create('carts', function (Blueprint $table) {
            $table->id('id_cart');
            $table->foreignId('user_id')->constrained('users', 'id_user')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products', 'id_product')->onDelete('cascade');
            $table->foreignId('variant_id')->constrained('product_variants', 'id_variant')->onDelete('cascade');
            $table->integer('stock');
            $table->timestamps();
        });
        Schema::create('orders', function (Blueprint $table) {
            $table->id('id_order');
            $table->foreignId('user_id')->constrained('users', 'id_user')->onDelete('cascade');
            $table->decimal('total', 12);
            $table->enum('payment', ['cod', 'bca', 'bri', 'bni', 'mandiri', 'qris']);
            $table->string('shipping_address');
            $table->string('tracking_number')->unique();
            $table->enum('status', ['paid', 'pending', 'complete', 'cancelled'])->default('pending');
            $table->timestamps();
        });
        Schema::create('order_items', function (Blueprint $table) {
            $table->id('id_item');
            $table->foreignId('order_id')->constrained('orders', 'id_order')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products', 'id_product')->onDelete('cascade');
            $table->foreignId('variant_id')->constrained('product_variants', 'id_variant')->onDelete('cascade');
            $table->integer('qty');
            $table->decimal('price', 12);
            $table->decimal('subtotal', 12);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_variants');
        Schema::dropIfExists('carts');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('order_items');
    }
};
