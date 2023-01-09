<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminNewsApproval extends Model
{
    use HasFactory;
    protected $table = "admin_news_approval";
    public $timestamps = false;
    protected $fillable = [
        'news_title',
        'news_content',
        'news_slug',
        'news_picture_link',
        'news_picture_name',
        'news_picture_path',
        'sub_topic_id',
        "user_id",
    ];
}
