<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Lieu extends Model
{
    use HasFactory;

    public $timestamps=false;
    protected $table = 'lieu';
    protected $primaryKey='idlieu';
    protected $fillable = ['nomlieu','imagelieu','longitude','latitude'];
}