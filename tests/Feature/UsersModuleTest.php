<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UsersModuleTest extends TestCase
{
    /** @test */
    public function it_shows_the_users_list_page()
    {
        $this->get('/usuarios')
        ->assertStatus(200)
        ->assertSee('Listado de usuarios')
        ->assertSee('Joel')
        ->assertSee('Ellie');
    }

    /** @test */
    public function it_shows_default_message_if_user_list_is_empty()
    {
        $this->get('/usuarios?empty=1')
        ->assertStatus(200)
        ->assertSee('No hay usuarios registrados.');
    }

    /** @test */

    function loads_users_details_page()
    {
        $this->get('/usuarios/5')
        ->assertStatus(200)
        ->assertSee('Mostrando detalles del usuario: 5');
    }

    /** @test */

    function loads_new_users_page()
    {
       $this->get('/usuarios/nuevo')
       ->assertStatus(200)
       ->assertSee('Crear nuevo usuario');
    }

    /** @test */

    function edit_users_page()
    {
        $this->get('/usuarios/3/edit')
        ->assertStatus(200)
        ->assertSee('Editar usuario: 3');
    }

    function page_not_found()
    {
        $this->get('/usuarios/texto/edit')
        ->assertStatus(404);        
    }
}
