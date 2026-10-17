<?php

namespace App\Http\Controllers;

use App\Models\TypeColis;
use Illuminate\Http\Request;

class TypeColisController extends Controller
{
      public function index()
    {
        $typecolis = TypeColis::orderBy('id','DESC')->get();
        return view('type_colis.index', compact('typecolis'));
    }
    public function create()
    {
        return view('type_colis.create');
    }

   
    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|string|max:255',
        ]);
        TypeColis::create($data);

        $request->session()->flash('swal',[
            'icon' => 'success',
            'title' => 'Creation Validée',
            'text' => 'Type de colis creer avec success',
        ]);

        return redirect()->route('type_colis.index')->with('success', 'Type de colis creer avec success.');
    }

   
    public function show(TypeColis $typeColis)
    {
        //
    }

   
    public function edit(TypeColis $typeColis)
    {
    
        return view('type_colis.edit', compact('typeColis'));
    }

   
    public function update(Request $request, TypeColis $typeColis)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        
        $typeColis->update($data);

        $request->session()->flash('swal',[
            'icon' => 'success',
            'title' => 'Modification Validée',
            'text' => 'Type de colis modifier avec success',
        ]);

        return redirect()->route('type_colis.index', $typeColis)->with('success', 'Type de colis modifier avec success.');
    }

    
    public function destroy(Request $request, TypeColis $typeColis)
    {
        // $colis = TypeColis::find($colis);

        $typeColis->delete();

        $request->session()->flash('swal',[
            'icon' => 'success',
            'title' => 'Suppression Validée',
            'text' => 'Type de colis supprimer avec success',
        ]);

        return redirect()->route('type_colis.index', $typeColis)->with('success', 'Type de colis supprimer avec success.');
    }
}
