<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Tournoi extends Model
{
    use HasFactory;

    public $timestamps=false;
    protected $table = 'tournoi';
    protected $primaryKey='idtournoi';
    protected $fillable = ['nomtournoi','idtypetournoi','debuttournoi','fintournoi','frais','question','imagetournoi','description'];

    public function TypeTournoi()
    {
        return $this->belongsTo(TypeTournoi::class, 'idtypetournoi');
    }
}