<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Developer extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        "id",
        "name",
        "email",
        "phone",
        "location",
        "profile_picture",
        "price_per_hour",
        "technology",
        "description",
        "years_of_experience",
        "native_language",
        "linkedin_profile_link",
    ];

    public function hires() {
//        return $this->hasMany(Hire::class, 'developer_id'); // A Developer can have many hires
        return $this->belongsTo(Hire::class); // A Developer can have many hires
    }
}
