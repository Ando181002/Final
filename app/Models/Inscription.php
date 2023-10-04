<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Inscription extends Model
{
    use HasFactory;

    public $timestamps=false;
    protected $table = 'inscription';
    protected $primaryKey='idinscription';
    protected $fillable = ['dateinscription','idactiviteevent','trigramme','idfamille'];

    public function ActiviteEvent()
    {
        return $this->belongsTo(ActiviteEvent::class, 'idactiviteevent');
    }
    public function Personnel()
    {
        return $this->belongsTo(Personnem::class, 'trigramme');
    }
    public function Famille()
    {
        return $this->belongsTo(Famille::class, 'idfamille');
    }
}