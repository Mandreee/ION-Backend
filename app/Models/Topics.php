<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topics extends Model
{
    use HasFactory;
    protected $table = "topics";

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'topic_title',
        'topic_slug',
        'added_at',
        'updated_at',
    ];


    public function subtopic()
    {
        return $this->hasMany(NewsSubTopics::class);
    }

    // Show News associated to news subtopic and topic
    public function news()
    {
        return $this->hasManyThrough(
            News::class,
            SubTopics::class,
            'topic_id',
            'sub_topic_id',
            'id',
            'id'
        );
    }
}
