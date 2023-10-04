<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class EquipeTypeTournoi extends Model
{
    use HasFactory;
    public $incrementing = false;
    public $timestamps=false;
    protected $table = 'equipetypetournoi';
    protected $fillable = ['idequipe','idtypetournoi'];

    public function Equipe()
    {
        return $this->belongsTo(Equipe::class, 'idequipe');
    }   
    public function TypeTournoi()
    {
        return $this->belongsTo(TypeTournoi::class, 'idtypetournoi');
    }

}