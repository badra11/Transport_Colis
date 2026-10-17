<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Colis;
use App\Models\ColisArriver;
use App\Models\ColisAnnuler;
use App\Models\Gare;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller{

     public function __invoke()
    {
        return view('dashboard');
    }

    public function index()
    {
        $user =  auth()->user()->id;
        $userGareId = auth()->user()->gare->id;

        // ===== STATISTIQUES GÉNÉRALES =====

        // Total colis envoyer 
        $colisEnvoyer = Colis::where('user_id', $user)
                            ->whereIn('status_envois', ['encours', 'arriver', 'arrivee'])
                            ->where('gare_envois', $userGareId)
                            ->count();
        // Total Colis envoyés aujourd'hui
        $colisEnvoyerAujourdhui = Colis::whereDate('created_at', today())
                                            ->whereIn('status_envois', ['encours', 'arriver', 'arrivee'])
                                            ->where('user_id', $user)
                                            ->where('gare_envois', $userGareId)
                                            ->count();
        // Total Colis envoyés cette semaine
        $colisEnvoyerCetteSemaine = Colis::whereBetween('created_at', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ])
            ->when([$user, $userGareId], function ($query) use ($user, $userGareId) {
                $query->where('user_id', $user)
                ->where('gare_envois', $userGareId)
                ->whereIn('status_envois', ['encours', 'arriver', 'arrivee']);
            })
            ->count();

        // Colis par statut
        $colisParStatut = [
            'depot'     => Colis::where('status_envois', 'depot')->count(),
            'en_cours'  => Colis::where('status_envois', 'encours')->count(),
            'arriver'   => Colis::where('status_envois', 'arriver')->count(),
            'rendu'     => Colis::where('status_envois', 'arrivee')->count(),
            'annuler'   => Colis::where('status_envois', 'annuler')->count(),
            'annulee'   => Colis::where('status_envois', 'annulee')->count(),
        ];

        // Total colis rendus (via table colis_arrivers)
         $colisRendus = ColisArriver::where('rendu', true)
                            ->where('user_id', $user)
                            ->where('gare_destination', $userGareId)
                            ->count();
        // Colis rendus aujourd'hui (via table colis_arrivers)
        $colisRendusAujourdhui = ColisArriver::whereDate('created_at', today())
                                            ->where('rendu', true)
                                            ->where('user_id', $user)
                                            ->where('gare_destination', $userGareId)
                                            ->count();
        // Colis rendus cette semaine
        $colisRendusCetteSemaine = ColisArriver::whereBetween('created_at', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ])
            ->where('rendu', true)
            ->when([$user, $userGareId], function ($query) use ($user, $userGareId) {
                $query->where('user_id', $user)
                    ->where('gare_destination', $userGareId);
            })
            ->count();

        // Colis envoyer ce mois
        $colisEnvoyerCeMois = Colis::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->when($userGareId, function ($query) use ($userGareId) {
                $query->where('gare_destination', $userGareId);
            })
            ->count();

        // Colis rendus ce mois
        $colisRendusCeMois = ColisArriver::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->where('rendu', true)
            ->when($userGareId, function ($query) use ($userGareId) {
                $query->where('gare_destination', $userGareId);
            })
            ->count();

        // Total colis annulés définitivement
        $colisAnnules = ColisAnnuler::where('annuler', true)
                        ->where('user_id', $user)
                        ->where('gare_envois', $userGareId)
                        ->count();
        $montantColisAnnuler = Colis::where('status_envois', 'annulee')
                                ->where('user_id', $user)
                                ->where('gare_envois', $userGareId)
                                ->sum('montant');

        // Montant total des colis
        $montantColisEnvoyer = Colis::where('status_envois', '<>', 'annulee')
                                    ->where('user_id', $user)
                                    ->where('gare_envois', $userGareId)
                                    ->sum('montant');
        $montantColisRendu = Colis::where('status_envois', 'arrivee')
                                    ->where('user_id', $user)
                                    ->where('gare_envois', $userGareId)
                                    ->sum('montant');

        // ===== STATISTIQUES PAR GARE (si l'utilisateur a une gare) =====

        $colisVersMaGare = 0;
        $colisArrivesMaGare = 0;
        $colisRendusMaGare = 0;

        if ($userGareId) {
            $colisVersMaGare = Colis::where('gare_destination', $userGareId)
                ->whereIn('status_envois', ['depot', 'encours'])
                ->count();

            $colisArrivesMaGare = Colis::where('gare_destination', $userGareId)
                ->where('status_envois', 'arriver')
                ->count();

            $colisRendusMaGare = ColisArriver::where('gare_destination', $userGareId)
                ->where('rendu', true)
                ->count();
        }

        // ===== DONNÉES POUR GRAPHIQUES =====

        // Colis par mois (12 derniers mois)
        $colisParMois = Colis::select(
                DB::raw('MONTH(created_at) as mois'),
                DB::raw('YEAR(created_at) as annee'),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('annee', 'mois')
            ->orderBy('annee')
            ->orderBy('mois')
            ->get()
            ->map(function ($item) {
                $item->nom_mois = Carbon::create()
                    ->month($item->mois)
                    ->locale('fr')
                    ->format('M Y');
                return $item;
            });

        // Colis rendus par jour (7 derniers jours)
        $colisRendusParJour = ColisArriver::where('rendu', true)
            ->where('created_at', '>=', now()->subDays(7))
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function ($item) {
                $item->nom_jour = Carbon::parse($item->date)
                    ->locale('fr')
                    ->format('d/m');
                return $item;
            });

        // Top 5 gares d'envoi les plus actives
        $topGaresEnvois = Colis::select('gare_envois', DB::raw('COUNT(*) as total'))
            ->with('gareEnvois')
            ->groupBy('gare_envois')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // Top 5 gares de destination les plus actives
        $topGaresDestination = Colis::select('gare_destination', DB::raw('COUNT(*) as total'))
            ->with('gare')
            ->groupBy('gare_destination')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // Derniers colis rendus
        $derniersColisRendus = ColisArriver::with(['colis', 'user'])
            ->where('rendu', true)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Derniers colis créés
        $derniersColisCrees = Colis::with(['TypeColis', 'gare', 'gareEnvois'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'colisEnvoyer',
            'colisRendus',
            'colisParStatut',
            'colisRendusAujourdhui',
            'colisEnvoyerAujourdhui',
            'colisRendusCetteSemaine',
            'colisEnvoyerCetteSemaine',
            'colisRendusCeMois',
            'colisAnnules',
            'montantColisAnnuler',
            'montantColisEnvoyer',
            'montantColisRendu',
            'colisVersMaGare',
            'colisArrivesMaGare',
            'colisRendusMaGare',
            'userGareId',
            'colisParMois',
            'colisRendusParJour',
            'topGaresEnvois',
            'topGaresDestination',
            'derniersColisRendus',
            'derniersColisCrees'
        ));
    }
}