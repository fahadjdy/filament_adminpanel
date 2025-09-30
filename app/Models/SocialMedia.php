<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialMedia extends Model
{
    use SoftDeletes;

    protected $table = 'social_medias';

    protected $fillable = [
        'name',
        'link',
        'icon',
        'status',
    ];
}
