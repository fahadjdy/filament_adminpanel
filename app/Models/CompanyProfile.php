<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyProfile extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'contact',
        'city',
        'state',
        'location',
        'pincode',
        'about',
        'slogan',
        'company_image',
        'logo',
        'favicon',
        'latitude',
        'longitude',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
