@extends('menu_principal')
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
         <form method="get" action="{{ url('/cadastra_pergunta', [$id_setor, $id_carteira, $qtd_perguntas]) }}">
       @if ($count_modulos != 0)
        <h1 class="pull-left" style="margin-left: 38%"> Cadastro de Perguntas Quiz </h1>
        <br><br><br><br>
<label class="pull-left" style="margin-left: 25%" >Escolha Modulo .</label>
                <select class="form-control" name="num_modulo" id="num_modulo" required="" >
                    <option value=""> Escolha Módulo</option>
                @for($i=1; $i <= $count_modulos; $i++)
                <option value="{{$i}}"> Modulo {{$i}}</option>
                @endfor
                <option value="{{$i}}"> ADICIONAR MÓDULO -> {{$i}}</option>
                </select>
            <br><br>
        <div>
    @endif
            <div class="container-fluid" style="margin-left: 23%; margin-right: 20% ">

        <div class="form-group">


            <div class="clearfix">


                <table class="table table-striped table-responsive table-bordered" style="width:50% margin-left 20%">
                    <thead>
                        <tr style="width:100%">
                            <th style="width:50%">Cadastrar Questões</th>
                            <th style="width: 50%; ">Opções</th>
                        </tr>
                    </thead>
                    <tbody>

                        <!-- QUESTÃO 1 -->

                        <tr>
                         <td style="text-align: left;" colspan="2">
                                <strong>  Formule uma pergunta e escolha a resposta Verdadeiro ou Falso, nos campos abaixo.  </strong>
                            </td>
                        </tr>
                         @for($i = 0; $i < $qtd_perguntas; $i++)
                        <tr>
                          <td style="margin-right: 2%;"><label class="pull-left" for="titulo_pergunta{{$i+1}}"> Titulo  {{$i+1}}:  </label>
                <input type="text" class="form-control" placeholder="Insira um Titulo."  id="titulo_pergunta{{$i+1}}" name="titulo_pergunta{{$i+1}}" required=""><br><br>
                <label class="pull-left" for="pergunta_quiz_{{$i+1}}" required=""> Pergunta {{$i+1}}:  </label>
                <input type="text" class="form-control" placeholder="Insira uma pergunta."  id="pergunta_quiz_{{$i+1}}" name="pergunta_quiz_{{$i+1}}" required="">
                </td>
                    <td>
                                <p> Selecione a resposta <STRONG>CORRETA</STRONG> :</p><br>
                               <input type="radio" name="respostas_radio{{$i+1}}" value="a" id="respostas_quiz_a_{{$i+1}}" required="" /><input type="text" name="respostas_quiz_a_{{$i+1}}" required=""><br>
                                <input type="radio" name="respostas_radio{{$i+1}}" value="b" id="respostas_quiz_b_{{$i+1}}" required=""/><input type="text" name="respostas_quiz_b_{{$i+1}}" required=""><br>
                                 <input type="radio" name="respostas_radio{{$i+1}}" value="c" id="respostas_quiz_c_{{$i+1}}" required=""/><input type="text" name="respostas_quiz_c_{{$i+1}}"required=""><br>
                                  <input type="radio" name="respostas_radio{{$i+1}}" value="d" id="respostas_quiz_d_{{$i+1}}" required=""/><input type="text" name="respostas_quiz_d_{{$i+1}}" required=""><br>
                              </td>
                            </tr>
                          @endfor
                        </div>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
  <br>
             <div class="col-md-2" name="cadastrar" id="cadastrar" style=" margin-left: 48%; margin-top: 1%" >
                  <button class="btn btn-success"> Cadastrar </button><br><br>
             </div>
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
