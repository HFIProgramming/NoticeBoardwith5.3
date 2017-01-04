<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'chinese_name', 'email', 'password', 'phone_number','wechat','name','active','avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * default avatar
     *
     * @param $value
     * @return string
     */
    public function getAvatarAttribute($value)
    {
        return empty($value) ? 'http://ww4.sinaimg.cn/small/006dLiLIgw1fawexxhv3hj31hc1hcdzh.jpg' : $value;
    }

    /**
     * Username verification before login.
     * Status 1 found; 0 no found
     * Active 1 already; 0 need further step
     *
     * @param $query
     * @return \Illuminate\Http\JsonResponse
     */
    public function scopeUsername($query,$username)
    {
        $search = 'chinese_name';
        if (is_numeric($username)) {
            $search = 'phone_number';
        } elseif (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            $search = 'email';
        }
        if (!empty($user = $query->where($search,$username)->first())) {
            $result['status'] = 1;
            $result['active'] = $user->active;
        } else {
            $result['status'] = 0;
        }
        $result['username'] = $username;
        $result['type'] = $search;
        return $result;
    }

}
