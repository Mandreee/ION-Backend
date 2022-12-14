<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topics;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\TopicsResource;
use Symfony\Component\HttpFoundation\JsonResponse;

// use App\Models\NewsSubTopics;
// use App\Http\Resources\NewsTopicsResource;
// use App\Models\News;

class TopicController extends Controller
{

    private function TopicWithCondition(string $column, $input)
    {
        return Topics::where($column, $input)->first();
    }

    public function index()
    {
        $topics = Topics::all();
        return response()->json(["topics" => $topics, "status" => "Success", "message" => "Succeed"], 202);
    }

    /**
     * @param \Illuminate\Http\Request @request
     * @return \Illuminate\Http\Response
     */
    public function show(Topics $topics)
    {
        return response()->json(["topics" => $topics, "status" => "Success", "message" => "Succeed show topic"], 202);
    }

    public function test()
    {
        DB::enableQueryLog();
        $topics = Topics::with("news")->get();
        DB::getQueryLog();
        return response()->json($topics, 200);
    }
    /**
     * @param \Illuminate\Http\Request @request
     * @return \Illuminate\Http\Response 
     */
    function save(Request $request): JsonResponse
    {
        $lower_case = strtolower($request->topic_title);
        $no_whitespace = preg_replace("/\s+/", "-", $lower_case);
        $added_at = round(microtime(true) * 1000);
        $topic_exist = Topics::where("topic_title", $request->topic_title)->first();
        $topic["topic_title"] = ucwords($request->topic_title);
        $topic["topic_slug"] = $no_whitespace;
        $topic["added_at"] = $added_at;
        $topic["updated_at"] = 0;
        $response = null;
        if ($topic_exist != null) {
            $response = response()->json(["topics" => $topic, "status" => "Fail", "message" => "Failed to create a topic"], 409);
        } else {
            $poststopic = Topics::create($topic);
            $response = response()->json(["topics" => $topic, "status" => "Success", "message" => "Succeed to add topic"], 201);
        }
        return $response;
    }

    /**
     * @param \Illuminate\Http\Request @request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): JsonResponse
    {
        $topic_title_capitalize = ucwords($request->input("topic_title"));
        $topic_slug = preg_replace("/\s+/", "-", strtolower($topic_title_capitalize));
        $updated_at = round(microtime(true) * 1000);
        $topic_update = Topics::findOrFail($id);
        $array_update = array(
            "topic_title" => $topic_title_capitalize,
            "topic_slug" => $topic_slug,
            "updated_at" => $updated_at,
        );
        $response = null;
        if ($this->TopicWithCondition("topic_title", $topic_title_capitalize) != null) {
            $json_encode = json_encode(Topics::where("topic_title", $topic_title_capitalize)->select("id", "topic_title")->get());
            $json_decode_id =  json_decode($json_encode)[0]->id;
            $json_decode_sub_topic_title =  json_decode($json_encode)[0]->topic_title;
            $json_encode_topic_byid = json_encode(Topics::where("id", $id)->select("id", "topic_title")->get());
            $json_decode_topic_byid =  json_decode($json_encode_topic_byid)[0]->id;
            if ($id == $json_decode_id && $topic_title_capitalize == $json_decode_sub_topic_title) {
                $topic_update->update($array_update);
                $response = response()->json(["topics" => $array_update, "status" => "Success", "message" => "Succedd to update"], 202);
            } else if ($id == $json_decode_topic_byid && $this->TopicWithCondition("topic_title", $topic_title_capitalize)->get() != null) {
                $response =  response()->json(["topics" => $array_update, "status" => "Fail", "message" => "Failed to update"], 409);
            }
        } else {
            $topic_update->update($array_update);
            $response = response()->json(["topics" => $array_update, "status" => "Success", "message" => "Succeed to update"], 202);
        }
        return $response;
    }

    public function delete($id): JsonResponse
    {
        $topics = Topics::findOrFail($id);
        $response = null;
        if ($topics != null) {
            $topics->delete();
            $response = response()->json(["topics" => $topics, "message" => "Data deleted successfully"], 200);
        }
        return $response;
    }
}