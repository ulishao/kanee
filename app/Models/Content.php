<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 22 May 2019 12:39:31 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Content
 *
 * @property string $id
 * @property string $user_id
 * @property string $title
 * @property string $urls
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class Content extends Eloquent
{
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'title',
        'urls'
    ];

    public function user ()
    {
        return $this->belongsTo (User::class, 'user_id', 'openid');
    }

    public function getUrlsAttribute ( $value )
    {
        return json_decode ($value, true);
    }
}
