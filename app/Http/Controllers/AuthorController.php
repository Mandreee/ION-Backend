<?php

namespace App\Http\Controllers;

use Illuminate\Notifications\Notification;
use Illuminate\Http\Request;
use App\Models\AdminApproval;
use App\Models\User;
use Illuminate\Support\Facades\File;
use App\Notifications\EmailApprovalNotification;
use Exception;
use Illuminate\Support\Facades\Notification as FacadesNotification;

class AuthorController extends Controller
{
    public function __construct()
    {
        // $this->middleware("throttle:1,1", ["except" => ["reject"]]);
    }
    /**
     * First, get admin approval id by user id in admin approval table
     * Second, delete a record by admin approval id in admin approval table
     * Last, create a new athor account 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function approve($id)
    {
        $admin_approval_user = AdminApproval::where("id", intval($id))->first();
        $json_decode_approval = json_decode($admin_approval_user);
        $directory = "storage/photo_profile";
        $delete_admin_approval = AdminApproval::findOrFail($admin_approval_user->id);
        $user = User::findOrFail(intval($admin_approval_user->user_id));
        $data = [
            "greeting" => "Creating Author Account Approval",
            "messages" => "Your request to create author account was approved, " . $user->name,
            "actionText" => "You already can create news now",
            "actionURL" => "http://localhost:3006/",
            "thanks" => "Thank you for your participation",
        ];
        $author_data = array(
            "author_description" => $admin_approval_user->author_description,
            "role" => "author",
            "photo_profile_link" => $admin_approval_user->photo_profile_link,
            "photo_profile_name" => $admin_approval_user->photo_profile_name,
            "photo_profile_path" => $admin_approval_user->photo_profile_path
        );
        try {
            $user->notify(new EmailApprovalNotification($data));
            $delete_admin_approval->delete();
            $user->update($author_data);
        } catch (Exception $th) {
            return response()->json($th->getMessage(), 400);
        }
        return response()->json(["authors" => $json_decode_approval, "status" => "Success", "succes_code" => 200, "message" => "Author has created"], 200);
    }

    /**
     * First, get admin approval id by user id in admin approval table
     * Second, delete a record by admin approval id in admin approval table
     * Last, cancel to create a new athor account 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reject($id)
    {
        $admin_approval_user_id = AdminApproval::where("id", intval($id))->first();
        $delete_admin_approval = AdminApproval::findOrFail($id);
        $user = User::findOrFail($admin_approval_user_id->user_id);
        $data = [
            "greeting" => "Creating Author Account Approval",
            "messages" => "Sorry, " . $user->name . "! Your request to create author account was rejected",
            "actionText" => "Join as an author again",
            "actionURL" => "http://localhost:3006/",
            "thanks" => "Thank you for your participation",
        ];
        $user->notify(new EmailApprovalNotification($data));
        // FacadesNotification::send($user, new EmailApprovalNotification($data));
        $delete_admin_approval->delete();
        if (File::exists($admin_approval_user_id->photo_profile_path . "/" . $admin_approval_user_id->photo_profile_name)) {
            File::delete($admin_approval_user_id->photo_profile_path . "/" . $admin_approval_user_id->photo_profile_name);
        }
        return response()->json(["admin_approval" => $delete_admin_approval, "status" => "Success", "status_code" => 200, "You have rejected to create an author account"], 200);
    }
}
