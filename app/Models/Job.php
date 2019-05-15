<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 14 May 2019 11:48:26 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Job
 * 
 * @property int $id
 * @property string $queue
 * @property string $payload
 * @property int $attempts
 * @property int $reserved_at
 * @property int $available_at
 * @property int $created_at
 *
 * @package App\Models
 */
class Job extends Eloquent
{
    public $timestamps = false;

    protected $casts = [ 'attempts' => 'int' , 'reserved_at' => 'int' , 'available_at' => 'int' , 'created_at' => 'int' ];

    protected $fillable = [ 'queue' , 'payload' , 'attempts' , 'reserved_at' , 'available_at' ];
}
