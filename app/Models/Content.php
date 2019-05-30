<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 22 May 2019 12:39:31 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
class Content extends Model
{
//    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'title',
        'urls',
        'category_id'
    ];

    public function user ()
    {
        return $this->belongsTo (User::class, 'user_id', 'openid');
    }

    public function comment ()
    {
        return $this->hasMany (Comment::class, 'content_id', 'id');
    }

    public function getUrlsAttribute ( $value )
    {
        return json_decode ($value, true);
    }
}
