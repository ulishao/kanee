<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 14 May 2019 11:48:26 +0000.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon $email_verified_at
 * @property string $password
 * @property string $remember_token
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class User extends Eloquent
{
    use SoftDeletes;
    protected $dates = [ 'email_verified_at' ];

    protected $hidden = [ 'password' , 'remember_token' ];

    protected $fillable = [ 'name' , 'email' ,'sex','openid', 'avatar','email_verified_at' , 'password' , 'remember_token' ];
}
