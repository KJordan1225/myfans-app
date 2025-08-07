<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */ 
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subscriber_id')->constrained('users')->cascadeOnDelete()->nullable();
            $table->foreignId('creator_id')->constrained('users')->unique()->cascadeOnDelete()->nullable();
            $table->string('stripe_customer_id')->default('not yet given');
            $table->string('stripe_subscription_id')->default('not yet given');
            $table->string('stripe_status')->default('active');
            $table->string('plan_name')->default('none given');
            $table->decimal('amount', 10, 2)->default(0.00);
            $table->string('interval')->default('month');
            $table->string('product_id')->nullable();
            $table->string('price_id')->nullable();
            $table->timestamp('renews_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }

};
