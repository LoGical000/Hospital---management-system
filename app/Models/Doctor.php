<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Doctor extends Authenticatable
{
    use HasFactory;
    use Translatable;

    public $translatedAttributes = ['name','appointments'];
    protected $fillable = [
        'email',
        'email_verified_at',
        'password',
        'phone',
        //'price',
        //'appointments',
        'name',
        'section_id',
        'status'
    ];

    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function appointmentdoctor(){
        return $this->belongsToMany(Appointment::class,'appointment_doctor');
    }
}
