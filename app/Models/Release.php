<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Release extends Model
{
    protected $table = 'tbl_release';
    protected $guarded = [];
    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'user_id'); // Assuming you have a User model
    // }

    // public function distributor()
    // {
    //     return $this->belongsTo(Distributor::class, 'distributor_id'); // Assuming you have a Distributor model
    // }

    // public function genres()
    // {
    //     return $this->belongsToMany(Genre::class, 'release_genre', 'release_id', 'genre_id'); // Assuming a pivot table for genres
    // }

    //release_id

}
