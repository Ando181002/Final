<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class RepartitionCagnote extends Model
{
    use HasFactory;

    public $timestamps=false;
    protected $table = 'repartitioncagnote';
    protected $primaryKey='idrepartition';
    protected $fillable = ['idtournoi','rang1','rang2','rang3','rang4','rang5'];

    public function Tournoi()
    {
        return $this->belongsTo(Tournoi::class, 'idtournoi');
    }
}