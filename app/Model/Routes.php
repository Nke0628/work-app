<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Routes extends Model
{
    protected $table = 'routes';

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
