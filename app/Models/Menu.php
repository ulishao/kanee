<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 25 May 2019 14:10:50 +0800.
 */

namespace App\Models;

use Carbon\Carbon;
use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Menu
 *
 * @property int $id
 * @property string $name
 * @property int $status
 * @property string $ver
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class Menu extends Eloquent
{
    protected $casts = [ 'status' => 'int' ];

    protected $fillable = [ 'name' , 'status' , 'ver' ];
}
