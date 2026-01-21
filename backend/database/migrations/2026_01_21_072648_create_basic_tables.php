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
      
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps(); 
        });

       
        Schema::create('telegram_integrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shop_id')
                ->constrained('shops')
                ->cascadeOnDelete();

            $table->text('bot_token');
            $table->text('chat_id');
            $table->boolean('enabled')->default(true);

            $table->timestamps();
            $table->unique('shop_id');
        });

       
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shop_id')
                ->constrained('shops')
                ->cascadeOnDelete();

            $table->string('number');
            $table->decimal('total', 12, 2); 
            $table->string('customer_name');

            $table->timestamp('created_at')->useCurrent();
        });

        
        Schema::create('telegram_send_log', function (Blueprint $table) {
            $table->id();

            $table->foreignId('shop_id')
                ->constrained('shops')
                ->cascadeOnDelete();

            $table->foreignId('order_id')
                ->constrained('orders')
                ->cascadeOnDelete();

            $table->text('message');
            $table->enum('status', ['SENT', 'FAILED']);
            $table->text('error')->nullable();
            $table->timestamp('sent_at')->nullable();

            $table->unique(['shop_id', 'order_id']); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('basic_tables');
    }
};