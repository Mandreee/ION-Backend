<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use App\Models\AdminApproval;
use App\Models\User;

class AdminApprovalController extends Controller
{
    public function makeApproval(Request $request, $id)
    {
        $date_now = round(microtime(true) * 1000);
        $response = null;
        $image_file = $request->file("image_file");
        $extension = $image_file->getExtension();
        $file_name = $image_file->getClientOriginalName();
        $file_name_ = explode(".", $file_name);
        $without_extension = $file_name[0];
        $directory = "storage";
        $author_description = $request->author_description;
        $url = config("app.url");
        $image_url_directory = stripslashes($url . "/" . $directory . "/photo_profile" . "/" . $file_name);
        // $store_image_url_directory_ = str_replace("\\", "", $url . "/" . $directory . "/photo_profile" . "/");

        $validator = Validator::make($request->all(), [
            "image_file" => "required|image:jpeg,png,jpg|max:5500",
            "author_description" => "required",
        ]);

        $author_data = array(
            "author_description" => $author_description,
            "photo_profile_link" => $image_url_directory,
            "photo_profile_name" => $file_name,
            "photo_profile_path" => preg_replace("/\s+/", "", strtolower("storage/photo_profile")),
            "join_at" => $date_now,
            "user_id" => intval($id),
        );
        if ($validator->fails()) {
            $response = response()->json(["status" => "Fail", "status_code" => 422, "message" => $validator->errors()], 422);
        } else {
            if (AdminApproval::where("user_id", $id)->first() == null) {
                $image_file->move($directory . "/" . "photo_profile", $file_name);
                AdminApproval::create($author_data);
                $response = response()->json(["authors" => $author_data, "status" => "Success", "message" => "You have signigned to join as author. Please wait until approved"], 201);
            } else {
                $response = response()->json(["authors" => $author_data, "status" => "Fail", "status_code" => 409, "message" => "Failed to create author account"], 409);
            }
        }

        return $response;
    }

    public function listAdminApproval()
    {
        $listdmin = DB::table("admin_approval")->join("users", "users.id", "=", "admin_approval.user_id")
            ->select("admin_approval.*", "users.name")->get();
        return response()->json(["admin_approval" => $listdmin], 200);
    }
}
