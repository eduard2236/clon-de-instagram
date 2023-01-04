<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class like extends Model
{
    protected $table= 'likes';
    /* relacion muchos a uno */
    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }
    /* relacion muchos a uno */
    public function image(){
        return $this->belongsTo('App\Image', 'image_id');
    }
}
