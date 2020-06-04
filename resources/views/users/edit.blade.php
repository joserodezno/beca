
@extends('layout')

@section('title', "Actualizar usuario")

@section('content')

    <div class="card">
        <h4 class="card-header">Editar usuario</h4>
        <div class="card-body">
    @if ($errors->any())
    <div class="alert alert-danger">
        <h6>Por favor corrige los errores debajo:</h6>
        <ul>
            @foreach ($errors->all() as $errors)
                <li>{{ $errors }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ url("usuarios/{$user->id}")}}">
        {{ method_field('PUT') }}
        {!! csrf_field() !!}

        <div class="form-group">
            <label for="name">Nombre:</label>
            <input type="text" name="name"  id="name" placeholder="Pedro Perez" value="{{ old('name', $user->name)}}">  
        </div>
        
        <div class="form-group">
            <label for="email">Correo electrónico:</label>
            <input type="email" name="email"  id="email" placeholder="pedro@exmaple.com" value="{{ old('email', $user->email)}}">     
        </div>
        
        
        <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" placeholder="Mayor a 6 caracteres">       
        </div>

        <br>
        <button type="submit" class="btn btn-primary">Actualizar usuario</button>
        <a href="{{ route('users.index') }}" class="btn btn-link">Regresar al listado de usuarios</a>
    </form>
    </div>
    </div>
@endsection
