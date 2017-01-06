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
        'chinese_name', 'english_name','name','email', 'password', 'phone_number','wechat','avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','active'
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
     * identify the type of the username
     *
     * @param $username
     * @return string
     */
    public function scopeDetermineUsernameField($username){
        if (preg_match("/^[x7f-xff]+$/", $username)) return 'chinese_name';
        if (filter_var($username, FILTER_VALIDATE_EMAIL)) return 'email';
        if (is_numeric($username)) return 'phone_number';
        return 'name';
    }

    /**
     * scope username with this function
     *
     * @param $query
     * @param $username
     * @return mixed
     */
    public function scopeUsername($query,$username)
    {
        return $query->where($this->scopeDetermineUsernameField($username),$username);
    }

}
