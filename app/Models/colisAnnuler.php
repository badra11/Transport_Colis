<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class colisAnnuler extends Model
{
    use HasFactory;

    protected $table = 'colis_annuler';

    protected $fillable = [
        'colis_id',
        'user_id',
        'gare_envois',
        'gare_destination',
        'annuler'
    ];


    public function colis(): BelongsTo
    {
        return $this->belongsTo(Colis::class, 'colis_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function gareEnvois(): BelongsTo
    {
        return $this->belongsTo(Gare::class, 'gare_envois');
    }

    public function gareDestination(): BelongsTo
    {
        return $this->belongsTo(Gare::class, 'gare_destination');
    }
}
