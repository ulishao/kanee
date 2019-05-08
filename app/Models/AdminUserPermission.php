<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 07 May 2019 02:12:36 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class AdminUserPermission
 *
 * @property int $user_id
 * @property int $permission_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class AdminUserPermission extends Eloquent
{
    public $incrementing = false;

    protected $casts = [ 'user_id' => 'int' , 'permission_id' => 'int' ];

    protected $fillable = [ 'user_id' , 'permission_id' ];
}
