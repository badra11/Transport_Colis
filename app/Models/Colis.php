<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Colis extends Model
{
    use HasFactory;
    protected $fillable = [
        'numero_année',
        'numero_journée',
        'type_colis_id',
        'unite',
        'quantite',
        'montant',
        'nom_envoyeur',
        'numero_envoyeur',
        'nom_destinataire',
        'numero_destinataire',
        'gare_envois',
        'gare_destination',
        'code_recuperation',
        'status_envois',
        'user_id',
        'user_id_rendu',
        'date_rendu',
    ];


    public function gare(): BelongsTo{
        return $this->belongsTo(Gare::class, 'gare_destination'); // Pour listeColisVersGare et listeEncoursVersGare
    }

    // Dans App\Models\Colis
    public function userRendu(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id_rendu');
    }

    public function gareEnvois(): BelongsTo
    {
        return $this->belongsTo(Gare::class, 'gare_envois');
    }

    public function TypeColis(): BelongsTo{
        return $this->belongsTo(TypeColis::class, 'type_colis_id'); // Pour toutes les vues où le type de colis est affiché
    }
    
    
}
