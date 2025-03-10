<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = ['nom_fichier', 'type', 'taille', 'path', 'employe_id'];

    public function employe()
    {
        return $this->belongsTo(Employe::class);
    }
}
