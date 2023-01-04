<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function config(){
        return view('user.config');
    }


    public function update(Request $request){
        /* conseguir los datos del usuario */
        $user = \Auth::user();
        $id = $user->id;

        /* validar los datos del usuario */
        $validate = $this->validate($request,[
            
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'nick' => 'required|string|max:255|unique:users,nick,'.$id,
            'email' => 'required|string|email|max:255|unique:users,email,'.$id
        ]);

        /* recoger los datos del formulario */
        $name = $request->input('name');
        $surname = $request->input('surname');
        $nick = $request->input('nick');
        $email = $request->input('email');

        /* asignar nuevos valores al objeto del usuario */
        $user->name= $name;
        $user->surname= $surname;
        $user->nick= $nick;
        $user->email= $email;

        /* ejecutar la consulta en la base de datos */
        return redirect()->route('config')
                         ->with(['message'=>'Usuario actualizado correctamente']);
    }
}
