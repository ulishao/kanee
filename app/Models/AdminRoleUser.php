<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 14 May 2019 11:48:26 +0000.
 */

namespace App\Models;

use Carbon\Carbon;
use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class AdminRoleUser
 *
 * @property int $role_id
 * @property int $user_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class AdminRoleUser extends Eloquent
{
    public $incrementing = false;

    protected $casts = [ 'role_id' => 'int' , 'user_id' => 'int' ];

    protected $fillable = [ 'role_id' , 'user_id' ];
}
