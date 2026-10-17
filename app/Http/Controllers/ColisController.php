<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


use App\Models\Colis;
use App\Models\colisAnnuler;
use App\Models\Gare;
use App\Models\TypeColis;
use Illuminate\Http\Request;

class ColisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $poste = auth()->user()->gare_id;
        $colis = Colis::orderBy('id', 'DESC')
            ->where('status_envois', 'Dépot')
            ->where('gare_envois', $poste)
            ->with('gare','TypeColis')
            ->paginate(10);
        $gares = Gare::all();
        return view('colis.index', compact('colis','gares'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $type_colis = TypeColis::all();
        $gares = Gare::all();
        return view('colis.create', compact('type_colis','gares'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Colis $colis)
    {
        $data = $request->validate([
        'nom_envoyeur' => 'required|string|max:100',
        'numero_envoyeur' => 'required|string|max:100',
        'nom_destinataire' => 'required|string|max:100',
        'numero_destinataire' => 'required|string|max:100',
        'type_colis_id' => 'required|exists:type_colis,id',
        'unite' => 'required|string|in:poids,valeur,forfait',
        'quantite' => 'required|numeric|min:0.01',
        'montant' => 'required|numeric|min:0',
        'gare_destination' => 'required|exists:gares,id',
    ]);

    $user = $request->user();

    DB::transaction(function () use ($request, $user, $data) {
    $data['user_id'] = $user->id;
    $data['status_envois'] = 'Depot';
    $data['numero_année'] = $this->genererNumeroAnnuel();
    $data['numero_journée'] = $this->genererNumeroQuotidien();
    $data['gare_envois'] = auth()->user()->gare_id;

    // Generate unique code
    $gare = Gare::findOrFail($request->gare_destination);
    $gareCode = strtoupper(substr($gare->gare, 0, 3));
    $data['code_recuperation'] = sprintf('%s-%s-%d', 
    $data['numero_année'], 
    $gareCode,
    $data['user_id'],
        // now()->format('His') // Add timestamp to avoid collisions
    );

    Colis::create($data);
    });

      $request->session()->flash('swal',[
            'icon' => 'success',
            'title' => 'Creation Validée',
            'text' => 'Colis  N° ' . $colis->id . ' créée avec success',
        ]);


    return redirect()->route('colis.index')->with('success', 'Colis  N° ' . $colis->id . ' créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Colis $colis)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Colis $colis)
    {
        $type_colis = TypeColis::all();
        $gares = Gare::all();
        return view('colis.edit', compact('colis','type_colis','gares'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Colis $colis)
    {
        $data = $request->validate([
        'nom_envoyeur' => 'required|string|max:100',
        'numero_envoyeur' => 'required|string|max:100',
        'nom_destinataire' => 'required|string|max:100',
        'numero_destinataire' => 'required|string|max:100',
        'type_colis_id' => 'required|exists:type_colis,id',
        'unite' => 'required|string|in:poids,valeur,forfait',
        'quantite' => 'required|numeric|min:0.01',
        'montant' => 'required|numeric|min:0',
        'gare_destination' => 'required|exists:gares,id',
    ]);


        $colis->update($data);

        $request->session()->flash('swal',[
            'icon' => 'success',
            'title' => 'Modification Validée',
            'text' => 'Colis  N° ' . $colis->id . ' modifier avec success',
        ]);

        return redirect()->route('colis.index')->with('success', 'Colis  N° ' . $colis->id . ' modifier avec success.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Colis $colis)
    {
        $colis->delete();

        $request->session()->flash('swal',[
            'icon' => 'success',
            'title' => 'Suppression Validée',
            'text' => 'Colis N° ' . $colis->id . ' supprimer avec success',
        ]);

        return redirect()->route('colis.index')->with('success', 'Colis  N° ' . $colis->id . ' supprimer avec success.');
    }
   
     /**
     * Génère un numéro d'envoi incrémenté quotidiennement
     * Format: N-JJ/MM/AAAA (ex: 1-09/02/2026)
     */
    public function genererNumeroQuotidien(): string
    {
        $aujourdHui = Carbon::today();
        $dateFormatee = $aujourdHui->format('d/m/Y');

        // Récupérer le dernier numéro du jour
        $dernierNumero = $this->getDernierNumeroDuJour($aujourdHui);

        // Incrémenter
        $nouveauNumero = $dernierNumero + 1;

        return "{$nouveauNumero}-{$dateFormatee}";
    }
     /**
     * Génère un numéro d'envoi incrémenté annuellement
     * Format: N-AAAA (ex: 1-2026)
     */
    public function genererNumeroAnnuel(): string
    {
        $annee = Carbon::now()->year;

        // Récupérer le dernier numéro de l'année
        $dernierNumero = $this->getDernierNumeroDeAnnee($annee);

        // Incrémenter
        $nouveauNumero = $dernierNumero + 1;

        return "{$nouveauNumero}-{$annee}";
    }
     /**
     * Récupère le dernier numéro utilisé aujourd'hui
     */
    private function getDernierNumeroDuJour(Carbon $date): int
    {
        $debutJour = $date->copy()->startOfDay();
        $finJour = $date->copy()->endOfDay();

        // Utiliser une requête optimisée avec lock pour éviter les doublons en concurrence
        return DB::transaction(function () use ($debutJour, $finJour) {
            $dernierColis = Colis::whereBetween('created_at', [$debutJour, $finJour], 'and')
                ->lockForUpdate()
                ->orderBy('created_at', 'desc')
                ->first();

            if (!$dernierColis) {
                return 0;
            }

            // Extraire le numéro du format "N-JJ/MM/AAAA"
            return (int) explode('-', $dernierColis->numero_journée)[0];
        });
    }

     /**
     * Récupère le dernier numéro utilisé cette année
     */
    private function getDernierNumeroDeAnnee(int $annee): int
    {
        $debutAnnee = Carbon::create($annee, 1, 1)->startOfDay();
        $finAnnee = Carbon::create($annee, 12, 31)->endOfDay();

        return DB::transaction(function () use ($debutAnnee, $finAnnee, $annee) {
            // Chercher les numéros au format "N-AAAA" pour cette année
            $dernierColis = Colis::whereBetween('created_at', [$debutAnnee, $finAnnee], 'and')
                ->where('numero_année', 'like', '%-' . $annee)
                ->lockForUpdate()
                ->orderBy('id', 'desc')
                ->first();

            if (!$dernierColis) {
                return 0;
            }

            // Extraire le numéro du format "N-AAAA"
            return (int) explode('-', $dernierColis->numero_année)[0];
        });
    }

    // Méthodes pour les routes spécifiques à la gestion des colis déposés vers une gare

    public function depotColisVersGare()
    {
        $poste = auth()->user()->gare->id;
        $colis = Colis::select('gare_destination')
            ->selectRaw('COUNT(*) as nbr')
            ->where('status_envois', 'Depot')
            ->where('gare_envois', $poste)
            ->where('gare_destination', '<>', $poste)
            ->groupBy('gare_destination')
            ->orderBy('nbr', 'DESC')
            ->paginate(10);
        $gares = Gare::all();
        return view('colisPosseder.depotColisVersGare', compact('colis','gares'));
    }
 
    // Affiche la liste des colis déposés vers une gare spécifique

    public function listeColisVersGare(Request $request){
        $poste = auth()->user()->gare->id;
        $gareDest = $request->query('gare_destination');
        if (!$gareDest) {
        return redirect()->back()->with('error', 'Gare de destination non spécifiée');
    }
        $colis = Colis::query()->where('status_envois', 'Depot')
            ->where('gare_envois', $poste)
            ->where('gare_destination',  $gareDest)
            ->with('gare','TypeColis')
            ->orderBy('id', 'DESC')
            ->paginate(10);
        $gare = Gare::findOrfail($gareDest);
        $gares = Gare::all();
        return view('colisPosseder.listeColisVersGare' , compact('colis','gares', 'gare'));
    }

   
    /**
     * Envoyer un colis spécifique
     */
    public function envoyerDepot($id){
        $poste = auth()->user()->gare->id;
        
        Colis::query()->where('status_envois', 'depot')
            ->where('id', $id)
            ->where('gare_envois', $poste)
            ->update(['status_envois' => 'encours']);
            
        return redirect()->route('colisPosseder.listeColisVersGare')
            ->with('success', 'Colis envoyé avec succès');
    }

    /**
     * Annuler un colis spécifique
     */
    public function annulerDepot($id)
    {
        $poste = auth()->user()->gare->id;
        
        Colis::query()->where('status_envois', 'depot')
            ->where('id', $id)
            ->where('gare_envois', $poste)
            ->update(['status_envois' => 'annuler']);
            
        return redirect()->route('colisPosseder.listeColisVersGare')
            ->with('error', 'Colis annulé');
    }

    /**
     * Envoyer tous les colis vers une gare destination
     */
    public function envoyerToutVersGare(Request $request)
    {
        $poste = auth()->user()->gare->id;
        $gareDestination = $request->input('envoyerTout');
        
        $colis = Colis::query()->where('status_envois', 'depot')
            ->where('gare_destination', $gareDestination)
            ->where('gare_envois', $poste)
            ->update(['status_envois' => 'encours']);
            
        return redirect()->route('colisPosseder.listeColisVersGare', ['gare_destination' => $gareDestination])
            ->with('success', 'Tous les colis ont été envoyés');
    }


    public function colisEnCoursVersGare()
    {
        $poste = auth()->user()->gare->id;
        $colis = Colis::select('gare_destination')
            ->selectRaw('COUNT(*) as nbr')
            ->where('status_envois', 'encours')
            ->where('gare_envois', $poste)
            ->where('gare_destination', '<>', $poste)
            ->groupBy('gare_destination')
            ->orderBy('nbr', 'DESC')
            ->paginate(10);
        $gares = Gare::all();
        return view('colisPosseder.colisEnCoursVersGare', compact('colis','gares'));
    }

    public function listeEncoursVersGare(Request $request)
    {
    $poste = auth()->user()->gare->id;
    $gareDest = $request->query('gare_destination');
    if (!$gareDest) {
    return redirect()->back()->with('error', 'Gare de destination non spécifiée');
    }
    $colis = Colis::query()->where('status_envois', 'encours')
    ->where('gare_envois', $poste)
    ->where('gare_destination',  $gareDest)
    ->with('gare','TypeColis')
    ->orderBy('id', 'DESC')
    ->paginate(10);
    $gare = Gare::findOrfail($gareDest);
    $gares = Gare::all();
    return view('colisPosseder.listeEncoursVersGare' , compact('colis','gares', 'gare'));
    }

    public function annulerEncours($id){
            $poste = auth()->user()->gare->id;
    
        Colis::query()->where('status_envois', 'encours')
            ->where('id', $id)
            ->where('gare_envois', $poste)
            ->update(['status_envois' => 'annuler']);
            
        return redirect()->route('colisPosseder.listeEncoursVersGare')
            ->with('error', 'Colis annulé');
    }

    public function annulerToutVersGare(Request $request){
            $poste = auth()->user()->gare->id;
        $gareDestination = $request->input('annulerTout');
        
        $colis = Colis::query()->where('status_envois', 'encours')
            ->where('gare_destination', $gareDestination)
            ->where('gare_envois', $poste)
            ->update(['status_envois' => 'annuler']);
            
        return redirect()->route('colisPosseder.listeEncoursVersGare', ['gare_destination' => $gareDestination])
            ->with('error', 'Tous les colis ont été annulé');
    }   

    public function colisArriverVersGare(){
        $poste = auth()->user()->gare->id;
        $colis = Colis::query()->select('gare_envois')
            ->selectRaw('COUNT(*) as nbr')
            ->where('status_envois', 'encours')
            ->where('gare_destination', $poste)
            ->groupBy('gare_envois')
            ->orderBy('nbr', 'DESC')
            ->paginate(10);
        $gares = Gare::all();
        return view('colisPosseder.colisArriverVersGare', compact('colis','gares'));
    }

    public function listeArriverVersGare(Request $request){
        $poste = auth()->user()->gare->id;
        $gareEnv = $request->query('gare_envois');
        if (!$gareEnv) {
        return redirect()->back()->with('error', 'Gare d\'Envois non spécifiée');
    }
        $colis = Colis::query()->where('status_envois', 'encours')
            ->where('gare_destination', $poste)
            ->where('gare_envois',  $gareEnv)
            ->with(['gare', 'TypeColis'])
            ->orderBy('id', 'DESC')
            ->paginate(10);
        $gare = Gare::findOrfail($gareEnv);
        $gares = Gare::all();
        return view('colisPosseder.listeArriverVersGare' , compact('colis','gares', 'gare'));
    }

    public function receptionColis($id){
        $poste = auth()->user()->gare->id;
    
        Colis::query()->where('status_envois', 'encours')
            ->where('id', $id)
            ->where('gare_destination', $poste)
            ->update(['status_envois' => 'arriver']);
            
        return redirect()->route('colisPosseder.listeArriverVersGare')
            ->with('success', 'Colis réceptionné avec succès');
    }

    public function receptionToutVersGare(Request $request){
        $poste = auth()->user()->gare->id;
        $gareEnv = $request->input('receptionTout');
        
        $colis = Colis::query()->where('status_envois', 'encours')
            ->where('gare_envois', $gareEnv)
            ->where('gare_destination', $poste)
            ->update(['status_envois' => 'arriver']);
            
        return redirect()->route('colisPosseder.listeArriverVersGare', ['gare_envois' => $gareEnv])
            ->with('success', 'Tous les colis ont été réceptionné');
    }

    public function colisArriverGare(){
        $poste = auth()->user()->gare->id;
        $colis = Colis::query()->where('status_envois', 'arriver')
            ->where('gare_destination', $poste)
            ->with(['gare', 'TypeColis'])
            ->orderBy('id', 'DESC')
            ->paginate(10);
        $gares = Gare::all();
        return view('colisPosseder.colisArriverGare', compact('colis','gares'));
    }

    public function colisAnnulerVersGare(){
        $poste = auth()->user()->gare->id;
        $colis = Colis::select('gare_destination')
            ->where('status_envois', 'annuler')
            ->selectRaw('COUNT(*) as nbr')
            ->where('gare_envois', $poste)
            ->with(['gare', 'TypeColis'])
            ->groupBy('gare_destination')
            ->orderBy('id', 'DESC')
            ->paginate(10);
        $gares = Gare::all();
        return view('colisPosseder.colisAnnulerVersGare', compact('colis','gares'));
    }

    public function listeColisAnnulerVersGare(Request $request){
        $poste = auth()->user()->gare->id;
        $gareDest = $request->query('gare_destination');
        if (!$gareDest) {
        return redirect()->back()->with('error', 'Gare de destination non spécifiée');
        }
        $colis = Colis::query()->where('status_envois', 'annuler')
            ->where('gare_envois', $poste)
            ->where('gare_destination',  $gareDest)
            ->with('gare','TypeColis')
            ->orderBy('id', 'DESC')
            ->paginate(10);
        $gare = Gare::findOrfail($gareDest);
        $gares = Gare::all();
        return view('colisPosseder.listeColisAnnulerGare' , compact('colis','gares', 'gare'));
    }

    public function renvoyerColis(string $id){
        $colis = Colis::findOrFail($id);
        if ($colis->status_envois !== 'annuler') {
            return redirect()->back()->with('error', 'Ce colis ne peut pas être renvoyé.');
        }
        $colis->update([
            'status_envois' => 'depot',
        ]);
        return redirect()->back()->with('success', 'Colis renvoyé avec succès !');
    }

    public function annulerDefinitivement(string $id){
        $colis = Colis::findOrFail($id);

        if ($colis->status_envois !== 'annuler') {
            return redirect()->back()->with('error', 'Ce colis ne peut pas être annulé.');
        }
        // Enregistrer dans la table colis_annuler
        ColisAnnuler::create([
            'colis_id'         => $colis->id,
            'user_id'          => auth()->id(),
            'gare_envois'      => $colis->gare_envois,
            'gare_destination' => $colis->gare_destination,
            'annuler'            => true, // ou 'oui'
        ]);

        // Mettre à jour le statut du colis
        $colis->update([
            'status_envois' => 'annulee',
        ]);

        return redirect()->back()->with('success', 'Colis annulé définitivement !');
    }

    public function colisAnnulerDefinitive(){
        $poste = auth()->user()->gare->id;
        $colisAnnuler = colisAnnuler::where('gare_envois', $poste)
                        ->where('annuler', true)
                        ->with(['colis.TypeColis', 'colis.gare', 'colis.gareEnvois', 'user', 'gareEnvois', 'gareDestination'])
                        ->orderBy('created_at', 'desc')
                        ->paginate(20);
        return view('recuperer.colisAnnulerDefinitive', compact('colisAnnuler'));
    }
    

}
