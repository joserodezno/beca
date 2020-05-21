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

        $this->get("/usuarios/{$user->id}")
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
       ->assertSee('Crear usuario');
    }

    /** @test */
    function create_new_user()
    {
        $this->withoutExceptionHandling();

        $this->post('/usuarios/', [
            'name' => 'Jose Rodezno',
            'email' => 'joserodezno99@gmail.com',
            'password' => 'prueba'
        ])->assertRedirect('usuarios');

        $this->assertCredentials([
            'name' => 'Jose Rodezno',
            'email' => 'joserodezno99@gmail.com',
            'password' => 'prueba'
        ]);
    }

    /** @test*/
    function page_not_found()
    {
        $this->get('/usuarios/texto/edit')
        ->assertStatus(404);        
    }

    /** @test */
    function name_required()
    {
       

        $this->from('usuarios/nuevo')
        ->post('/usuarios/', [
            'name' => '',
            'email' => 'joserodezno99@gmail.com',
            'password' => 'prueba'
        ])
        ->assertRedirect('usuarios/nuevo')
        ->assertSessionHasErrors(['name' => 'El campo nombre es obligatorio']);

        $this->assertEquals(0, User::count());
    }

    /** @test */
    function email_required()
    {
       

        $this->from('usuarios/nuevo')
        ->post('/usuarios/', [
            'name' => 'Jose Rodezno',
            'email' => '',
            'password' => 'prueba'
        ])
        ->assertRedirect('usuarios/nuevo')
        ->assertSessionHasErrors(['email']);

        $this->assertEquals(0, User::count());
    }

    /** @test */
    function email_must_be_valid()
    {
       

        $this->from('usuarios/nuevo')
        ->post('/usuarios/', [
            'name' => 'Jose Rodezno',
            'email' => 'correo-no-valido',
            'password' => 'prueba'
        ])
        ->assertRedirect('usuarios/nuevo')
        ->assertSessionHasErrors(['email']);

        $this->assertEquals(0, User::count());
    }

    /** @test */
    function email_must_be_unique()
    {
        factory(User::class)->create([
            'email' => 'joserodezno99@gmail.com'
        ]);

        $this->from('usuarios/nuevo')
        ->post('/usuarios/', [
            'name' => 'Jose Rodezno',
            'email' => 'joserodezno99@gmail.com',
            'password' => 'prueba'
        ])
        ->assertRedirect('usuarios/nuevo')
        ->assertSessionHasErrors(['email']);

        $this->assertEquals(1, User::count());
    }

    /** @test */
    function password_required()
    {
       

        $this->from('usuarios/nuevo')
        ->post('/usuarios/', [
            'name' => 'Jose Rodezno',
            'email' => 'joserodezno99@gmail.com',
            'password' => ''
        ])
        ->assertRedirect('usuarios/nuevo')
        ->assertSessionHasErrors(['password']);

        $this->assertEquals(0, User::count());
    }

    /** @test*/
    function loads_edit_user_page()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();

        $this->get("/usuarios/{$user->id}/editar")
            ->assertStatus(200)
            ->assertViewIs('users.edit')
            ->assertSee('Editar usuario')
            ->assertViewHas('user', function ($viewUser) use ($user){
                return $viewUser->id === $user->id;
            });
    }

    /** @test*/
    function update_user()
    {
        $user = factory(User::class)->create();

        $this->withoutExceptionHandling();

        $this->put("/usuarios/{$user->id}", [
            'name' => 'Jose Rodezno',
            'email' => 'joserodezno99@gmail.com',
            'password' => 'prueba'
        ])->assertRedirect("/usuarios/{$user->id}");

        $this->assertCredentials([
            'name' => 'Jose Rodezno',
            'email' => 'joserodezno99@gmail.com',
            'password' => 'prueba'
        ]);
    } 

    /** @test*/
    function name_required_when_updating_user()
    {

       $user = factory(User::class)->create();

        $this->from("usuarios/{$user->id}/editar")
            ->put("/usuarios/{$user->id}", [
                'name' => '',
                'email' => 'joserodezno99@gmail.com',
                'password' => 'prueba'
        ])
        ->assertRedirect("usuarios/{$user->id}/editar")
        ->assertSessionHasErrors(['name']);

        $this->assertDatabaseMissing('users', ['email' => 'joserodezno99@gmail.com']);
    }

    /** @test*/
    function email_must_be_valid_when_updating_user()
    {
       
        $user = factory(User::class)->create();

        $this->from("usuarios/{$user->id}/editar")
            ->put("/usuarios/{$user->id}", [
                'name' => 'Jose Rodezno',
                'email' => 'correo-no-valido',
                'password' => 'prueba'
        ])
        ->assertRedirect("usuarios/{$user->id}/editar")
        ->assertSessionHasErrors(['email']);

        $this->assertDatabaseMissing('users', ['name' => 'Jose Rodezno']);
    }

    /** @test */
    function email_must_be_unique_when_updating_user()
    {
        self::markTestIncomplete();
        return;

        $user = factory(User::class)->create([
            'email' => 'joserodezno99@gmail.com'
        ]);

        $this->from("usuarios/{$user->id}/editar")
        ->put("usuarios/{$user->id}", [
            'name' => 'Jose Rodezno',
            'email' => 'joserodezno99@gmail.com',
            'password' => 'prueba'
        ])
        ->assertRedirect('usuarios/nuevo')
        ->assertSessionHasErrors(['email']);

        $this->assertEquals(1, User::count());
    }

    /** @test */
    function email_remain_same_when_updating_user()
    {

       $user = factory(User::class)->create([
           'email' => 'joserodezno99@gmail.com'
       ]);

        $this->from("usuarios/{$user->id}/editar")
            ->put("usuarios/{$user->id}", [
                'name' => 'Rodezno',
                'email' => 'joserodezno99@gmail.com',
                'password' => 'prueba'
        ])
        ->assertRedirect("usuarios/{$user->id}");

        $this->assertDatabaseHas('users', [
            'name' => 'Rodezno',
            'email' => 'joserodezno99@gmail.com',
            ]); 
    }

    /** @test */
    function password_optional_when_updating_user()
    {
        $oldPassword = 'CLAVE_ANTERIOR';
       $user = factory(User::class)->create([
           'password' => bcrypt($oldPassword)
       ]);

        $this->from("usuarios/{$user->id}/editar")
        ->put("usuarios/{$user->id}", [
            'name' => 'Jose Rodezno',
            'email' => 'joserodezno99@gmail.com',
            'password' => ''
        ])
        ->assertRedirect("usuarios/{$user->id}");

        $this->assertCredentials([
            'name' => 'Jose Rodezno',
            'email' => 'joserodezno99@gmail.com',
            'password' => $oldPassword
            ]); 
    }

}
