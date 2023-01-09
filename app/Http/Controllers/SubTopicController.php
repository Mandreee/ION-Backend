<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubTopics;
use App\Models\Topics;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Support\Facades\DB;

class SubTopicController extends Controller
{
    private function SubTopicWithCondition(string $column, $input)
    {
        return SubTopics::where($column, $input)->first();
    }

    function index()
    {
        $subtopics = SubTopics::all();
        return response()->json(["sub_topics" => $subtopics, "status" => "Success", "message" => "List of sub topics"], 202);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function show(string $sub_topic_slug)
    {
        $subtopics = SubTopics::where("sub_topic_slug", $sub_topic_slug)->first();
        return response()->json(["sub_topics" => $subtopics, "status" => "Success", "message" => "Successfully sub topic"], 202);
    }
    public function showSubTopicsByTopic(string $topic_slug)
    {
        $topic_id = Topics::where("topic_slug", $topic_slug)->first()->id;
        if (SubTopics::where("topic_id", $topic_id)) {
            $sub_topic = SubTopics::where("topic_id", intval($topic_id))->get();
            return response($sub_topic, 202);
        } else {
            return abort(404, "Sub topic is not found");
        }
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function showById($id)
    {
        $subtopics = SubTopics::where("id", intval($id))->first();
        return response()->json(["sub_topics" => $subtopics, "status" => "Success", "message" => "Successfully sub topic"], 202);
    }

    /**
     * @param \Illuminate\Http\Request @request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): JsonResponse
    {
        $lower_str = strtolower($request->input("sub_topic_title"));
        $no_whitespace = preg_replace("/\s+/", "-", $lower_str);
        $added_at = round(microtime(true) * 1000);
        $sub_topic_title = ucwords($request->input("sub_topic_title"));
        $data["sub_topic_title"] = $sub_topic_title;
        $data["sub_topic_slug"] = (string)$no_whitespace;
        $data["added_at"] = $added_at;
        $data["updated_at"] = 0;
        $data["topic_id"] = intval($request->input("topic_id"));
        $response = null;
        $validator = Validator::make($request->all(), [
            "sub_topic_title" => "required|unique:sub_topics",
            "topic_id" => "required",
        ]);
        if ($validator->fails()) {
            $response = response()->json(["status" => "Fail", "status_code" => 422, "message" => $validator->errors()], 422);
        } else {
            try {

                if (SubTopics::where("sub_topic_title", $sub_topic_title)->first() != null) {
                    $response = response()->json(["data" => $data, "status" => "Failed", "status_code" => 409, "message" => "Sub topic can not be created"], 409);
                } else {
                    SubTopics::create($data);
                    $response = response()->json(["data" => $data, "status" => "Succcess", "status_code" => 200, "message" => "Succedd to create a sub topic"], 200);
                }
            } catch (\Illuminate\Database\QueryException $th) {
                $response = response()->json(["message", "status_code" => 404, "message" => "Topic id is not found"], 404);
            }
        }

        return $response;
    }

    /**
     * @param \Illuminate\Http\Request @request
     *@return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $sub_topic_title = $request->sub_topic_title;
        $sub_topic_title_capitalize = ucwords($sub_topic_title);
        $sub_topic_slug = preg_replace("/\s+/", "-", strtolower($sub_topic_title_capitalize));
        $updated_at = round(microtime(true) * 1000);
        $topic_id = intval($request->topic_id);
        $sub_topic_update = SubTopics::findOrFail($id);
        $array_update = array(
            "sub_topic_title" => $sub_topic_title_capitalize,
            "sub_topic_slug" => $sub_topic_slug,
            "updated_at" => $updated_at,
            "topic_id" => $topic_id
        );
        $response = null;
        $validator = Validator::make($request->all(), [
            "sub_topic_title" => "required|unique:sub_topics",
            "topic_id" => "required"
        ]);
        if ($validator->fails()) {
            $response = response()->json(["status" => "Fail", "status_code" => 422, "message" => $validator->errors()], 422);
        } else {
            if ($this->SubTopicWithCondition("id", $id) != null) {
                $sub_topic = SubTopics::find($id);
                if ($id == $sub_topic->id) {
                    $sub_topic->fill($array_update);
                    $sub_topic->save();
                    $response = response()->json(["sub_topics" => $array_update, "status" => "Success", "status_code" => 200, "message" => "Successfully update sub topic"], 200);
                } else {
                    $response =  response()->json(["sub_topics" => $array_update, "status" => "Failed", "status_code" => 409, "message" => "Sub topic can not be updated"], 409);
                }
            } else {
                $sub_topic_update->fill($array_update);
                $sub_topic_update->save();
                $response = response()->json(["sub_topics" => $sub_topic_update, "status" => "Success", "status_code" => 200, "message" => "Successfully update sub topic"], 200);
            }
        }
        return $response;
    }

    public function delete($id)
    {
        $subtopics = SubTopics::findOrFail(intval($id));
        if ($subtopics) {
            $subtopics->delete();
            return response(["sub_topics" => $subtopics, "status" => "Successfully", "status_code" => 200, "message" => "Successfully update sub topic"], 200);
        }
    }
}
