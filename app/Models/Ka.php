<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 24 Feb 2020 15:00:23 +0800.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Ka
 * 
 * @property string $id
 * @property string $text
 * @property string $openid
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class Ka extends Eloquent
{
	public $incrementing = false;

	protected $fillable = [
		'text',
		'openid'
	];
}
