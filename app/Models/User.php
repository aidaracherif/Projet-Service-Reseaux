<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;

    /**
     * Les attributs pouvant être remplis en masse.
     */
    protected $fillable = [
        'name',
        'prenom',
        'email',
        'password',
        'role',
    ];

    /**
     * Les attributs cachés dans la réponse JSON.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Les attributs à caster en types natifs.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Vérifie si l'utilisateur est un administrateur.
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Vérifie si l'utilisateur est un employé.
     */
    public function isEmployee()
    {
        return $this->role === 'employee';
    }

    /**
     * Relation avec les documents (un employé peut avoir plusieurs documents).
     */
    public function documents()
    {
        return $this->hasMany(Document::class, 'employe_id');
    }
}
