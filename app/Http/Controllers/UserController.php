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
        $title = 'Crear Nuevo Usuario';

        return view('create', compact('title'));
        
    }

    public function edit($id)
    {
        $title = 'Editar Usuario';

        return view('edit', compact('title','id'));
        
    }
}
