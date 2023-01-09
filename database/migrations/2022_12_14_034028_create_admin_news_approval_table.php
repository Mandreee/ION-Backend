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
        Schema::create('admin_news_approval', function (Blueprint $table) {
            $table->id();
            $table->string("news_title")->unique();
            $table->string("news_content", 100);
            $table->string("news_slug", 60);
            $table->string("news_picture_link", 150);
            $table->string("news_picture_name", 50);
            $table->string("news_picture_path")->nullable();
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
        Schema::dropIfExists('admin_news_approval');
    }
};
