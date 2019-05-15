<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 14 May 2019 11:48:26 +0000.
 */

namespace App\Models;

use Carbon\Carbon;
use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class AdminMenu
 *
 * @property int $id
 * @property int $parent_id
 * @property int $order
 * @property string $title
 * @property string $icon
 * @property string $uri
 * @property string $permission
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class AdminMenu extends Eloquent
{
    protected $table = 'admin_menu';

    protected $casts = [ 'parent_id' => 'int' , 'order' => 'int' ];

    protected $fillable = [ 'parent_id' , 'order' , 'title' , 'icon' , 'uri' , 'permission' ];
}
