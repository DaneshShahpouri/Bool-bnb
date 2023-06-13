<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\View;
use App\Models\Message;
use App\Models\Service;
use App\Models\Sponsorship;


class Apartment extends Model
{
    use HasFactory;

    //protected $fillable = ['name', 'description', 'rooms_number', 'beds_number', 'bathrooms_number', 'sqm', 'address', 'latitude', 'longitude', 'cover_image', 'isVisible', 'slug'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function views()
    {
        return $this->HasMany(View::class);
    }

    public function messages()
    {
        return $this->HasMany(Message::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }

    public function sponsorships()
    {
        return $this->belongsToMany(Sponsorship::class);
    }
}
