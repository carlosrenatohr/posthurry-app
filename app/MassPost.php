<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MassPost extends Model
{
    //
    protected $table = 'massPosts';
    protected $guarded = [];

    public function comparison()
    {
        return $this->belongsTo('\App\Comparison', 'comparison_id', 'id');
    }
}
