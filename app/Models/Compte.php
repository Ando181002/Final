<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Compte extends Model
{
    use HasFactory;

    public $timestamps=false;
    protected $table = 'compte';
    protected $primaryKey='idcompte';
    protected $fillable = ['trigramme','nom','email','mdp','telephone','expirationmdp'];

}