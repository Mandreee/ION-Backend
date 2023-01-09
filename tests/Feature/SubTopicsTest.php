<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubTopicsTest extends TestCase
{

    /**
     * A basic feature test example.
     * @return void
     */
    public function test_show_subtopic_from_database()
    {
    }

    /**
     * A basic feature test example.
     * @return void
     */
    public function delete_subtopic_from_database()
    {
        $this->json("DELETE", "api/sub_topics/2")->assertStatus(202);
    }
}
