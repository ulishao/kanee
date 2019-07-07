<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 07 Jul 2019 12:14:19 +0800.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Message
 *
 * @property int $id
 * @property string $form_id
 * @property string $openid
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class Message extends Eloquent
{


    protected $casts = [
        'id' => 'int'
    ];


    protected $fillable = [
        'form_id',
        'openid',
    ];
}
