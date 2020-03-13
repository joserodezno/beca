<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class WelcomeUsersTest extends TestCase
{
    /** @test */

    function welcome_user_nickname()
    {
        $this->get('saludo/jose/nickname')
        ->assertStatus(200)
        ->assertSee('Bienvenido Jose, tu apodo es nickname');
    }

    /** @test */

    function welcome_user_without_nickname()
    {
        $this->get('saludo/jose')
        ->assertStatus(200)
        ->assertSee('Bienvenido Jose');
    }
    
}
