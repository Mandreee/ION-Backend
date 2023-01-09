<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class News extends Model
{
    use HasFactory;
    protected $table = 'news';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'news_title',
        'news_content',
        'news_slug',
        'news_picture_link',
        'news_picture_name',
        'news_picture_path',
        'added_at',
        'updated_at',
        'news_status',
        'sub_topic_id',
        'user_id'
    ];
    public function sub_topics()
    {
        return $this->belongsTo(NewsSubTopics::class);
    }
}
