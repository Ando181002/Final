<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class CategorieJoueur extends Model
{
    use HasFactory;

    public $timestamps=false;
    protected $table = 'categoriejoueur';
    protected $primaryKey='idcategorie';
    protected $fillable = ['nomcategorie','agemin','agemax'];
}