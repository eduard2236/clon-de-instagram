@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-10">
            @include('includes.mensaje')

            <div class="card pub_image pub_image_detail">
                <div class="card-header">
                    <a href="{{route('perfil', ['id'=> $image->user->id])}}">
                        @if($image->user->image)
                        <div class="container-avatar">
                            <img src="{{ route('user.avatar',['filename'=>$image->user->image]) }}" alt="" class="avatar">
                        </div>
                        @endif

                        <div class="data-user">
                            {{ $image->user->name.' '.$image->user->surname}}
                            <span class="nickname">
                                {{ ' | @'.$image->user->nick }}
                            </span>
                        </div>
                    </a>
                </div>

                <div class="card-body">
                    <div class="image-container image-detail">
                        <img src="{{ route('image.file', ['filename'=> $image->image_path])}}" alt="">
                    </div>

                    <div class="description">
                        <span class="nickname">{{'@'.$image->user->nick}}</span>
                        <span class="nickname date">{{' | '.\FormatTime::LongTimeFilter($image->created_at)}}</span>
                        <p>{{$image->description}}</p>
                    </div>
                    <div class="likes">

                        <!-- comprobar si el usuario es el mismo que le ha dado like a la publicacion -->
                        <?php $user_like = false; ?>
                        @foreach($image->likes as $like)


                        @if($like->user->id == Auth::user()->id)
                        <?php $user_like = true; ?>
                        @endif
                        @endforeach
                        @if($user_like)
                        <img src="{{asset('iconos/corazon-rojo.png')}}" alt="" data-id="{{$image->id}}" class="btn-dislike">
                        @else
                        <img src="{{asset('iconos/corazon-negro.png')}}" alt="" data-id="{{$image->id}}" class="btn-like">
                        @endif
                        <span class="number_likes">{{count($image->likes)}}</span>
                    </div>
                    @if(Auth::user() && Auth::user()->id == $image->user->id)
                    <div class="actions">
                        <!-- <a href="{{route('image.delete',['id'=>$image->id])}}" class="btn btn-sm btn-warning">actualizar</a> -->
                        <a href="{{route('image.edit',['id'=> $image->id])}}" class="btn btn-sm btn-info">Actualizar</a>
                        <!-- Button to Open the Modal -->
                        <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#myModal">
                            Borrar
                        </button>

                        <!-- The Modal -->
                        <div class="modal" id="myModal">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Estas seguro de borrar la imagen</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        
                                    </div>

                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        Si borra esta imagen no se podra recuperar
                                    </div>

                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-success" data-dismiss="modal">Close</button>
                                        <a href="{{route('image.delete',['id'=>$image->id])}}" class="btn btn-sm btn-danger">Borrar</a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="clearfix"></div>
                    <div class="comments">
                        <h2> Comentarios {{count($image->comments)}}</h2>
                        <hr>
                        <form action="{{route('comment.save')}}" method="post">
                            @csrf
                            <input type="hidden" name="image_id" value="{{ $image->id}}">
                            <p>
                                <textarea name="content" class="form-control  @error('content') is-invalid @enderror"></textarea>
                                @error('content')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </p>
                            <button type="submit" class="btn btn-success">
                                Enviar
                            </button>
                        </form>
                        <hr>
                        @foreach($image->comments as $comment)
                        <div class="comment grid">
                            <div>
                                <span class="nickname">{{'@'.$comment->user->nick}}</span>
                                <span class="nickname date">{{' | '.\FormatTime::LongTimeFilter($comment->created_at)}}</span>
                                <p>{{$comment->content}}</p>
                            </div>
                            <div>
                                @if(Auth::check() && ($comment->user_id == Auth::user()->id || $comment->image->user_id == Auth::user()->id))
                                <a href="{{route('comment.delete', ['id' => $comment->id])}}" class="btn btn-sm btn-danger elimina">
                                    Eliminar
                                </a>
                                @endif
                            </div>

                        </div>
                        @endforeach
                    </div>

                </div>
            </div>
            <!-- paginacion -->
            <div class="clearfix"></div>

        </div>

    </div>
</div>
@endsection