<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostsPerDay extends Model
{
    protected $table = "users_postsperday";
    public $timestamps = false;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('\App\User', 'user_id', 'id');
    }
}