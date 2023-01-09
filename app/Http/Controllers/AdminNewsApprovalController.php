<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Models\AdminNewsApproval;
use App\Models\SubTopics;
use App\Models\User;
use App\Models\News;
use App\Models\Topics;

class AdminNewsApprovalController extends Controller
{
    private string $randomTitle = "";
    public function __construct()
    {
        $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $randomstring = substr(md5(str_shuffle($characters)), 0, 7);
        $this->randomTitle = $randomstring;
    }
    public function getRandomTitle(): string
    {
        return $this->randomTitle;
    }
    public function makeApproval(Request $request, $user_id)
    {
        $response = null;
        $image_file = $request->file("image_file");
        $file_name = $image_file->getClientOriginalName();
        $direct_file = $image_file->getClientOriginalName();
        $directory = "storage";
        $news_title = ucwords($request->news_title);
        $news_content = $request->news_content;
        $file_path_info = pathinfo($file_name);
        $base_name = $file_path_info["filename"];
        $validator = Validator::make($request->all(), [
            "news_title" => "required|unique:admin_news_approval",
            "news_content" => "required",
            "image_file" => "required|image:jpeg,png,jpg|max:5500",
            "sub_topic_id" => "required"
        ]);
        $news_data["news_title"] = $news_title;
        $news_data["news_content"] = $news_content;
        $testobj = new AdminNewsApprovalController();
        $news_data["news_slug"] = preg_replace("/\s+/", "-", strtolower($news_title)) . '-' . $testobj->getRandomTitle();
        if ($validator->fails()) {
            $response = response()->json(["status" => "Fail", "status_code" => 422, "message" => $validator->errors()], 422);
        }
        if (!SubTopics::find($request->sub_topic_id) && !User::find(intval($user_id))) {
            return response()->json(["message" => "Sub topic is not found and user id is not found"], 404);
        } else {
            $counter = 1;
            if (AdminNewsApproval::where("user_id", intval($user_id))->count() >= 2) {
                $response = response()->json(["authors" => $news_data, "status" => "Fail", "status_code" => 409, "message" => "You have created news more than two times"], 409);
            } else {
                $extension_test = File::extension($directory . "/" . "news_image/" . $file_name);
                $current_counter_file = $base_name . "_" . $counter  . "." . $extension_test;
                if (File::exists($directory . "/" . "news_image/" . $file_name)) {
                    if (File::exists($directory . "/" . "news_image/" . $current_counter_file)) {
                        do {
                            $next_counter_file = $base_name . "_" . $counter  . "." . $extension_test;
                            $current_counter_file = $next_counter_file;
                            $counter++;
                        } while (File::exists($directory . "/" . "news_image/" . $current_counter_file));
                        $file_name =  $current_counter_file;
                    } else {
                        $file_name = $current_counter_file;
                    }
                } else {
                    $file_name = $direct_file;
                }
                $image_url_directory = stripslashes($request->schemeAndHttpHost() . "/" . $directory . "/news_image" . "/" . $file_name);
                $news_data["news_picture_link"] = $image_url_directory;
                $news_data["news_picture_name"] = $file_name;
                $news_data["news_picture_path"] = preg_replace("/\s+/", "", strtolower("storage/news_image"));
                $news_data["sub_topic_id"] = $request->sub_topic_id;
                $news_data["user_id"] = intval($user_id);
                File::move($image_file, $directory . "/" . "news_image/" . $file_name);
                AdminNewsApproval::create($news_data);
                $response = response()->json(["authors" => $news_data, "status" => "Success", "status_code" => 200, "message" => "You create a news. Please wait until approved"], 200);
            }
        }
        return $response;
    }
    public function showAdminNewsApproval()
    {
        DB::enableQueryLog();
        $approval_list = DB::table("admin_news_approval")
            ->join("users", "users.id", "=", "admin_news_approval.user_id")
            ->join("sub_topics", "sub_topics.id", "=", "admin_news_approval.sub_topic_id")
            ->join("topics", "topics.id", "=", "sub_topics.topic_id")
            ->where("users.role", "author")
            ->select(
                "admin_news_approval.id",
                "admin_news_approval.news_title",
                "admin_news_approval.news_content",
                "admin_news_approval.news_picture_link",
                "admin_news_approval.news_picture_name",
                "sub_topics.sub_topic_title",
                "sub_topics.topic_id",
                "topics.topic_title",
                "users.name",
                "users.author_description",
                "users.photo_profile_link",
                "users.id as user_id"
            )
            ->get();
        // dd(DB::getQueryLog());
        // $approval_list_test = DB::select((DB::raw("SELECT `admin_news_approval.*` FROM `admin_news_approval INNER JOIN `")));
        return response()->json(["admin_news_approval" => $approval_list, "topics" => "", "status_code" => 200], 200);
    }
    public function updateBalance(int $user_id)
    {
        DB::table('users')
            ->where('id', $user_id)
            ->update([
                'balance' => DB::raw('balance + 5000')
            ]);
    }
}
