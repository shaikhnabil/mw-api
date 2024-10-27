<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderedBasketItems extends Model
{
    protected $table = 'tbl_ordered_basket_items';
    protected $guarded = [];
    // public function orderedBasket()
    // {
    //     return $this->belongsTo(OrderedBasket::class, 'ordered_basket_id');
    // }
    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'user_id');
    // }
    // public function track()
    // {
    //     return $this->belongsTo(Track::class, 'track_id');
    // }
    // public function getFormattedPriceAttribute()
    // {
    //     return '$' . number_format($this->track_price, 2);
    // }
    // public function getDownloadSourceAttribute()
    // {
    //     switch ($this->downloaded_on) {
    //         case 1:
    //             return 'Dropbox';
    //         case 2:
    //             return 'Google Drive';
    //         default:
    //             return 'Local';
    //     }
    // }
    // public function markAsDownloaded()
    // {
    //     $this->number_of_downloads += 1;
    //     $this->downloaded_at = now();
    //     $this->save();
    // }
}
