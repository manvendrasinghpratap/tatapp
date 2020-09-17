<?php


namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use \Illuminate\Database\Eloquent\SoftDeletes;
    protected $primaryKey = 'id';
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = ['account_id','user_name','first_name','last_name','phone','cell_phone','email', 'password', 'email_verify', 'status', 'verification_code', 'created_at', 'updated_at','remember_token','password_changed_at'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function caselists()
    {
        return $this->hasMany('App\CaseList','user_id','id')->select('*');
    }

    public function caselistsOwner()
    {
        return $this->hasMany('App\CaseList','case_owner_id','id')->select('*');
    }

    public function accountInfo()
    {
        return $this->hasOne('App\AccountList','id','account_id')->select('*');
    }

    public function rolelists()
    {
        return $this->hasMany('App\Role','role_id','id')->select('*');
    }

    public function roles()
    {
        return $this
            ->belongsToMany('App\Role')
            ->withTimestamps();
    }


    public function authorizeRoles($roles)
        {
            if ($this->hasAnyRole($roles)) {
            return true;
            }
            abort(401, 'This action is unauthorized.');
        }

    public function hasAnyRole($roles)
    {
        if (is_array($roles)) {
        foreach ($roles as $role) {
        if ($this->hasRole($role)) {
        return true;
        }
        }
        } else {
        if ($this->hasRole($roles)) {
        return true;
        }
        }
        return false;
    }

    public function hasRole($role)
    {
        if ($this->roles()->where('name', $role)->first()) {
        return true;
        }
        return false;
    }
    
    public function userGroup()
    {
        return $this->hasMany('App\UserGroup','user_id','id')->select('*');
    }


}
