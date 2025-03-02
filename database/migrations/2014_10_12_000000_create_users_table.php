<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration {
    public function up()
    {
        // Таблица пользователей (только покупатели)
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });

        // Таблица администраторов
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });

        // Таблица категорий товаров
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // Таблица товаров
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('stock')->default(0);
            $table->string('image')->nullable(); // Новое поле для изображения
            $table->timestamps();
        });

        // Таблица заказов
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('total_price', 10, 2);
            $table->string('status')->default('pending');
            $table->timestamps();
        });

        // Таблица элементов заказа
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });

        // Заполнение таблиц начальными данными
        DB::table('categories')->insert([
            ['name' => 'TV'],
            ['name' => 'Headphones']
        ]);

        DB::table('products')->insert([
            ['category_id' => 1, 'name' => 'Samsung TV', 'description' => '4K UHD Smart TV', 'price' => 500.00, 'stock' => 10],
            ['category_id' => 1, 'name' => 'LG OLED TV', 'description' => 'OLED Display with AI', 'price' => 1200.00, 'stock' => 5],
            ['category_id' => 1, 'name' => 'Sony Bravia', 'description' => 'Ultra HD Android TV', 'price' => 900.00, 'stock' => 7],
            ['category_id' => 1, 'name' => 'TCL Roku TV', 'description' => 'Smart TV with Roku OS', 'price' => 400.00, 'stock' => 12],
            ['category_id' => 1, 'name' => 'Philips Ambilight', 'description' => 'Unique Ambilight technology', 'price' => 800.00, 'stock' => 6],
            ['category_id' => 2, 'name' => 'Sony WH-1000XM4', 'description' => 'Noise Cancelling Headphones', 'price' => 300.00, 'stock' => 15],
            ['category_id' => 2, 'name' => 'Bose 700', 'description' => 'Wireless Bluetooth Headphones', 'price' => 350.00, 'stock' => 10],
            ['category_id' => 2, 'name' => 'Apple AirPods Max', 'description' => 'Over-ear Noise Cancelling', 'price' => 500.00, 'stock' => 8],
            ['category_id' => 2, 'name' => 'Sennheiser HD 560S', 'description' => 'Open-Back Audiophile Headphones', 'price' => 200.00, 'stock' => 20],
            ['category_id' => 2, 'name' => 'JBL Quantum 800', 'description' => 'Gaming Wireless Headset', 'price' => 250.00, 'stock' => 12]
        ]);

        DB::table('users')->insert([
            ['name' => 'User One', 'email' => 'user1@example.com', 'password' => Hash::make('123456')],
            ['name' => 'User Two', 'email' => 'user2@example.com', 'password' => Hash::make('123456')]
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('admins');
        Schema::dropIfExists('users');
    }
};
