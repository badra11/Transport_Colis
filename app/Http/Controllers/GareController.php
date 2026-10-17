<?php

namespace App\Http\Controllers;

use App\Models\Gare;
use Illuminate\Http\Request;

class GareController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gares = Gare::orderBy('id','DESC')->get();
        return view('gares.index', compact('gares'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('gares.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'gare' => 'required|max:100|string',
        ]);
        Gare::create($data);
        $request->session()->flash('swal',[
            'icon' => 'success',
            'title' => 'Creation Validée',
            'text' => 'Gare creer avec success',
        ]);
        return redirect()->route('gares.index')->with('success', 'Gare creer avec success.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Gare $gare)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gare $gare)
    {
       return view('gares.edit', compact('gare'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gare $gare)
    {
        $data = $request->validate([
            'gare' => 'required|string|max:100',
        ]);
        // $gare = Gare::find($gare);
        $gare->update($data);

         $request->session()->flash('swal',[
            'icon' => 'success',
            'title' => 'Modification Validée',
            'text' => 'Gare modifier avec success',
        ]);

        return redirect()->route('gares.index', $gare)->with('success', 'Gare modifier avec success.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gare $gare)
    {
        // $gare = Gare::find($gare);
        $gare->delete();

        return redirect()->route('gares.index', $gare)->with('success', 'Gare supprimer avec success.');
    }
}
