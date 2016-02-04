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
}
