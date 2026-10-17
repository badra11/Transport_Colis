<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gare;
use App\Models\Colis;
use App\Models\colisArriver;

class colisArriverController extends Controller
{
  /**
 * Affiche la page de récupération par code
 */
public function recuperationColis(){
    $gares = Gare::all();
    return view('recuperer.recuperationColis', compact('gares'));
}

/**
 * Vérifie le code de récupération  userRendu->name
 */
public function verifierCodeRecuperation(Request $request){
    $request->validate([
        'code_recuperation' => 'required|string|max:255',
    ]);

    $poste = auth()->user()->gare->id;

    $colis = Colis::where('code_recuperation', $request->code_recuperation)
        ->where('gare_destination', $poste)
        ->with(['gare', 'gareEnvois', 'TypeColis', 'userRendu'])
        ->first();

    if (!$colis) {
        return redirect()->back()
            ->with('error', 'Code de récupération invalide ou colis non trouvé dans cette gare.');
    }

    // Vérifier le statut
    if ($colis->status_envois === 'rendu') {
        return redirect()->back()
            ->with('warning', 'Ce colis a déjà été récupéré le ' . $colis->updated_at->format('d/m/Y à H:i') . '.')
            ->with('colisDejaRendu', $colis);
    }

    if ($colis->status_envois !== 'arriver') {
        return redirect()->back()
            ->with('error', 'Ce colis n\'est pas encore arrivé à destination. Statut actuel : ' . $colis->status_envois);
    }

    return redirect()->back()
        ->with('success', 'Colis réceptionné ! Vous pouvez maintenant le rendre.')
        ->with('colisTrouve', $colis);
}

/**
 * Marque le colis comme rendu
 */
public function rendreColis(string $id, Request $request){
    $colis = Colis::findOrFail($id);

    if ($colis->status_envois !== 'arriver') {
        return redirect()->back()->with('error', 'Ce colis ne peut pas être réceptionné.');
    }

    $colis->update([
        'status_envois' => 'arrivee',
    ]);

    ColisArriver::create([
        'colis_id'         => $colis->id,
        'user_id'          => auth()->id(),
        'gare_envois'      => $colis->gare_envois,
        'gare_destination' => $colis->gare_destination,
        'rendu'            => true, // ou 'oui'
    ]);
    
    return redirect()->route('recupererColis.colisRendus')
        ->with('success', 'Colis Rendu avec succès !');
    }

    public function colisRendus(){
        $poste = auth()->user()->gare->id;

    $colisRendus = ColisArriver::where('gare_destination', $poste)
        ->where('rendu', true)
        ->with(['colis.TypeColis', 'colis.gare', 'colis.gareEnvois', 'user', 'gareEnvois', 'gareDestination'])
        ->orderBy('created_at', 'desc')
        ->paginate(20);

    return view('recuperer.colisRendus', compact('colisRendus'));
    }

     
}
