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
}
