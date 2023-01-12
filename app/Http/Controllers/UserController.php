<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Models\User;
use App\Models\AdminApproval;
use App\Models\News;

class UserController extends Controller
{

    public function showAllAuthors()
    {
        $authors = User::where("role", "author")->get();
        return response()->json($authors, 200);
    }

    public function registerAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = User::create(["name" => $request->name, "email" => $request->email, 'password' => $request->password, "role" => "admin"]);
        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|email|max:100|unique:users',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = User::create(["name" => $request->name, "email" => $request->email, 'password' => $request->password]);
        return response()->json(
            [
                'message' => 'User successfully registered',
                'user' => $user["id"],
            ],
            200
        );
    }

    public function loginAdmin(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $user = User::where(['email' => $email, 'password' => $password])->first();
        if ($user) {
            if ($user->role == 'admin') {
                return response()->json(['status' => 'sukses', "user" => $user->id]);
            } else {
                return response()->json(['status' => "success", "messages" => "You are not admin"], 401);
            }
        } else {
            return response()->json(['status' => 'user tidak ditemukan', "messages" => ["Email is wrong", "Password is wrong"]], 400);
        }
    }

    public function loginUser(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $validation = Validator::make($request->all(), [
            'email' => 'required|email|max:100',
            'password' => 'required|string|min:6',
        ]);
        if ($validation->fails()) {
            return response()->json(['status' => "fail", "rule_error_messages" => $validation->errors()->toJson()], 400);
        } else {
            if (!(User::where(["email" => $email], ["password" => $password])->first())) {
                return response()->json(['status' => "fail", "error_type" => "credential errors", "validation_messages" => json_encode(["email" => ["Email is wrong"], "password" => ["Password is wrong"]])], 401);
            }
            if (!(User::where("email", $email)->first())) {
                return response()->json(['status' => "fail", "error_type" => "credential errors", "validation_messages" => json_encode(["email" => ["Email is wrong"]])], 401);
            }
            if (User::where("email", $email)->first()) {
                $passwordfrom_record = User::where("email", $email)->first()->password;
                if ($passwordfrom_record != $password) {
                    return response()->json(['status' => "fail", "error_type" => "credential errors", "validation_messages" => json_encode(["password" => ["Password is wrong"]])], 401);
                }
            }
            if (User::where(['email' => $email, 'password' => $password])->first()) {
                return response()->json(['status' => 'sukses', "user" => User::where(['email' => $email, 'password' => $password])->first()->id], 200);
            }
            if (User::where(['email' => $email, 'password' => $password])->first() && User::where(['email' => $email, 'password' => $password])->first()->role == "admin") {
                return response()->json(['status' => "fail", "error_type" => "admin is not authorized", "message" => "You are not authorized"], 401);
            }
        }
    }
    // public function approve(Request $request, $user_id)
    // {
    //     DB::table('users')
    //         ->where('id', $user_id)
    //         ->update([
    //             'role' => "author"
    //         ]);
    // }
    public function updateUser(Request $request, int $user_id)
    {
        $user = User::find($user_id);
        $validator = Validator::make($request->all(), [
            "image_file" => "image:jpg,jpeg,png|max:5500"
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 404);
        } else {
            $user_name = $request->name;
            $image_file = $request->file("image_file");
            $author_description = $request->author_desc;
            $file_name = $image_file->getClientOriginalName();
            $file_info = pathinfo($file_name);
            $base_name = $file_info["filename"];
            $extension = $image_file->getClientOriginalExtension();
            $count = 1;
            $current_count_file = $base_name . "_" . $count . $extension;

            if (File::exists($user->photo_profile_path . "/" . $user->photo_profile_name)) {
                File::delete($user->photo_profile_path . "/" . $user->photo_profile_name);
            }
            if (File::exists($user->photo_profile_path . "/" . $file_name)) {
                if (File::exists($user->photo_profile_name . "/" . $current_count_file)) {
                    do {
                        $next_count_file = $base_name . "_" . $count . $extension;
                        $current_count_file = $next_count_file;
                        $count++;
                    } while (File::exists($user->photo_profile_path . "/" . $current_count_file));
                    $file_name = $current_count_file;
                } else {
                    $file_name = $current_count_file;
                }
            }
            File::copy($image_file, $user->photo_profile_path . "/" . $file_name);
            $data = array(
                "name" => $user_name,
                "author_description" => $author_description,
                "photo_profile_link" => $request->schemeAndHttpHost() . "/" . $user->photo_profile_path . "/" . $file_name,
                "photo_profile_name" => $file_name,
                "photo_profile_path" => "storage/photo_profile",
            );
            $user->update($data);
        }
    }
    public function userProfile($id)
    {
        $author = User::find($id);
        $admin_approval = AdminApproval::where("user_id", $id)->first();
        return response()->json(["author" => [$author], "admin_approval" => $admin_approval], 202);
    }
    public function deleteUser($id)
    {
        try {
            $author = User::find($id);
            if ($author == null){
                return response()->json('Data User Tidak Ditemukan', 404);
            }
            $author->delete();
            return response()->json('Data User Berhasil Dihapus', 200);
        }catch (\Exception $exception){
                return response()->json('Data User Tidak Ditemukan', 404);
        }
    }

    public function createAuthorReceivingAccount(Request $request, int $user_id)
    {
        $validator = Validator::make($request->all(), [
            "account_number" => "required|numeric|digits_between:9,20"
        ]);
        if (!User::where("id", $user_id)->first()) {
            return response("User is not found", 404);
        }
        if (User::where("id", $user_id)->first()) {
            if ($validator->fails()) {
                return response()->json($validator->errors()->toJson(), 422);
            } else {
                $user = User::find($user_id);
                $user->update([
                    "balance_account_number" => $request->account_number,
                    "balance" => 0.00,
                ]);
                return response("Your money receiving account has created", 202);
            }
        }
    }
    public function openPhotoProfile($user_id)
    {
        $user = User::find($user_id);
        $header = array(
            header("Content-Type: " . File::mimeType($user->photo_profile_path . "/" . $user->photo_profile_name)),
            header(
                "Content-Length: " . File::size($user->photo_profile_path . "/" . $user->photo_profile_name),
            ),
            header("Access-Control-Allow-Origin: *")
        );
        return readfile($user->photo_profile_path . "/" . $user->photo_profile_name);
    }
}
