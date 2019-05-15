<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 14 May 2019 11:48:26 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Category
 *
 * @property string $id
 * @property string $name
 *
 * @package App\Models
 */
class Category extends Eloquent
{
    protected $table = 'category';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [ 'name' ];
}
