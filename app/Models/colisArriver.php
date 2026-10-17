<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class colisArriver extends Model
{

    protected $table = 'colis_arriver';

    use HasFactory;
    protected $fillable = [
        'colis_id',
        'user_id',
        'gare_envois',
        'gare_destination',
        'rendu'
    ];

     protected $casts = [
        'rendu' => 'boolean',
    ];


       // Relation vers le colis original
    public function colis(): BelongsTo
    {
        return $this->belongsTo(Colis::class, 'colis_id');
    }

    // Relation vers l'utilisateur qui a réceptionné
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relation vers la gare d'envoi
    public function gareEnvois(): BelongsTo
    {
        return $this->belongsTo(Gare::class, 'gare_envois');
    }

    // Relation vers la gare de destination
    public function gareDestination(): BelongsTo
    {
        return $this->belongsTo(Gare::class, 'gare_destination');
    }

}
