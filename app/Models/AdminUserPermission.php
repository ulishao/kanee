<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 14 May 2019 11:48:26 +0000.
 */

namespace App\Models;

use Carbon\Carbon;
use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class AdminUserPermission
 *
 * @property int $user_id
 * @property int $permission_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class AdminUserPermission extends Eloquent
{
    public $incrementing = false;

    protected $casts = [ 'user_id' => 'int' , 'permission_id' => 'int' ];

    protected $fillable = [ 'user_id' , 'permission_id' ];
}
