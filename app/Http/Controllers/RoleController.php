<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::orderBy('id','DESC')->get();
       
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:roles,name',
        ]);

        $roles = Role::create($data);
         if (!empty($request->permission) && is_array($request->permission)) {
            foreach ($request->permission as $name) {
                $roles->givePermissionTo($name);
            }
        }
        $request->session()->flash('swal',[
            'icon' => 'success',
            'title' => 'Creation Validée',
            'text' => 'Role creer avec success',
        ]);
        return redirect()->route('roles.index')->with('success', 'Role creer avec success.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
        ]);

        $role->update($data);
        if (!empty($request->permission) && is_array($request->permission)) {
           $role->syncPermissions($request->permission);
        } else {
            $role->syncPermissions([]);
        }

        $request->session()->flash('swal',[
            'icon' => 'success',
            'title' => 'Modification Validée',
            'text' => 'Role modifier avec success',
        ]);

        return redirect()->route('roles.index', $role)->with('success', 'Role modifier avec success.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Role $role)
    {
        $role->delete();

        $request->session()->flash('swal',[
            'icon' => 'success',
            'title' => 'Suppression Validée',
            'text' => 'Role supprimer avec success',
        ]);

        return redirect()->route('roles.index', $role)->with('success', 'Role supprimer avec success.');
    }
}
