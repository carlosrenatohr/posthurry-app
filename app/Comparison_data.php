<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comparison_data extends Model
{
    //
    protected $table = 'comparison_data';
    protected $guarded = [];

    public function comparison()
    {
        return $this->belongsTo('\App\Comparison', 'comparison_id', 'id');
    }
}
