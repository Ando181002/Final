<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Evenement extends Model
{
    use HasFactory;

    public $timestamps=false;
    protected $table = 'evenement';
    protected $primaryKey='idevenement';
    protected $fillable = ['titre','descri','fininscription','idlieu','dateevent'];

    public function Lieu()
    {
        return $this->belongsTo(Lieu::class, 'idlieu');
    }
}