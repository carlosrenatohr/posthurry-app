<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blasting extends Model
{
    //
    protected $table = 'blasting';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('\App\User', 'user_id', 'id');
    }

    public function getGroupsAttribute() {
        return (!empty($this->groups_names)) ? explode('\,/', $this->groups_names) : '';
    }

    public function getGroupsPostsAttribute() {
        return (!empty($this->groups_published_id)) ? explode('\,/', $this->groups_published_id) : '';
    }

    public function getPagesAttribute() {
        return (!empty($this->pages_names)) ? explode('\,/', $this->pages_names) : '';
    }

    public function getPagesPostsAttribute() {
        return (!empty($this->pages_published_id)) ? explode('\,/', $this->pages_published_id) : '';
    }

    public function getIsTodayAttribute() {
        return \Carbon\Carbon::parse($this->created_at)->isToday();
    }
}
