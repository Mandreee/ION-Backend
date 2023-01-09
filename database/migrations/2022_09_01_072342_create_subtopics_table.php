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
        Schema::create("sub_topics", function (Blueprint $table) {
            $table->id();
            $table->string("sub_topic_title", 60)->unique();
            $table->string("sub_topic_slug", 200);
            $table->bigInteger("added_at", false, true); //Unsigned big integer, not auto increment
            $table->bigInteger("updated_at", false, true)->nullable(); //Unsigned big integer, not auto increment
            $table->unsignedBigInteger("topic_id", false)->nullable(true);
            $table->foreign("topic_id")->references("id")->on("topics")->onUpdate("cascade")->onDelete("set null");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subtopics');
    }
};
