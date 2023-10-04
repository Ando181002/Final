<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Famille extends Model
{
    use HasFactory;

    public $timestamps=false;
    protected $table = 'famille';
    protected $primaryKey='idfamille';
    protected $fillable = ['trigramme','nomfamille','idgenre','datenaissance','idtypeparticipant'];

    public function Personnel()
    {
        return $this->belongsTo(Personnel::class, 'trigramme');
    }
    public function Genre()
    {
        return $this->belongsTo(Genre::class, 'idgenre');
    }
    public function TypeParticipant()
    {
        return $this->belongsTo(TypeParticipant::class, 'idtypeparticipant');
    }
}