<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete('cascade');
            $table->string('title');
            $table->text('body')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->boolean('is_paid')->default(false);
            $table->enum('visibility', ['public', 'subscribers', 'paid'])->default('public');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
