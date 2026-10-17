<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::orderBy('id', 'desc')->get();
        return view('permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        Permission::create($data);

        $request->session()->flash('swal',[
            'icon' => 'success',
            'title' => 'Creation Validée',
            'text' => 'Permission créée avec succès',
        ]);

        return redirect()->route('permissions.index')->with('success', 'Permission créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        return view('permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $permission->update($data);

        $request->session()->flash('swal',[
            'icon' => 'success',
            'title' => 'Mise à jour Validée',
            'text' => 'Permission mise à jour avec success',
        ]);

        return redirect()->route('permissions.index',$permission)->with('success', 'Permission mise à jour avec succès.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Permission $permission)
    {
        $permission->delete();

        $request->session()->flash('swal',[
            'icon' => 'success',
            'title' => 'Suppression Validée',
            'text' => 'Permission supprimée avec success',
        ]);

        return redirect()->route('permissions.index', $permission)->with('success', 'Permission supprimée avec succès.');
    }
}
