<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReconnectEmailSendLog extends Model
{
    protected $table = 'reconnect_email_send_log';
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
