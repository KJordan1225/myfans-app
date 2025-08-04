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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
					->constrained('users')
					->unique()
					->cascadeOnDelete();
			$table->string('display_name');
			$table->text('bio')->nullable();
            $table->string('avatar')->nullable();
            $table->string('banner')->nullable();
			$table->string('website')->nullable();
			$table->string('twitter')->nullable();
			$table->string('instagram')->nullable();
            $table->boolean('is_creator')->default(false);
            $table->string('stripe_id')->nullable();
            $table->decimal('balance', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
