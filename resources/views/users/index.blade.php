@extends('layout')

@section('title', 'Usuarios')
        
@section('content')    
    <h1>{{$title}}</h1>
    <p>
        <a href="{{ route('users.create') }}">Nuevo usuario</a>
    </p>

    @if ($users->isNotEmpty())

    <table class="table">
        <thead class="thead-dark">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Nombre</th>
            <th scope="col">Correo</th>
            <th scope="col">Acciones</th>
          </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
          <tr>
            <th scope="row">{{ $user->id }}</th>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                <a href="{{ route('users.details', $user) }}">Ver detalles </a> | 
                <a href="{{ route('users.edit', $user) }}">Editar</a> |
                <form action="{{ route('users.destroy', $user) }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="submit">Eliminar</button>
                </form>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
      @else
        <p>No hay usuarios registrados.</p>
      @endif
@endsection

@section('sidebar')
    @parent
@endsection
    
   