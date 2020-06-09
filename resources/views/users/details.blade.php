
@extends('layout')

@section('title', "Usuario {$user->id}")

@section('content')

    <div class="card">
       <h4 class="card-header">Usuario #{{$user->id}}</h4>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Nombre del usuario: {{ $user->name }}</li>
                <li class="list-group-item">Correo electronico: {{ $user->email }}</li>
                <li class="list-group-item"><a href="{{ route('users.index') }}">Regresar al listado de usuarios</a></li>
              </ul>
              
        </div>
    
    </div>
    
@endsection