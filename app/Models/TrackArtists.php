<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrackArtists extends Model
{
    protected $table = 'tbl_track_artists';
    protected $guarded = [];
    // public function track()
    // {
    //     return $this->belongsTo(Track::class, 'track_id', 'id'); // Assuming there's a Track model with id as primary key
    // }


    // public function artist()
    // {
    //     return $this->belongsTo(Artist::class, 'artist_id', 'id'); // Assuming there's an Artist model with id as primary key
    // }

    //release_id
}
