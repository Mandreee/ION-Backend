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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string("author_description")->nullable();
            $table->string("role")->nullable();
            $table->bigInteger("balance_account_number")->unique()->nullable();
            $table->unsignedDouble("balance", 12, 2)->nullable();
            $table->string("photo_profile_link", 150)->nullable();
            $table->string("photo_profile_name", 150)->nullable();
            $table->string("photo_profile_path")->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
