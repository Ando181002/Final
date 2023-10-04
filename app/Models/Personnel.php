<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Personnel extends Model
{
    use HasFactory;

    public $timestamps=false;
    protected $table = 'personnel';
    protected $primaryKey='trigramme';
    public $incrementing = false;
    protected $fillable = ['trigramme','nom','emailperso','mdpperso','telephone','idgenre','datenaissance'];

    public function Genre()
    {
        return $this->belongsTo(Genre::class, 'idgenre');
    }   
}