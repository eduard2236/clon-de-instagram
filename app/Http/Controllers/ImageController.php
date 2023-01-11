<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Http\Response;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Auth;

use App\Image;

use App\Comment;

use App\like;

class ImageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(){
        return view('image.create');
    }
    public function save(Request $request){
        //validacion
        $validate = $this->validate($request,[
            'description' =>'required',
            'image_path'  => 'required|image',
        ]);
        //recoge los datos
        $image_path= $request->file('image_path');
        $description=$request->input('description');

        //asignar valores nuevo objeto

        $user = Auth::user();

        $image = new Image();
        $image->user_id = $user->id;
        $image->description = $description;

        //subir fihero
        if($image_path){
            $image_path_name = time(). $image_path->getClientOriginalName();
            Storage::disk('images')->put($image_path_name, File::get($image_path));
            $image->image_path = $image_path_name;

        }
        //guardar en la base de datos
        $image->save();
        //redirecciona al home con un mensaje
        return redirect()->route('home')->with([
            'message' => 'la foto a sido subida correctamente !!'
        ]);
    }
    public function getImage($filename){
        $file = Storage::disk('images')->get($filename);
        return new Response($file, 200);   
    }
    public function detail($id){
        $image = Image::find($id);
        return view('image.detail',[
            'image' => $image
        ]);
    }
    //borra imagen del usuario identificado
    public function delete($id){
        $user = Auth::user();
        $image = Image::find($id);
        $comments = Comment::where('image_id',$id)->get();
        $likes = like::where('image_id', $id)->get();
        if($user && $image && $image->user->id == $user->id){

            //Eliminar comentarios
                if($comments && count($comments) >= 1){
                    foreach($comments as $comment){
                        $comment->delete();
                    }
                }
            //Eliminar los likes
            if($likes && count($likes) >= 1){
                foreach($likes as $like){
                    $like->delete();
                }
            }
            //Eliminar Ficheros de imagen en storage
            Storage::disk('images')->delete($image->image_path);
            //Eliminar registros de imagen
            $image->delete();

            $message = array('message' => 'La imagen se ha borrado correctamente.');
        }else{
            $message = array('message' => 'La imagen no se ha borrado.');
        }
        return redirect()->route('home')->with($message);
    }

    public function edit($id){
        $user = Auth::user();
        $image = Image::find($id);
        if($user && $image && $image->user->id == $user->id){
            return view('image.edit',[
                'image'  => $image
            ]);
        }else{
            return redirect()->route('home');
        }
    }

    public function update(Request $request){
         //validacion
         $validate = $this->validate($request,[
            'description' =>'required',
            'image_path'  => 'image',
        ]);
        //recoge los datos de la request
        $image_id = $request->input('image_id');
        $image_path = $request->file('image_path');
        $description = $request->input('description');
        // setea el objeto image
        $image = Image::find($image_id);
        $image->description = $description;
        //subir fihero
        if($image_path){
            $image_path_name = time(). $image_path->getClientOriginalName();
            Storage::disk('images')->put($image_path_name, File::get($image_path));
            $image->image_path = $image_path_name;
    }
     //actualiza en la base de datos
        $image->update();
        return redirect()->route('image.detail', ['id' => $image_id])
                        ->with(['message' => 'Imagen actualizada con exito']);

    }
}
