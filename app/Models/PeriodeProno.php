<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class PeriodeProno extends Model
{
    use HasFactory;

    public $timestamps=false;
    protected $table = 'periodeprono';
    protected $primaryKey='idperiode';
    protected $fillable = ['nomperiode','datelimite'];

}