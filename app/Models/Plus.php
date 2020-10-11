<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 11 Oct 2020 14:30:44 +0800.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Plus
 *
 * @property string $id
 * @property string $title
 * @property string $img
 * @property string $source_url
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class Plus extends Eloquent
{
	protected $table = 'plus';
//	public $incrementing = false;

	protected $fillable = [
		'title',
		'img',
		'source_url'
	];
}
