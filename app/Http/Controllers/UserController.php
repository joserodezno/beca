<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
       $users = User::all();

        $title ='Listado de usuarios';


        return view('users.index', compact('title','users'));
    }

    public function show(User $user)
    {

        return view('users.details', compact('user'));

    }

    public function create()
    {

        return view('users.create');
        
    }

    public function store()
    {

        $data = request()->validate([
            'name' => 'required',
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:6']
        ], [
            'name.required' => 'El campo Nombre es obligatorio',
            'email.required' => 'El campo Correo electronico es obligatorio',
            'email.unique' => 'este correo ya esta registrado',
            'password.required' => 'El campo Contraseña es obligatorio',
            'password.min' => 'La contraseña debe de tener minimo 6 caracteres'
        ]);


        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);

        return redirect()->route('users.index');
    }

    public function edit(User $user)
    {
        return view('users.edit', ['user' => $user]);
        
    }
}
