<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 07 May 2019 02:12:36 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class AdminRolePermission
 *
 * @property int $role_id
 * @property int $permission_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class AdminRolePermission extends Eloquent
{
    public $incrementing = false;

    protected $casts = [ 'role_id' => 'int' , 'permission_id' => 'int' ];

    protected $fillable = [ 'role_id' , 'permission_id' ];
}
