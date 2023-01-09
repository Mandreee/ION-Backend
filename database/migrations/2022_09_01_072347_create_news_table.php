<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {

        Schema::create("news", function (Blueprint $table) {
            $table->id();
            $table->string("news_title", 100);
            $table->longText("news_content");
            $table->string("news_slug", 20);
            $table->string("news_picture_link", 150);
            $table->string("news_picture_name", 100);
            $table->string("news_picture_path")->nullable();
            $table->bigInteger("added_at", false, true); //Unsigned big integer, not auto increment
            $table->bigInteger("updated_at", false, false)->nullable(); //Unsigned big integer, not auto increment
            $table->string("news_status");
            $table->unsignedBigInteger("sub_topic_id", false)->nullable(true);
            $table->foreign("sub_topic_id")->references("id")->on("sub_topics")->onUpdate("cascade")->onDelete("set null");
            $table->unsignedBigInteger("user_id", false)->nullable();
            $table->foreign("user_id")->references("id")->on("users")->onUpdate("cascade")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news');
    }
};
