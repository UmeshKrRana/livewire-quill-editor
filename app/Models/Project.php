<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'deadline',
        'status',
        'project_logo',
    ];
}
