<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 14 May 2019 11:48:26 +0000.
 */

namespace App\Models;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon $email_verified_at
 * @property string $password
 * @property string $remember_token
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class User extends Eloquent
{
    use SoftDeletes;
    protected $dates = [ 'email_verified_at' ];

    protected $hidden = [ 'password' , 'remember_token' ];

    protected $fillable = [
        'name' ,
        'url' ,
        'email' ,
        'latitude',
        'longitude',
        'color' ,
        'ip' ,
        'sex' ,
        'content' ,
        'openid' ,
        'avatar' ,
        'email_verified_at' ,
        'password' ,
        'remember_token' ,
    ];
    protected $appends = ['iconPath'];

    public function getIconPathAttribute ()
    {
        return $this->sex % 1 == 0 ? '/icon/dog-yellow.png' : "/icon/dog-yellow.png";
    }
    public function getIdAttribute($value)
    {
        return 10000 + $value;
    }

    public function getUrlAttribute()
    {
        return str_replace ('/132' , '/0' , $this->avatar);
    }

    public static function createTable( $id , $data )
    {
        if ( count( $data ) <= 0 ) {
            return;
        }
        $datatable = [];
        foreach ($data as $k => $v) {
            $datatable[] = [
                'created_at' => date( 'Y-m-d h:i:s' ) ,
                'label'      => $v ,
                'img_id'     => $id ,
                'updated_at' => date( 'Y-m-d h:i:s' ),
            ];
        }
        DB::table( 'img_label' )->insert( $datatable );
    }
}
