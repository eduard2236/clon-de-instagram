@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('includes.mensaje')
            @foreach($images as $image)
            <div class="card pub_image">
                <div class="card-header">
                    @if($image->user->image)
                    <div class="container-avatar">
                        <img src="{{ route('user.avatar',['filename'=>$image->user->image]) }}" alt="" class="avatar">
                    </div>
                    @endif

                    <div class="data-user">
                        <a href="{{route('image.detail', ['id'=> $image->id])}}">
                        {{ $image->user->name.' '.$image->user->surname}}
                        <span class="nickname">
                            {{ ' | @'.$image->user->nick }}
                        </span>
                        </a>
                    </div>

                </div>

                <div class="card-body">
                    <div class="image-container">
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
                        <img src="{{asset('iconos/corazon-rojo.png')}}" alt="" class="btn-dislike">
                        @else
                        <img src="{{asset('iconos/corazon-negro.png')}}" alt="" class="btn-like">
                        @endif
                        <span class="number_likes">{{count($image->likes)}}</span> 
                    </div>
                    <div class="comments">
                    <a href="" class="btn btn-sm btn-warning btn-comments">
                        Comentarios {{count($image->comments)}}
                    </a>
                    </div>
                   
                </div>
            </div>
            @endforeach
            <!-- paginacion -->
            <div class="clearfix"></div>
            {{$images->links()}}

        </div>

    </div>
</div>
@endsection