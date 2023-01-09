<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubTopics extends Model
{
    use HasFactory;
    protected $table = "sub_topics";
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sub_topic_title',
        'sub_topic_slug',
        'added_at',
        'updated_at',
        'topic_id'
    ];

    public function news_topics()
    {
        return $this->belongsTo(NewsTopics::class);
    }

    public function news()
    {
        return $this->hasMany(News::class);
    }
}
