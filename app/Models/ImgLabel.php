<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 06 Jun 2019 13:08:52 +0800.
 */

namespace App\Models;

use Carbon\Carbon;
use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class ImgLabel
 *
 * @property string $img_id
 * @property string $label
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class ImgLabel extends Eloquent
{
    protected $table = 'img_label';
    public $incrementing = false;

    protected $fillable = [
        'img_id' ,
        'label',
    ];
}
