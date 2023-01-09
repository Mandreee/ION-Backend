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
    public function show(string $topic_slug)
    {
        $topics = Topics::where("topic_slug", $topic_slug)->get();
        return response()->json(["topics" => $topics, "status" => "Success", "message" => "Succeed show topic"], 202);
    }

    public function showById(int $id)
    {
        $topics = Topics::where("id", intval($id))->first();
        return response()->json(["topics" => $topics, "status" => "Success", "message" => "Succeed show topic"], 202);
    }

    /**
     * @param \Illuminate\Http\Request @request
     * @return \Illuminate\Http\Response
     */
    function save(Request $request): JsonResponse
    {
        $lower_case = strtolower($request->input("topic_title"));
        $no_whitespace = preg_replace("/\s+/", "-", $lower_case);
        $added_at = round(microtime(true) * 1000);
        $topic_exist = Topics::where("topic_title", $request->input("topic_title"))->first();
        $topic["topic_title"] = ucwords($request->input("topic_title"));
        $topic["topic_slug"] = $no_whitespace;
        $topic["added_at"] = $added_at;
        $topic["updated_at"] = 0;
        $response = null;
        if ($topic_exist != null) {
            $response = response()->json(["topics" => $topic, "status" => "Fail", "status_code" => 409, "message" => "Failed to create a topic"], 409);
        } else {
            $poststopic = Topics::create($topic);
            $response = response()->json(["topics" => $topic, "status" => "Success", "status_code" => 201, "message" => "Succeed to add topic"], 201);
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
            "topic_title" => ucwords($request->input("topic_title")),
            "topic_slug" => $topic_slug,
            "updated_at" => $updated_at,
        );
        $response = null;
        $topic_update->update($array_update);
        $response = response()->json(["topics" => $array_update, "status" => "Success", "status_code" => 200, "message" => "Succeed to update"], 200);
        if ($this->TopicWithCondition("topic_title", $topic_title_capitalize) != null) {
            $json_encode = json_encode(Topics::where("topic_title", $topic_title_capitalize)->select("id", "topic_title")->get());
            $json_decode_id =  json_decode($json_encode)[0]->id;
            $json_decode_topic_title =  json_decode($json_encode)[0]->topic_title;
            $json_encode_topic_byid = json_encode(Topics::where("id", $id)->select("id", "topic_title")->get());
            $json_decode_topic_byid =  json_decode($json_encode_topic_byid)[0]->id;
            if ($id == $json_decode_id && $json_decode_topic_title == $topic_title_capitalize) {
                $topic_update->fill($array_update);
                $topic_update->save();
                $response = response()->json(["topics" => $array_update, "status" => "Success", "status_code" => 200, "message" => "Succedd to update"], 200);
            } else if ($id == $json_decode_topic_byid && $this->TopicWithCondition("topic_title", $topic_title_capitalize)->get() != null) {
                $response =  response()->json(["topics" => $array_update, "status" => "Fail", "status_code" => 409, "message" => "Failed to update"], 409);
            }
        } else {
            $topic_update->fill($array_update);
            $topic_update->save();
            $response = response()->json(["topics" => $array_update, "status" => "Success", "status_code" => 200, "message" => "Succeed to update"], 200);
        }
        return $response;
    }

    public function delete($id): JsonResponse
    {
        $topics = Topics::findOrFail($id);
        $response = null;
        if ($topics != null) {
            $topics->delete();
            $response = response()->json(["topics" => $topics, "status" => "Success", "status_code" => 200, "message" => "Data deleted successfully"], 200);
        }
        return $response;
    }
}
