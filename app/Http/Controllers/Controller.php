<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\AdminApproval;
use App\Models\AdminNewsApproval;
use App\Models\User;
use App\Models\News;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    /**
     * success response method
     * @return \Illuminate\Http\Response;
     */
    public function renderComponentsInAuthorNewsDashboard(int $user_id)
    {
        $approval = AdminApproval::join("users", "users.id", "=", "admin_approval.user_id")
            ->where("admin_approval.user_id", $user_id)->select("admin_approval.*", "users.name", "users.role", "users.balance_account_number")
            ->get();
        $user = User::where("users.id", $user_id)->select("id", "name", "role", "balance_account_number", "balance")->first();
        $news = News::join("users", "users.id", "=", "news.user_id")->where("news.user_id", $user_id)->select("news.*", "users.id", "users.name", "users.balance_account_number")->get();
        $news_approval = AdminNewsApproval::where("user_id", $user_id)->get();
        $news_total = News::where("user_id", $user_id)->count();
        return response()->json(["news_approval" => $news_approval, "news" => $news, "news_total" => $news_total, "approval" => $approval, "user" => $user], 202);
    }
}
