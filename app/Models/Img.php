<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 07 May 2019 02:12:36 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Img
 *
 * @property string $id
 * @property string $title
 * @property string $imgs
 * @property string $img
 * @property string $source_url
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int $size
 *
 * @package App\Models
 */
class Img extends Eloquent
{
    protected $table = 'img';
    public $incrementing = false;

    protected $casts = [ 'size' => 'int' ];

    protected $fillable = [ 'title' , 'id' , 'imgs' , 'img' , 'size' , 'source_url' ,'category_id' ];

    public function getImgsAttribute( $value )
    {
        return array_filter( explode( ',' , $value ) );
    }
}
