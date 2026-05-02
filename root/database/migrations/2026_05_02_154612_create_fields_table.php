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
        Schema::create('fields', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_version_id')->index();

            $table->string('name');
            $table->string('label');
            $table->string('type');

            $table->boolean('required')->default(false);
            $table->unsignedInteger('sort_order')->default(0);

            $table->string('placeholder')->nullable();
            $table->text('help_text')->nullable();

            $table->json('options')->nullable();
            $table->json('validation')->nullable();
            $table->json('meta')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->unique(['form_version_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fields');
    }
};
