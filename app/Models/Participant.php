<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Participant extends Model
{
    use HasFactory;

    public $timestamps=false;
    protected $table = 'participant';
    protected $primaryKey='idparticipant';
    protected $fillable = ['trigramme','idtournoi','idequipe1g','idequipe2g','reponsequestion'];

    public function Personnel()
    {
        return $this->belongsTo(Personnel::class, 'trigramme');
    }
    public function Tournoi()
    {
        return $this->belongsTo(Tournoi::class, 'idtournoi');
    }
    public function Equipe1g()
    {
        return $this->belongsTo(Equipe::class, 'idequipe1g');
    }
    public function Equipe2g()
    {
        return $this->belongsTo(Equipe::class, 'idequipe2g');
    }
}