<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;

class EmailConfirmationController extends Controller
{
    public function confirmarEmail($token)
    {
        $usuario = Usuario::where('Token', $token)->first();

        if ($usuario) {
            $usuario->update(['Email_verified' => true]);
            $usuario->update(['Token' => null]);
        }
    }
}
