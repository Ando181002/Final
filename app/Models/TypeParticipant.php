<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class TypeParticipant extends Model
{
    use HasFactory;

    public $timestamps=false;
    protected $table = 'typeparticipant';
    protected $primaryKey='idtypeparticipant';
    protected $fillable = ['nomtypeparticipant'];
}