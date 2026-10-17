<?php

namespace App\Http\Controllers;

use App\Models\Gare;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\Middleware;

class UserController extends Controller
{


    public static function middleware(): array
    { 
        return [
            new Middleware('permission:view users',only: ['index','show']),
            new Middleware('permission:create users',only: ['create', 'store']),
            new Middleware('permission:edit users',only: ['edit', 'update']),
            new Middleware('permission:delete users',only: ['destroy']),

        ];
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('id','DESC')->with('gare')->paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $gares = Gare::all();
        $roles = Role::all();
        return view('users.create', compact('gares', 'roles'));
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'gare_id' => 'required|exists:gares,id',
            'role' => 'required|array',
            'role.*' => 'exists:roles,name',
        ]);

        // 1. Extraire et supprimer le rôle du tableau de création
        $roles = $data['role'];
        unset($data['role']);


        // Supprimer password_confirmation des données avant création
        unset($data['password_confirmation']);

        $user = User::create($data);
        if (!empty($request->role) && is_array($request->role)) {
           $user->syncRoles($request->role);
        } else {
            $user->syncRoles([]);
        }
        // $user->syncRoles($roles);

         $request->session()->flash('swal',[
            'icon' => 'success',
            'title' => 'Creation Validée',
            'text' => 'Utilisateur créée avec success',
        ]);

        return redirect()->route('users.index')->with('success', 'Utilisateur créé avec succès.');

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
    public function edit(User $user)
    {
        $gares = Gare::all();
        $roles = Role::all();
        return view('users.edit', compact('user', 'gares', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
         $data = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
            'gare_id' => 'required|exists:gares,id',
            'role' => 'required|array',
            'role.*' => 'exists:roles,name',
            
        ]);


        // 1. On extrait le rôle pour ne pas qu'il soit dans $data
        $roles = $data['role']; 
        unset($data['role']); 

        // Supprimer password_confirmation des données avant création
        unset($data['password_confirmation']);

        // Add this before update
        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']); // Don't update if empty
}

        $user->update($data);
        // $user->syncRoles($data['role']); 
         if (!empty($request->role) && is_array($request->role)) {
           $user->syncRoles($request->role);
        } else {
            $user->syncRoles([]);
        }
    


         $request->session()->flash('swal',[
            'icon' => 'success',
            'title' => 'Mis à jour Validée',
            'text' => 'Utilisateur'. $user->name . 'mis à jour avec success',
        ]);

        return redirect()->route('users.index')->with('success', 'Utilisateur'. $user->name . 'mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, User $user)
    {
        $user->delete();
         $request->session()->flash('swal',[
            'icon' => 'success',
            'title' => 'Suppression Validée',
            'text' => 'Utilisateur'. $user->name . ' supprimé avec success',
        ]);
        return redirect()->route('users.index')->with('success', 'Utilisateur'. $user->name . 'supprimé avec succès.');
    }
}
