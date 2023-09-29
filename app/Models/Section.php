<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use Translatable;
    use HasFactory;

    public $translatedAttributes = ['name','description'];

    protected $fillable = [
        'name',
        'description'
    ];

    public function doctors(){
        return $this->hasMany(Doctor::class);
    }
}
