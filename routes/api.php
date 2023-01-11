<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\SubTopicController;
use App\Http\Controllers\AdminApprovalController;
use App\Http\Controllers\AdminNewsApprovalController;
use App\Http\Controllers\ApprovalEmailNotificationController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\NewsApprovalEmailNotificationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

Route::get("/token", function (Request $request) {
    return $request->session()->token();
});

// Route::put('/register/approve/{user_id}', [UserController::class, "approve"]);

// User Routes
Route::post("user/profile/{user_id}", [UserController::class, "updateUser"]); //update user
Route::post("user/author_balance_account/{user_id}", [UserController::class, "createAuthorReceivingAccount"]);
Route::get("userprofile/{id}", [UserController::class, "userProfile"]);
Route::get("userprofile/photo_profile/{id}", [UserController::class, "openPhotoProfile"]);

// Authentication Routes
Route::post('/login/admin', [UserController::class, "loginAdmin"]);
Route::post('/login/user', [UserController::class, "loginUser"]);
Route::post("user/register", [UserController::class, "register"]);
Route::post('/registeradmin', [UserController::class, 'registerAdmin']);
Route::get("/authors", [UserController::class, "showAllAuthors"]);
Route::delete("/deleteUser/{id}", [UserController::class, "deleteUser"]);
// News Routes
Route::get("news/topics", [NewsController::class, "showNewsByTopics"]);
Route::get("news/topics/{topic_slug}", [NewsController::class, "showNewsByOneTopic"]); //Show news by a topic
Route::get("news/topics/sub_topics/{sub_topic_slug}", [NewsController::class, "showNewsBySubTopicsAndTopics"]);
Route::get("news/open_news/{news_slug}", [NewsController::class, "readingNews"]);
Route::get("news/user/{id}", [NewsController::class, "showNewsByUserId"]);
Route::get("news", [NewsController::class, "index"]);
Route::get("news/update/{id}", [NewsController::class, "detail"]); // goblok
Route::get("/news/exists_or_not/{user_id}", [NewsController::class, "checkNewsExist"]);
Route::get("news/openpicture/{news_id}", [NewsController::class, "openNewsPicture"]); //Take blob
Route::get("news/search_news/{keywordparam}", [NewsController::class, "searchNewsByNewsTitle"]);
// Route::get("news//", [NewsController::class, ""]);
Route::post("news/{news_id}", [NewsController::class, "updateNews"]);
Route::delete("news/{news_id}", [NewsController::class, "delete"]);

Route::get("/sub_topics", [SubTopicController::class, "index"]);
Route::get("/sub_topics/{sub_topic_slug}", [SubTopicController::class, "show"]);
Route::get("/sub_topics/topic/{topic_slug}", [SubTopicController::class, "showSubTopicsByTopic"]);
Route::get("/sub_topics/show_by_id/{id}", [SubTopicController::class, "showById"]);
Route::post("/sub_topics", [SubTopicController::class, "store"]);
Route::put("/sub_topics/{id}", [SubTopicController::class, "update"]);
Route::delete("/sub_topics/{id}", [SubTopicController::class, "delete"]);
// Topics Route
Route::get("/topics", [TopicController::class, "index"]);
Route::get("/topics/{topic_slug}", [TopicController::class, "show"]);
Route::get("/topics/showbyid/{id}", [TopicController::class, "showById"]);
Route::post("/topics", [TopicController::class, "save"]);
Route::put("/topics/{id}", [TopicController::class, "update"]);
Route::delete("/topics/{id}", [TopicController::class, "delete"]);
Route::get("/history/{id}", [HistoryController::class, "index"]);
Route::post("/history/{user_id}/{news_id}", [HistoryController::class, "store"]);
Route::delete("/history/{id}", [HistoryController::class, "delete"]);

Route::post("/logout", [AuthController::class, "signout"]);
//Render Pages In Admin NewsDashboard
Route::get("/rendercomponents/{user_id}", [Controller::class, "renderComponentsInAuthorNewsDashboard"]);

// Admin Approval Routes
Route::get("/adminapproval/author", [AdminApprovalController::class, "listAdminApproval"]);
Route::post("/adminapproval/author/{user_id}", [AdminApprovalController::class, "makeApproval"]);
Route::prefix("adminapproval/author")->group(function () {
    route::post("/approve/{id}", [AuthorController::class, "approve"]);
    route::post("/reject/{id}", [AuthorController::class, "reject"]);
});
Route::get("/adminapproval/news", [AdminNewsApprovalController::class, "showAdminNewsApproval"]);
Route::post("/adminapproval/news/{user_id}", [AdminNewsApprovalController::class, "makeApproval"]);
Route::post("/adminapproval/news/balance/{user_id}", [AdminNewsApprovalController::class, "updateBalance"]);
Route::prefix("adminapproval/news")->group(function () {
    route::post("/approve/{approval_id}", [NewsController::class, "approve"]);
    route::post("/reject/{approval_id}", [NewsController::class, "reject"]);
});
Route::middleware("auth:sanctum")->group(function () {
});
