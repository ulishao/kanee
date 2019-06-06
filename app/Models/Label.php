<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 06 Jun 2019 12:53:12 +0800.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Label
 *
 * @property int    $id
 * @property string $name
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $deleted_at
 *
 * @package App\Models
 */
class Label extends Eloquent
{
    use SoftDeletes;

    protected $fillable = [
        'name',
    ];
}
