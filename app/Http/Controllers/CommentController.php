<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Comment;

class CommentController extends Controller
{
    //restringe el aceso solo a usuarios identificados
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function save(Request $request){
        //validacion del lo que llega por el formulario detail

        $validate = $this->validate($request,[
                'image_id' => 'integer|required',
                'content' => 'string|required'
        ]);

        //recoge los datos que llega deñ formulario detail
        $user = Auth::user();
        $image_id = $request->input('image_id');
        $content = $request->input('content');

        //isntancia la clase del modelo comment y guarda los datos adquiridos del formulario detail
        $comment= new Comment();
        $comment->user_id = $user->id;
        $comment->image_id = $image_id;
        $comment->content = $content;
        //guarda los datos atraves del metodo save de laravel
        $comment->save();

        return redirect()->route('image.detail',[ 'id' => $image_id])
                        ->with(['message'=> 'Has publicado tu comentario correctamente!!']);
    }
    public function delete($id){
        //conseguir los datos del usuario logueado
        $user = Auth::user();
        //conseguir objeto del comentario
        $comment = Comment::find($id);

        //comprobar si soy el dueño del comentario
        if($user && ($comment->user_id == $user->id || $comment->image->user_id == $user->id)){
                $comment->delete();
            
                return redirect()->route('image.detail',[ 'id' => $comment->image->id])
                        ->with(['message'=> 'El comentario ha sido eliminado correctamente!!']);
        }else{
            return redirect()->route('image.detail',[ 'id' => $comment->image->id])
                        ->with(['message'=> 'El comentario NO SE HA ELIMINADO !!']);
        }
    }
}
