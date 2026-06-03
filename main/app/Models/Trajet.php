<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Trajet extends Model
{
    public const STATUT_PLANIFIE = 'planifie';
    public const STATUT_EN_COURS = 'en_cours';
    public const STATUT_TERMINE  = 'termine';
    public const STATUT_ANNULE   = 'annule';

    protected $fillable = [
        'courtier_id',
        'ville_depart',
        'ville_arrivee',
        'heure_depart',
        'prix',
        'places_total',
        'places_disponibles',
        'chauffeur_nom',
        'chauffeur_tel',
        'statut',
    ];

    protected function casts(): array
    {
        return [
            'heure_depart'     => 'datetime',
            'prix'             => 'decimal:2',
            'places_total'     => 'integer',
            'places_disponibles' => 'integer',
        ];
    }

    public function courtier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'courtier_id');
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function reservationsConfirmees(): HasMany
    {
        return $this->reservations()->where('statut', Reservation::STATUT_CONFIRMEE);
    }

    public function reservationsEnAttente(): HasMany
    {
        return $this->reservations()->where('statut', Reservation::STATUT_EN_ATTENTE)->orderBy('position_file');
    }

    public function estPlein(): bool
    {
        return $this->places_disponibles <= 0;
    }

    public function estDansLes24h(): bool
    {
        $now = Carbon::now();
        return $this->heure_depart->gte($now) && $this->heure_depart->lte($now->copy()->addDay());
    }

    public function scopeDansLes24h(Builder $query): Builder
    {
        $now = Carbon::now();
        return $query->where('heure_depart', '>=', $now)
                     ->where('heure_depart', '<=', $now->copy()->addDay());
    }

    public function scopePlanifie(Builder $query): Builder
    {
        return $query->where('statut', self::STATUT_PLANIFIE);
    }

    public function getLabelStatutAttribute(): string
    {
        return match ($this->statut) {
            self::STATUT_PLANIFIE  => 'Planifié',
            self::STATUT_EN_COURS  => 'En cours',
            self::STATUT_TERMINE   => 'Terminé',
            self::STATUT_ANNULE    => 'Annulé',
            default                => ucfirst($this->statut),
        };
    }

    public function getCouleurStatutAttribute(): string
    {
        return match ($this->statut) {
            self::STATUT_PLANIFIE  => 'primary',
            self::STATUT_EN_COURS  => 'warning',
            self::STATUT_TERMINE   => 'secondary',
            self::STATUT_ANNULE    => 'danger',
            default                => 'dark',
        };
    }
}
