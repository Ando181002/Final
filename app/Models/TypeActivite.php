<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class TypeActivite extends Model
{
    use HasFactory;

    public $timestamps=false;
    protected $table = 'typeactivite';
    protected $primaryKey='idtypeactivite';
    protected $fillable = ['nomtypeactivite'];
}