<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    protected $table = 'user';

    protected $fillable = ['first_name', 'email', 'password'];

    protected $hidden = ['password', 'remember_token'];

    public function role ()
    {
        return $this->belongsTo('App\Models\Role');
    }

    public function photo ()
    {
        return $this->belongsTo('App\Models\Media');
    }

    public  function contact()
    {
        return $this->hasOne('App\Models\Contact');
    }
}
