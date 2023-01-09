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
        //
        Schema::create("admin_approval", function (Blueprint $table) {
            $table->id();
            $table->string("author_description");
            $table->string("photo_profile_link", 150)->nullable();
            $table->string("photo_profile_name", 150)->nullable();
            $table->string("photo_profile_path")->nullable();
            $table->unsignedBigInteger("join_at", false);
            $table->unsignedBigInteger("user_id", false)->nullable();
            $table->foreign("user_id")->references("id")->on("users")->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
