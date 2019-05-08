<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 07 May 2019 02:12:36 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class AdminPermission
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $http_method
 * @property string $http_path
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class AdminPermission extends Eloquent
{
    protected $fillable = [ 'name' , 'slug' , 'http_method' , 'http_path' ];
}
