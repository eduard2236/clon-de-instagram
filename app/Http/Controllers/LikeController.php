<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\like;

class LikeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function like($image_id)
    {
        //recoger datos del usuario
        $user = Auth::user();

        //condicion para ver si existe el like y no duplicarlo

        $isset_like = Like::where('user_id', $user->id)
            ->where('image_id', $image_id)
            ->count();
            

        if ($isset_like == 0) {
            $like = new like();
            $like->user_id = $user->id;

            //castear el tipo de dato que llega como un string a integer
            $like->image_id = (int)$image_id;

            //guarda los datos en la base de datos
            $like->save();
            return response()->json([
                'like' => $like
            ]);
        } else {
            return response()->json([
                'message' => 'ya le has dado like'
            ]);
        }
    }
    public function dislike($image_id)
    {
    }
}
