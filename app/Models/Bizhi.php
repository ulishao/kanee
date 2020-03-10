<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 19 Jun 2019 20:23:51 +0800.
 */

namespace App\Models;

use DB;
use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Bizhi
 *
 * @property int $id
 * @property string $url
 * @property string $title
 * @property string $source_url
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 *
 * @package App\Models
 */
class Bizhi extends Eloquent
{
    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $fillable = [
        'url',
        'title',
        'urls',
        'category_id',
        'source_url'
    ];

    public $appends = [
        'urlf'
    ];

    public function getUrlAttribute ( $value )
    {
        return 'https://api.kanee.top/url/' . $value;
    }
    public function getUrlsAttribute ( $value )
    {
        return 'https://api.kanee.top/url/' . $value;
    }
    public function getUrlfAttribute ()
    {
        return 'https://api.kanee.top/url/' . str_replace('1080x1920.jpeg', '360x640.jpeg', $this->url);
    }

    public static function createTable ( $id, $data )
    {
        if ( count ($data) <= 0 ) {
            return;
        }
        $datatable = [];
        foreach ($data as $k => $v) {
            $datatable[] = [
                'created_at' => date ('Y-m-d h:i:s'),
                'label' => $v,
                'bizhi_id' => $id,
                'updated_at' => date ('Y-m-d h:i:s'),
            ];
        }
        DB::table ('bizhi_label')->insert ($datatable);
    }
}
