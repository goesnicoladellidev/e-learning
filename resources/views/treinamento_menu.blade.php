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

@if($errors->any())
<h4>{{$errors->first()}}</h4>
@endif]

@if (session('msg'))
    <div class="alert alert-success" style="margin-left: 40%">
        {{ session('msg') }}
    </div>
@endif
<body>
    <header id="top">
        <form action="" id="search" class="slide-fwd-left">
            <div class="pesquisa">
                <input type="search" placeholder="Buscar">
                <a href=""><span class="fa fa-user fa-lg"></span></a>
                <a href=""><span class="fa fa-sign-out fa-lg"></span></a>
            </div>
        </form>
    </header>



    <ul class="box">

        <li class="box-item item-1" style=" margin-left: 15%">
            <p class="xp">{{$valor_exp}} XP</p><br>
            <p class="txt" id="exp">Experiência</p>
            <p class="icon"><span class="fa fa-signal fa-2x"></span></p>
        </li>
        <li class="box-item item-2">
            <p class="xp" id="curso">{{$check_cursos_concluidos}} Concluídos</p><br>
            <p class="txt" id="cursos">Cursos</p>
            <p class="icon"><span class="fa fa-book fa-2x"></span></p>
        </li>
        <li class="box-item item-3">
            <p class="xp">{{$pontos_quiz}} pts</p><br>
            <p class="txt" id="quiz">Quiz</p>
            <p class="icon"><span class="fa fa-pie-chart fa-2x"></span></p>
        </li>
    </ul>

    <div class="table-container"  style=" margin-left: 22%">

        <li class="box-item item-2" style=" margin-left: 38%">
            <p class="xp" id="curso"><font color="white">{{$patente_check}}</font></p><br>
            <p class="txt" id="cursos"><font color="white">Nivel </font></p>
            <p class="icon"><font color="white"><span class="fa fa-trophy fa-2x"></font></span></p>
        </li>
        </br>
        <div class="btn-group" style="width:100%;">
            </br>
            <button style="width:100%" id="btn-rkg"><a>Ranking Geral</a></button>
           <!--  <button style="width:33.3%" id="btn-rkg"><a>Ranking Semanal</a></button>
            <button style="width:33.3%" id="btn-rkg"><a>Ranking Mensal</a></button> -->
        </div>
        <table> 
            <thead>
                <tr>
                    <th>Avatar</th>
                    <th>Posição</th>
                    <th>Nome</th>
                    <th>Patente / Pontuação</th>
                </tr>
            </thead>
            @foreach($check_user as $key=>$check_user)
            <tbody>
                <tr>
                    <td><img src="/Elearning_layout/img/avatar.png" alt="" class="avatar"></td>
                    <td>{{$key+1}}º lugar</td>
                    <td>{{$check_user->name_user}}</td>
                    <td><strong>{{$check_user->nivel}} :</strong> {{$check_user->points_user}} pts</td>
                </tr>
                  @endforeach
           </table>
            <br><br><br> <br>
    </div>
  

    <div class="container">
       

        <nav>

            

                <li>
                    <label for="drop-ranking">
                        <span class="mif-chart-bars mif-3x principais"></span>
                        Ranking
                        <span class="mif-chevron-right mif-2x direita"></span>
                        <span class="mif-expand-more mif-2x direita"></span>
                    </label>

                    <input type="checkbox" id="drop-ranking">

                    <ul>
                        <li><a href="#">Medalhas (Pontuações)</a></li>
                        <li><a href="#">Premiações</a></li>
                    </ul>
                </li>

                <li>
                    <label for="drop-jornada">
                        <span class="mif-medal mif-3x principais"></span>Minha Jornada
                        <span class="mif-chevron-right mif-2x direita"></span>
                        <span class="mif-expand-more mif-2x direita"></span>
                    </label>

                    <input type="checkbox" id="drop-jornada">

                    <ul>
                        <li><a href="#">Fases Concluídas</a></li>
                        <li><a href="#">Medalhas</a></li>
                        <li><a href="#">Pontuações / XP</a></li>
                        <li><a href="#">Certificados</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
 

    <div class="corpo">

    </div>

    <!--     <div class="footer">
        <p><span class="mif-copyright mif-1g"></span> 2019 Góes & Nicoladelli Advogados Associados</p>
    </div> -->
@yield('principal_menu')
    <script src="/Elearning_layout/js/main.js"></script>


</body>


</html>