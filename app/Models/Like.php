<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 15 Jun 2019 21:13:48 +0800.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Like
 *
 * @property int $id
 * @property string $url
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $openid
 *
 * @package App\Models
 */
class Like extends Eloquent
{
    protected $fillable = [
        'url',
        'openid'
    ];
}
