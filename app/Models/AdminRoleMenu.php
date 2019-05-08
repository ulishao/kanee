<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 07 May 2019 02:12:36 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class AdminRoleMenu
 *
 * @property int $role_id
 * @property int $menu_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class AdminRoleMenu extends Eloquent
{
    protected $table = 'admin_role_menu';
    public $incrementing = false;

    protected $casts = [ 'role_id' => 'int' , 'menu_id' => 'int' ];

    protected $fillable = [ 'role_id' , 'menu_id' ];
}
