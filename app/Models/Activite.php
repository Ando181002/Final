<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Activite extends Model
{
    use HasFactory;

    public $timestamps=false;
    protected $table = 'activite';
    protected $primaryKey='idactivite';
    protected $fillable = ['nomactivite','idtypeactivite'];

    public function TypeActivite()
    {
        return $this->belongsTo(TypeActivite::class, 'idtypeactivite');
    }
}