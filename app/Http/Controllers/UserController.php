<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        if(request()->has('empty')) {
            $users = [];
        } else {
           $users = [
            'Joel',
            'Ellie',
            'Tess',
            'Tommy',
            'Bill',
        ]; 
        }

        $title ='Listado de usuarios';

        return view('users.index', compact('title','users'));
    }

    public function show($id)
    {


        return view('users.details', compact('id'));

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
