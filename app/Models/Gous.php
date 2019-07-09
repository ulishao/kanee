<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 09 Jul 2019 13:09:48 +0800.
 */

namespace App\Models;

use Carbon\Carbon;
use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Gous
 *
 * @property string $id
 * @property string $name
 * @property string $name_en
 * @property string $name_bie
 * @property string $region
 * @property string $place
 * @property string $shape
 * @property string $function
 * @property string $height
 * @property string $weight
 * @property string $trait
 * @property string $introduce
 * @property string $fazhan
 * @property string $renqun
 * @property string $biaozhun
 * @property string $weiyang
 * @property string $jianbie
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class Gous extends Eloquent
{
    protected $table='gous';
    public $incrementing=false;

    protected $fillable=[
        'name' ,
        'id' ,
        'name_en' ,
        'name_bie' ,
        'region' ,
        'source_url' ,
        'place' ,
        'shape' ,
        'function' ,
        'price' ,
        'group' ,
        'url' ,
        'height' ,
        'weight' ,
        'trait' ,
        'life' ,
        'introduce' ,
        'fazhan' ,
        'renqun' ,
        'biaozhun' ,
        'weiyang' ,
        'jianbie',
    ];

    public static function createData( $data )
    {
        if ( Gous::where ([ 'source_url'=>$data[ 'source_url' ] ])->first () ) {

        } else {
            return Gous::create ($data);
        }
    }
}
