<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
//use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'tbl_users';
    protected $guarded = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function djCharts()
    {
        return $this->hasMany(DjCharts::class, 'user_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(UserSubscriptions::class, 'user_id');
    }
    public function subscriptions_history()
    {
        return $this->hasMany(UserSubscriptionsHistory::class, 'user_id');
    }

    public function download_request()
    {
        return $this->hasMany(AddDownloadRequest::class, 'user_id', 'id');
    }

    public function streamboxes() {
        return $this->hasMany(Streambox::class, 'user_id', 'id');
    }

    public function mobile_token()
    {
        return $this->hasOne(UsersMobileToken::class, 'user_id');
    }

    //parent_label_id response_id
}
