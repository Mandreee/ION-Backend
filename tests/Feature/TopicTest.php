<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TopicTest extends TestCase
{
    /**
     * Test show lists of topics
     * @return void
     */
    public function test_show_topics()
    {
        $this->json("GET", "api/topics")->assertStatus(202);
    }

    /**
     * Show a topic topicid
     * @return void
     */
    public function test_show_topic_id()
    {
        $this->json("GET", "api/topics/3")->assertStatus(202);
    }
    /**
     * Test add a topic
     * @return void
     */
    public function test_save_topic()
    {
        $topic_input = array(
            "topic_title" => "Unit Test Again 1"
        );
        $response = $this->json("POST", "api/topics", $topic_input, ["Accept" => "application/json"]);

        $response->assertStatus(201)->assertJsonStructure([
            "topics" => [
                "topic_title",
                "topic_slug",
                "added_at",
                "updated_at",
            ],
            "status",
            "message"
        ]);
    }

    public function test_update_topic()
    {
        $topic_input = array(
            "topic_title" => "Unit Test Again 1"
        );
        $response = $this->json("PATCH", "api/topics/3", $topic_input, ["Accept" => "application/json"]);
        $response->assertStatus(202)->assertJsonStructure([
            "topics" => [
                "topic_title",
                "topic_slug",
                "updated_at",
            ],
            "status",
            "message"
        ]);
    }
    // public function test_delete_topic()
    // {
    //     $response = $this->deleteJson("api/topics/3", [], ["Application" => "application/json"]);
    //     $response->assertStatus(202)->assertJsonStructure([
    //         "topic" => [
    //             "id",
    //             "topic_title",
    //             "topic_slug",
    //             "added_at",
    //             "updated_at",
    //         ],
    //         "status",
    //         "message"
    //     ]);
    // }
}
