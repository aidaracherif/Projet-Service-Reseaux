<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Employe extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nom',
        'prenom',
        'username', // Ajout du champ username
        'email',
        'telephone',
        'poste',
        'date_embauche',
        'password',
        'first_login',
    ];
    

    protected $hidden = [
        'password', 
        'remember_token',
    ];

    protected $casts = [
        'date_embauche' => 'datetime',
        'first_login' => 'boolean',
    ];
    
    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}