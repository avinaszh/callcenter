<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'email', 'password','role_id','phone'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];


	public function manageProject()
	{
		return $this->hasMany('App\Project','manager_id','id');
	}

	public function createProject()
	{
		return $this->hasMany('App\Project','client_id','id');
	}

    public function role()
    {
        return $this->belongsTo('App\Role','role_id','id');
    }

    public function checkAccess($codeRoleArray)
    {
        if($this->role_id == 1) return true;
        if(in_array($this->role()->first()->code,$codeRoleArray)){
            return true;
        }
        return false;
    }
}
