<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';
    /* relacion uno a muchos */
    public function comments(){
        return $this->hasMany('App\comment')->orderBy('id','desc');
    }
    /* uno a muchos */
    public function likes(){
        return $this->hasMany('App\like');
    }
    /* muchos a uno */
    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }
}
