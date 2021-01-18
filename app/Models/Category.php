<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'youtube_id',
        'name',
        'slug',
        'is_trending'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
    public $timestamps = true;
}
