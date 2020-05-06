<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UsersModuleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_shows_the_users_list_page()
    {
        factory(User::class)->create([
            'name'=>'Joel',
        ]);

        factory(User::class)->create([
            'name'=>'Ellie',
        ]);

        $this->get('/usuarios')
        ->assertStatus(200)
        ->assertSee('Listado de usuarios')
        ->assertSee('Joel')
        ->assertSee('Ellie');
    }

    /** @test */
    public function it_shows_default_message_if_user_list_is_empty()
    {

        $this->get('/usuarios')
        ->assertStatus(200)
        ->assertSee('No hay usuarios registrados.');
    }

    /** @test */

    function loads_users_details_page()
    {
        $user = factory(User::class)->create([
            'name' => 'Jose Rodezno'
        ]);

        $this->get('/usuarios/'.$user->id)
        ->assertStatus(200)
        ->assertSee('Jose Rodezno');
    }

    /** @test */

    function displays_error_404_if_user_not_found()
    {
        $this->get('/usuarios/999')
            ->assertStatus(404)
            ->assertSee('Página no encontrada');
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
