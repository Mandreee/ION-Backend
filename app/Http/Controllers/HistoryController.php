<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\History;
use App\Models\News;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\TopicsResource;
use Symfony\Component\HttpFoundation\JsonResponse;

// use App\Models\NewsSubTopics;
// use App\Http\Resources\NewsTopicsResource;
// use App\Models\News;

class HistoryController extends Controller
{



    public function index($id = 'all')
    {
        if ($id == 'all') {
            $history = History::with('news', 'user')->get();
        } else {
            $history = History::with('news', 'user')->where('user_id', $id)->get();
        }
        return response()->json(["history" => $history, "status" => "Success", "message" => "Succeed"], 202);
    }

    public function store(int $user_id, int $news_id)
    {
        if (!isset($user_id)) {
            return response()->json(["status" => "Failed", "message" => "user_id empty"], 400);
        }
        if (!isset($news_id)) {
            return response()->json(["status" => "Failed", "message" => "news_id empty"], 400);
        }
        if (!User::find($user_id)) {
            return response()->json(["status" => "Failed", "message" => "user not found"], 400);
        }
        if (!News::find($news_id)) {
            return response()->json(["status" => "Failed", "message" => "news not found"], 400);
        }
        try {
            History::create([
                'user_id' => $user_id,
                'news_id' => $news_id
            ]);
            return response()->json(["status" => "Success", "message" => "History stored"], 200);
        } catch (\Exception $e) {
            return response()->json(["status" => "Failed", "message" => "DB Error"], 400);
        }
    }

    public function delete($id)
    {
        try {
            History::where('user_id', $id)->delete();
            return response()->json(["status" => "Success", "message" => "History deleted"], 200);
        } catch (\Exception $e) {
            return response()->json(["status" => "Failed", "message" => "DB Error"], 400);
        }
    }

    /**
     * @param \Illuminate\Http\Request @request
     * @return \Illuminate\Http\Response
     */
}
