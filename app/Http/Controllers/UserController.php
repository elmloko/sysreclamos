<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::withTrashed()->paginate(); // Incluye usuarios eliminados

        return view('user.index', compact('users'))
            ->with('i', (request()->input('page', 1) - 1) * $users->perPage());
    }

    public function create()
    {
        $user  = new User();
        $roles = Role::all();

        return view('user.create', compact('user','roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:8',
            'city'     => 'required',
            'ci'       => 'required',
            'roles'    => 'required|array',          // <- validar roles
            'roles.*'  => 'exists:roles,id',         // <- que existan en tabla roles
        ]);
    
        $user = new User();
        $user->name     = $request->input('name');
        $user->email    = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->city     = $request->input('city');
        $user->ci       = $request->input('ci');
        $user->save();

        // Convertir IDs a NOMBRES, que es lo que usa Spatie internamente
        $roleNames = Role::whereIn('id', $request->roles)->pluck('name')->toArray();
        $user->syncRoles($roleNames);

        return redirect()->route('users.index')
            ->with('success', 'Usuario creado correctamente');
    }

    public function show($id)
    {
        $user = User::find($id);

        return view('user.show', compact('user'));
    }

    public function edit($id)
    {
        $user  = User::find($id);
        $roles = Role::all();

        return view('user.edit', compact('user','roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'city'     => 'required',
            'ci'       => 'required',
            'roles'    => 'required|array',
            'roles.*'  => 'exists:roles,id',
        ]);

        $user->name  = $request->input('name');
        $user->email = $request->input('email');
        $user->city  = $request->input('city');
        $user->ci    = $request->input('ci');
        $user->save();

        // Igual que en store: convertir IDs a nombres
        $roleNames = Role::whereIn('id', $request->roles)->pluck('name')->toArray();
        $user->syncRoles($roleNames);

        return redirect()->route('users.index')
            ->with('success', 'Usuario actualizado correctamente');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Usuario dado de baja correctamente');
    }

    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();

        return redirect()->route('users.index')
            ->with('success', 'Usuario reactivado correctamente');
    }
}
