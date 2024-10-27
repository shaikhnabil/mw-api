<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddToCart extends Model
{
    protected $table = 'tbl_add_to_cart';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // // Define relationship with Track model (assuming track_id refers to a Track table)
    // public function track()
    // {
    //     return $this->belongsTo(Track::class, 'track_id', 'id');
    // }

}
