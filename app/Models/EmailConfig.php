<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailConfig extends Model
{
    protected $fillable = [
        'driver',
        'host',
        'port',
        'encryption',
        'username',
        'password',
        'from_name',
        'from_address',
        'reply_to_name',
        'reply_to_address',
        'timeout',
    ];
}
