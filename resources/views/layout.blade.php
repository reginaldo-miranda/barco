<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>MyShop - Ecomerce</title>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" referrerpolicy="no-referrer" />
       <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
       @yield("scriptjs")
    </head>
    <body>
      <nav class="navbar navbar-light navbar-expand-md bg-light pl-5 pr-5 mb-5">
        <a hert="#" class="navbar-brand">MyShop</a>
        <div class="collapse navbar-collapse">
            <div class="navbar-nav">
                <a class="nav-link" href="{{ route('home')}}">Home</a>
                <a class="nav-link" href="{{ route('categoria')}}">Categoria</a>
                <a class="nav-link" href="{{ route('cadastrar')}}">Cadastrar</a>   
                <a class="nav-link" href="{{ route('logar')}}">Logar</a>   
            </div>
        </div>
        <a href="{{ route('ver_carrinho')}}" class="btn btn-sm"><i class="fa fa-shopping-cart"></i></a>
      </nav> 
      <div class="container">
          <div class="row">
            
            @if(\Auth::user())
               <div class="col-12">
                   <p class="text-right">Seja bem vindo, {{ \Auth::user()->nome}} </p>
               </div>
            @endif
            

             @if($message = Session::get("err"))
                <div class="col-12">
                   <div class="alert alert-danger">{{ $message}}</div>
               </div>
             @endif 

             @if($message = Session::get("ok"))
                <div class="col-12">
                   <div class="alert alert-success">{{ $message}}</div>
                </div>   
             @endif 

            @yield("conteudo")
          </div>         
      </div>

    </body>
</html>
