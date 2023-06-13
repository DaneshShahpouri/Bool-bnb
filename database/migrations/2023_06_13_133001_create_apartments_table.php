<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->string('name');
            $table->text('description');
            $table->tinyInteger('rooms_number')->nullable();
            $table->tinyInteger('beds_number')->nullable();
            $table->tinyInteger('bathrooms_number')->nullable();
            $table->smallInteger('sqm')->nullable();
            $table->string('address');
            $table->decimal('latitude', 9, 6);
            $table->decimal('longitude', 10, 6);
            $table->string('cover_image')->nullable();
            $table->boolean('isVisible');
            $table->string('slug', 120)->unique();

            $table->timestamps();

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
        Schema::dropIfExists('apartments');
    }
};
