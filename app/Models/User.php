<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    // Constantes pour les rôles
    const ROLE_ADMIN = 'admin';
    const ROLE_AGENT = 'agent';
    const ROLE_SUPERVISEUR = 'superviseur';
    const ROLE_UTILISATEUR = 'utilisateur';

    protected $fillable = [
        'name',
        'email',
        'password',
        'gare_id',
        'role',

    ];

    // Relation avec Gare
    public function gare(): BelongsTo{
        return $this->belongsTo(Gare::class);
    }

    // Helpers pour vérifier les rôles
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isAgent(): bool
    {
        return $this->role === self::ROLE_AGENT;
    }

     public function isSuperviseur(): bool
    {
        return $this->role === self::ROLE_SUPERVISEUR;
    }

     public function isUtilisateur(): bool
    {
        return $this->role === self::ROLE_UTILISATEUR;
    }

    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }
}
