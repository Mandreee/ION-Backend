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
            $table->string("news_title", 60)->unique();
            $table->longText("news_content");
            $table->string("news_slug", 20);
            $table->string("news_picture_link", 150);
            $table->string("news_picture_name", 50);
            $table->bigInteger("added_at", false, true);
            $table->bigInteger("updated_at", false, true);
            $table->string("news_status");
            $table->unsignedBigInteger("sub_topic_id", false)->nullable(true);
            $table->foreign("sub_topic_id")->references("id")->on("sub_topics")->onUpdate("cascade")->onDelete("set null");
            $table->unsignedBigInteger("author_id", false)->nullable(true);
            $table->foreign("author_id")->references("id")->on("authors")->onUpdate("cascade")->onDelete("cascade");
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