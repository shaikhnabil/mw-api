<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SummeryTopPromoTracks extends Model
{
    protected $table = 'summery_top_promo_tracks';
    protected $guarded = [];

    // public function track()
    // {
    //     return $this->belongsTo(Track::class, 'track_id', 'id');
    // }

    // // Define relationship with Release model (assuming release_id refers to a Release table)
    // public function release()
    // {
    //     return $this->belongsTo(Release::class, 'release_id', 'id');
    // }
}