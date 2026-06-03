<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public const ROLE_VOYAGEUR = 'voyageur';
    public const ROLE_COURTIER = 'courtier';

    protected $fillable = [
        'name',
        'email',
        'password',
        'telephone',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isCourtier(): bool
    {
        return $this->role === self::ROLE_COURTIER;
    }

    public function isVoyageur(): bool
    {
        return $this->role === self::ROLE_VOYAGEUR;
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function trajetsOrganises(): HasMany
    {
        return $this->hasMany(Trajet::class, 'courtier_id');
    }
}
