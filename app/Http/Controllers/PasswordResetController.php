<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetMail;
use App\Models\Usuario;

class PasswordResetController extends Controller
{
    public function sendPasswordResetLink(Request $request) {
    	$email = $request->input('email');
    	$user = Usuario::where('Email', $email)->first();

    	if($user){
    		//Contraseña temporal
    		$tempPassword = Str::random(10);

    		// Actualizar contraseña temporal en la BD
    		$user->update([
    			'Password' => $tempPassword,
    		]);

    		//Se envia un correo al email del usuario con la contraseña temporal
    		Mail::to($user->Email)->send(new PasswordResetMail($tempPassword));

    		return redirect()->route('login.form')->with('success', 'Se ha enviado una contraseña temporal a tu correo electrónico.');
    	} else {
    		return back()->with('error', 'No se encontró ningún usuario con ese correo electrónico.');
    	}
    }
}
