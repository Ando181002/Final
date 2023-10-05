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
    protected $fillable = ['dateinscription','idactiviteevent','trigramme','idgenre','iddepartement'];

    public function ActiviteEvent()
    {
        return $this->belongsTo(ActiviteEvent::class, 'idactiviteevent');
    }
    public function Personnel()
    {
        return $this->belongsTo(Personnem::class, 'trigramme');
    }
    public function Genre()
    {
        return $this->belongsTo(Genre::class, 'idgenre');
    }
    public function Departement()
    {
        return $this->belongsTo(Departement::class, 'iddepartement');
    }
}