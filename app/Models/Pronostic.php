<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Pronostic extends Model
{
    use HasFactory;

    public $timestamps=false;
    protected $table = 'pronostic';
    protected $primaryKey='idpronostic';
    protected $fillable = ['idparticipant','idmatch','datepronostic','prono1','prono2'];

    public function Participant()
    {
        return $this->belongsTo(Participant::class, 'idparticipant');
    }
    public function Match()
    {
        return $this->belongsTo(Matchs::class, 'idmatch');
    }
}

