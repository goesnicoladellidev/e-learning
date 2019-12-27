@extends('menu_principal')
@extends('upload')
@section('header')
@endsection

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GN Treinamento</title>
    <link rel="stylesheet" href="/Elearning_layout/font-awesome-4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdn.rawgit.com/olton/Metro-UI-CSS/master/build/css/metro-icons.min.css">
    <link rel="stylesheet" type="text/css" href="/Elearning_layout/css/estilo.css" >
    <link rel="stylesheet" type="text/css" href="/Elearning_layout/css/boxes2.css">
    <link rel="shortcut icon" href="/Elearning_layout/img/student_icon.jpg"  type="image/x-icon" >
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
</head>
<body>
    <header id="top">
       <!--  <form action="" id="search" class="slide-fwd-left"> -->
            <div class="pesquisa">
                <input type="search" placeholder="Buscar">
                <a href=""><span class="fa fa-user fa-lg"></span></a>
                <a href=""><span class="fa fa-sign-out fa-lg"></span></a>
            </div>
    </header>
<br>
<div class="container-fluid">
        <div class="col-md-4">
  
            <div class="container-fluid" style="margin-left: 23%; margin-right: 20% ">

        <div class="form-group">

            <div class="clearfix">

                <table class="table table-striped table-responsive table-bordered" style="width:50% margin-left 20%">
                    <thead>
                        <tr style="width:100%">
                            <th style="width:50%">Upload de Videos </th>

                        </tr>
                    </thead>
                <tbody>

                        <!-- QUESTÃO 1 -->

                        <tr>
                         <td style="text-align: left;" colspan="2">
                                <strong>  Selecione um Arquivo no formato: mp4  </strong>
                            </td>
                        </tr>
                        @section('content')
<div class="row" style="margin-left: 180%; margin-top: 110%">
    <div class="">
    <h2>Upload</h2>
    @if ($errors->any())
    <div class="alert alert-danger" >
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    @if(Session('mensagem'))
    <div class="alert alert-info">
        {{Session('mensagem')}}
    </div>
    @endif
        <form action="{{route('upload')}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="form-group">
                <label for="arquivo">Arquivo:</label>
                <input type="file" name="arquivo" id="arquivo" class="form-control">
            </div>
            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <input type="text" name="descricao" id="descricao" class="form-control">
            </div>
            <button type="submit" class="btn btn-sm btn-priamry">Enviar</button>
        </form>
    </div>
</div>
@endsection

                        </div>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
  <br>

      </div>
    <br><br>
@yield('principal_menu')
    </form>
    <script src="/Elearning_layout/js/main.js"></script>
 </body>
</html>
<script>
    var i = 0;
    function buttonClick() {
        document.getElementById('button').value = ++i;
    }
</script>
<script type="text/javascript">
</script>
@section('scripts')
@endsection