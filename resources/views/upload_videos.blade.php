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
                                <strong>  Selecione uma opção de anexo:  </strong>
                            </td>
                        </tr>
                        @section('content')
<div class="row" style="margin-left: 180%; margin-top: 110%">



    <div class="" style="width: 500px; height: 100px;">
    <h2>Anexar Arquivos / URL :</h2>
    <br>
    <button onclick="myFunction()" style="width:80px;height:60px;">Anexar Video/URL</button>
    <br><br>
    <button onclick="myFunction2()" style="width:80px;height:60px;" >Anexar Arquivo</button>
    <br><br>
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
    <div class="alert alert-info" style="width: 500px; height: 500px">
        {{Session('mensagem')}}
    </div>
    @endif
        <form action="{{route('upload', ['id_setor'=>$id_setor, 'id_carteira'=>$id_carteira,'id_modulo'=>$id_modulo]) }}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="form-group" style="display: none" id="video">
                <label for="arquivo">Arquivo:</label>
                <input type="file" name="arquivo" id="arquivo" class="form-control" >
            </div>
            <br>
            <div class="form-group" style="display: none" id="url">
                <label for="arquivo">Url Video:</label>
                <input type="text" name="url" id="url" class="form-control">
            </div>
            <br>
            <div class="form-group" style="display: none;" id="desc">
                <label for="descricao">Descrição:</label>
                <input type="text" name="descricao" id="descricao" class="form-control">
                <br><br>
            <button type="submit" class="btn btn-sm btn-primary">Enviar</button>
            </div>
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

<script>
function myFunction2() {

  var x = document.getElementById("video");
  var y = document.getElementById("url");
  var z = document.getElementById("desc");

  if (x.style.display === "none") {
    x.style.display = "block";
    z.style.display = "block";
    y.style.display = "none";
   $('#url :input').attr('disabled', true);
   $('#video :input').attr('disabled', false);
  } 
}
</script>
<script>
function myFunction() {
  var x = document.getElementById("url");
  var y = document.getElementById("video");
  var z = document.getElementById("desc");

  if (x.style.display === "none") {
    x.style.display = "block";
    z.style.display = "block";
    y.style.display = "none";
    $('#video :input').attr('disabled', true);
    $('#url :input').attr('disabled', false);
  } 
}
</script>
@section('scripts')
@endsection