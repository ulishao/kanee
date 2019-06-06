<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 06 Jun 2019 11:37:45 +0800.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Collect
 *
 * @property int    $id
 * @property string $openid
 * @property string $img_url
 * @property string $deleted_at
 * @property Carbon $updated_at
 * @property Carbon $created_at
 *
 * @package App\Models
 */
class Collect extends Eloquent
{
    use SoftDeletes;
    public $incrementing = false;

    protected $fillable = [
        'openid' ,
        'id' ,
        'img_url',
    ];


}
