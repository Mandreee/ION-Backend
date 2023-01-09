<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\AdminApproval;
use Illuminate\Support\Facades\File;

class AdminApprovalController extends Controller
{

    public function makeApproval(Request $request, $user_id)
    {
        $date_now = round(microtime(true) * 1000);
        $response = null;
        $image_file = $request->file("image_file");
        $file_name = $image_file->getClientOriginalName();
        $direct_file = $image_file->getClientOriginalName();
        $file_path_info = pathinfo($file_name);
        $base_name = $file_path_info["filename"];
        $directory = "storage";
        $author_description = $request->author_description;
        $validator = Validator::make($request->all(), [
            "image_file" => "required|image:jpeg,png,jpg|max:5500",
            "author_description" => "required",
        ]);
        $author_data["author_description"] = $author_description;
        $author_data["join_at"] = $date_now;
        $author_data["user_id"] = intval($user_id);
        if (($validator->fails() && str_word_count($author_description, 0) <= 6)) {
            $response = response()->json([
                "status" => "Fail", "status_code" => 422, "message" => $validator->errors()->toJson()
            ], 422);
        } else {
            if (!(AdminApproval::where("user_id", $user_id)->first())) {
                $counter = 1;
                $extension_test = File::extension($file_name);
                $current_counter_file = $base_name . "_" . $counter  . "." . $extension_test;
                if (File::exists($directory . "/" . "photo_profile/" . $file_name)) {
                    if (File::exists($directory . "/" . "photo_profile/" . $current_counter_file)) {
                        do {
                            $next_counter_file = $base_name . "_" . $counter  . "." . $extension_test;
                            $current_counter_file = $next_counter_file;
                            $counter++;
                        } while (File::exists($directory . "/" . "photo_profile/" . $current_counter_file));
                        $file_name =  $current_counter_file;
                    } else {
                        $file_name = $current_counter_file;
                    }
                    File::move($image_file, $directory . "/" . "photo_profile/" . $file_name);
                } else {
                    $file_name = $direct_file;
                }
                $image_url_directory = stripslashes($request->schemeAndHttpHost() . "/" . $directory . "/photo_profile" . "/" . $file_name);
                $author_data["photo_profile_link"] = $image_url_directory;
                $author_data["photo_profile_name"] = $file_name;
                $author_data["photo_profile_path"] = preg_replace("/\s+/", "", strtolower("storage/photo_profile"));
                try {
                    AdminApproval::create($author_data);
                } catch (\Illuminate\Database\QueryException $e) {
                    $response = response()->json(["message" => json_encode(["id" => [$e->getMessage()]])], 500);
                }
                $response = response()->json(["authors" => $author_data, "status" => "Success", "message" => "You have signigned to join as author. Please wait until you are approved"], 202);
            } else {
                return abort(409, "You have requested to join");
            }
        }
        return $response;
    }
    public function listAdminApproval()
    {
        $listdmin = DB::table("admin_approval")->join("users", "users.id", "=", "admin_approval.user_id")
            ->select("admin_approval.*", "users.name", "users.email")->get();
        return response()->json(["admin_approval" => $listdmin], 200);
    }
}
