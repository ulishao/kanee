<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 14 May 2019 11:48:26 +0000.
 */

namespace App\Models;

use Carbon\Carbon;
use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class PasswordReset
 *
 * @property string $email
 * @property string $token
 * @property Carbon $created_at
 *
 * @package App\Models
 */
class PasswordReset extends Eloquent
{
    public $incrementing = false;
    public $timestamps = false;

    protected $hidden = [ 'token' ];

    protected $fillable = [ 'email' , 'token' ];
}
