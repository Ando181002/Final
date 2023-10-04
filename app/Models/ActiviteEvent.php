<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ActiviteEvent extends Model
{
    use HasFactory;

    public $timestamps=false;
    protected $table = 'activiteevent';
    protected $primaryKey='idactiviteevent';
    protected $fillable = ['idevenement','idactivite','nbjoueurparactivite'];

    public function Evenement()
    {
        return $this->belongsTo(Evenement::class, 'idevenement');
    }
    public function Activite()
    {
        return $this->belongsTo(Activite::class, 'idactivite');
    }
}