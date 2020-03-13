<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeUserController extends Controller
{
    public function nonickname($name)
    {
        $name = ucfirst($name);
    

        return "Bienvenido {$name}";
    }
    

    public function welcome($name, $nickname)
    {
        $name = ucfirst($name);

        return "Bienvenido {$name}, tu apodo es {$nickname}";
    }
}
