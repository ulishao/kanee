<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 22 May 2019 14:06:40 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Comment
 *
 * @property int $id
 * @property string $user_id
 * @property string $content_id
 * @property string $content
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 *
 * @package App\Models
 */
class Comment extends Eloquent
{
    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $fillable = [
        'user_id',
        'content_id',
        'content'
    ];
}
