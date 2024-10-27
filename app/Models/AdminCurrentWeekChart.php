<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminCurrentWeekChart extends Model
{
    protected $table = 'tbl_admin_current_week_chart';
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

    // // If 'release_id' refers to a specific model, define that relationship as well
    // public function release()
    // {
    //     return $this->belongsTo(Release::class, 'release_id', 'id'); // Adjust 'Release::class' as needed
    // }

}