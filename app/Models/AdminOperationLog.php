<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 07 May 2019 02:12:36 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class AdminOperationLog
 *
 * @property int $id
 * @property int $user_id
 * @property string $path
 * @property string $method
 * @property string $ip
 * @property string $input
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class AdminOperationLog extends Eloquent
{
    protected $table = 'admin_operation_log';

    protected $casts = [ 'user_id' => 'int' ];

    protected $fillable = [ 'user_id' , 'path' , 'method' , 'ip' , 'input' ];
}
