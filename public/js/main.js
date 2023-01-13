var url= 'http://proyecto-laravel.test';

window.addEventListener("load", function(){
    //boton de like
    function like(){
        $('.btn-like').unbind('click').click(function(){
            console.log('like');
            $(this).addClass('btn-dislike').removeClass('btn-like');
            $(this).attr('src',url+'/iconos/corazon-rojo.png');
            
            $.ajax({
                url: url+'/like/'+$(this).data('id'),
                type: 'GET',
                success: function(response){
                    if(response.like){
                        console.log('Has dado like a la publicacion');
                    }else{
                        console.log('Error al dar like a la publicacion');
                    }
                    
                }
            });
            dislike();
        });
    }
    like();
    

    //boton de dislike
    function dislike(){
        $('.btn-dislike').unbind('click').click(function(){
            console.log('dislike');
            $(this).addClass('btn-like').removeClass('btn-dislike');
            $(this).attr('src',url+'/iconos/corazon-negro.png');
            $.ajax({
                url: url+'/dislike/'+$(this).data('id'),
                type: 'GET',
                success: function(response){
                    if(response.like){
                        console.log('Has dado dislike a la publicacion');
                    }else{
                        console.log('Error al dar dislike a la publicacion');
                    }
                    
                }
            });
            like();
        });
    }
    dislike();

    //buscador
    $('#buscador').submit(function(){
       
            $(this).attr('action',url+'/personas/'+$('#buscador #search').val());
    });
    

});