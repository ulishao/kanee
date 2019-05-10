<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 07 May 2019 02:12:36 +0000.
 */

namespace App\Models;

use Carbon\Carbon;
use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Img
 *
 * @property string $id
 * @property string $title
 * @property string $imgs
 * @property string $img
 * @property string $source_url
 * @property Carbon $created_at
 * @property Carbon $updated_at
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

    public function getImgAttribute( $value )
    {
        return 'https://api.kanee.top/url?url=' . $value;
    }

    public function getImgsAttribute( $value )
    {
        $data = [];
        foreach ((array)array_filter( explode( ',' , $value ) ) as $value) {
            $data[] = 'https://api.kanee.top/url?url=' . $value . '?' . rand( 1 , 9999 );
        }
        return $data;
    }
}
