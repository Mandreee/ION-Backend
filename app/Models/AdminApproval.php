<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class AdminApproval extends Model
{
    use HasFactory;
    protected $table = "admin_approval";
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'author_description',
        'photo_profile_link',
        'photo_profile_name',
        'photo_profile_path',
        'join_at',
        'user_id',
    ];

    public function user()
    {
        $this->belongsTo(User::class);
    }
}
