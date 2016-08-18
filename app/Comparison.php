<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Comparison extends Model
{
    //
    protected $table = 'comparison';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('\App\User', 'user_id', 'id');
    }

    public function data_row()
    {
        return $this->hasOne('\App\Comparison_data', 'comparison_id', 'id');
    }

    public function massPosts()
    {
        return $this->hasOne('\App\MassPost', 'comparison_id', 'id');
    }

    public function getGroupsAttribute() {
        return (!is_null($this->massPosts)) ? explode('\,/', $this->massPosts->groups_names) : '';
    }

    public function getPagesAttribute() {
        return (!is_null($this->massPosts)) ? explode('\,/', $this->massPosts->pages_names) : '';
    }

    public function getPublishedAttribute() {
        return (!is_null($this->massPosts)) ? explode(',', $this->massPosts->posts_published) : '';
    }
}
