<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    public const STATUT_EN_ATTENTE  = 'en_attente';
    public const STATUT_CONFIRMEE   = 'confirmee';
    public const STATUT_ANNULEE     = 'annulee';

    protected $fillable = [
        'user_id',
        'trajet_id',
        'statut',
        'position_file',
        'paye',
    ];

    protected function casts(): array
    {
        return [
            'paye'          => 'boolean',
            'position_file' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function trajet(): BelongsTo
    {
        return $this->belongsTo(Trajet::class);
    }

    public function estEnAttente(): bool
    {
        return $this->statut === self::STATUT_EN_ATTENTE;
    }

    public function estConfirmee(): bool
    {
        return $this->statut === self::STATUT_CONFIRMEE;
    }

    public function estAnnulee(): bool
    {
        return $this->statut === self::STATUT_ANNULEE;
    }

    public function getLabelStatutAttribute(): string
    {
        return match ($this->statut) {
            self::STATUT_EN_ATTENTE => 'En attente',
            self::STATUT_CONFIRMEE  => 'Confirmée',
            self::STATUT_ANNULEE    => 'Annulée',
            default                 => ucfirst($this->statut),
        };
    }

    public function getCouleurStatutAttribute(): string
    {
        return match ($this->statut) {
            self::STATUT_EN_ATTENTE => 'warning',
            self::STATUT_CONFIRMEE  => 'success',
            self::STATUT_ANNULEE    => 'danger',
            default                 => 'secondary',
        };
    }
}
