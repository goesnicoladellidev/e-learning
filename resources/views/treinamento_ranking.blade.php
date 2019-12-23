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
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
</head>
<body>
    <header id="top">
        <form action="/rota_ranking/receber_premio" id="search" method="get" class="slide-fwd-left">
            <div class="pesquisa">
                <input type="search" placeholder="Buscar">
                <a href=""><span class="fa fa-user fa-lg"></span></a>
                <a href=""><span class="fa fa-sign-out fa-lg"></span></a>
            </div>
    </header>
    <ul class="box">
        <div style="margin-right: 36%">
        <h1 style="margin-left: 76%"> <font color="black"> PREMIAÇÕES:</font></h1>
        <br><br>
            <li class="box-item item-1" style=" margin-left: 77%">
            <p class="xp">{{$premios}}</p><br>
           <p class="txt" id="quiz">CONCLUÍDOS </p>
        </li>
 <br><br>
        </div>
        @if($pontuacao_total >= 400 )
        <li class="box-item item-1" style=" margin-left: 15%">
            <p class="xp">400 pts</p><br>
           <p class="txt" id="quiz">Recompensa: 1x Bombom  </p>
            <p class="icon" style=" margin-left: 50%; margin-top: -20%">Latão<span class="fa fa-trophy fa-2x"></span></p>
            <button class='fas fa-check-circle' style='font-size:48px;margin-left:80%;color:green'  name="btn_premio_1" value="1"><img src=""></button>
        </li>
        @else
        <li class="box-item item-1" style=" margin-left: 15%">
            <p class="xp">400 pts</p><br>
           <p class="txt" id="quiz">Recompensa: 1x Bombom  </p>
            <p class="icon" style=" margin-left: 50%; margin-top: -20%">Latão<span class="fa fa-trophy fa-2x"></span></p>
             <button class='fas fa-check-circle' style='font-size:48px;margin-left:80%;color:grey'  name="btn_premio_1" value="0"><a href=""></a></button>
        </li>
        @endif
        @if($pontuacao_total >= 800 )
        <li class="box-item item-2">
            <p class="xp" id="curso">800 pts</p><br>
           <p class="txt" id="quiz">Recompensa: 2x Bombom  </p>
            <p class="icon" style=" margin-left: 50%; margin-top: -20%">Bronze<span class="fa fa-trophy fa-2x"></span></p>
              <button class='fas fa-check-circle' style='font-size:48px;margin-left:80%;color:green'  name="btn_premio_2" value="1"></button>
        </li>
        @else
        <li class="box-item item-2">
            <p class="xp" id="curso">800 pts</p><br>
           <p class="txt" id="quiz">Recompensa: 2x Bombom  </p>
            <p class="icon" style=" margin-left: 50%; margin-top: -20%">Bronze<span class="fa fa-trophy fa-2x"></span></p>
              <button class='fas fa-check-circle' style='font-size:48px;margin-left:80%;color:grey' name="btn_premio_2" value="0"></button>
        </li>
        @endif
        @if($pontuacao_total >= 1200 )
        <li class="box-item item-3">
            <p class="xp">1200 pts</p><br>
           <p class="txt" id="quiz">Recompensa: Caneta GN  </p>
            <p class="icon" style=" margin-left: 50%; margin-top: -20%">Prata<span class="fa fa-trophy fa-2x"></span></p>
             <button class='fas fa-check-circle' style='font-size:48px;margin-left:80%;color:green' name="btn_premio_3" value="1" ></button>
        </li>
        @else
         <li class="box-item item-3">
            <p class="xp">1200 pts</p><br>
           <p class="txt" id="quiz">Recompensa: Caneta GN  </p>
            <p class="icon" style=" margin-left: 50%; margin-top: -20%">Prata<span class="fa fa-trophy fa-2x"></span></p>
              <button class='fas fa-check-circle' style='font-size:48px;margin-left:80%;color:grey' name="btn_premio_3" value="0"></button>
        </li>
        @endif
    </ul>
     <ul class="box">
         @if($pontuacao_total >= 1600 )
        <li class="box-item item-1" style=" margin-left: 15%">
            <p class="xp"> 1600 pts</p><br>
            <p class="txt" id="quiz">Recompensa: Caneta e Agenda GN  </p>
            <p class="icon" style=" margin-left: 50%; margin-top: -20%">Ouro<span class="fa fa-trophy fa-2x"></span></p>
             <button class='fas fa-check-circle' style='font-size:48px;margin-left:80%;color:green' name="btn_premio_4" value="1"></button>
        </li>
        @else
        <li class="box-item item-1" style=" margin-left: 15%">
            <p class="xp"> 1600 pts</p><br>
            <p class="txt" id="quiz">Recompensa: Caneta e Agenda GN  </p>
            <p class="icon" style=" margin-left: 50%; margin-top: -20%">Ouro<span class="fa fa-trophy fa-2x"></span></p>
              <button class='fas fa-check-circle' style='font-size:48px;margin-left:80%;color:grey' name="btn_premio_4" value="0"></button>
        </li>
        @endif
         @if($pontuacao_total >= 1800)
        <li class="box-item item-2">
            <p class="xp" id="curso"> 1800 pts</p><br>
           <p class="txt" id="quiz">Recompensa: Almoço GN  </p>
            <p class="icon" style=" margin-left: 50%; margin-top: -20%">Rubi<span class="fa fa-trophy fa-2x"></span></p>
             <button class='fas fa-check-circle' style='font-size:48px;margin-left:80%;color:green' name="btn_premio_5" value="1"></button>
        </li>
        @else
        <li class="box-item item-2">
            <p class="xp" id="curso"> 1800 pts</p><br>
           <p class="txt" id="quiz">Recompensa: Almoço GN  </p>
            <p class="icon" style=" margin-left: 50%; margin-top: -20%">Rubi<span class="fa fa-trophy fa-2x"></span></p>
              <button class='fas fa-check-circle' style='font-size:48px;margin-left:80%;color:grey' name="btn_premio_5" value="0"></button>
        </li>
        @endif
         @if($pontuacao_total >= 2000)
        <li class="box-item item-3">
            <p class="xp"> 2000 pts</p><br>
            <p class="txt" id="quiz">Recompensa: Cruzeiro Tudo Pago GN  </p>
            <p class="icon" style=" margin-left: 50%; margin-top: -20%">Diamante<span class="fa fa-trophy fa-2x"></span></p>
               <button class='fas fa-check-circle' style='font-size:48px;margin-left:80%;color:green' name="btn_premio_6" value="1"></button>
        </li>
        @else
         <li class="box-item item-3">
            <p class="xp"> 2000 pts</p><br>
            <p class="txt" id="quiz">Recompensa: Cruzeiro Tudo Pago GN  </p>
            <p class="icon" style=" margin-left: 50%; margin-top: -20%">Diamante<span class="fa fa-trophy fa-2x"></span></p>
               <button class='fas fa-check-circle' style='font-size:48px;margin-left:80%;color:grey' name="btn_premio_6" value="0"></button>
        </li>
        @endif
    </ul>
     <ul class="box">
    </ul>
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
</form>
    <!--     <div class="footer">
        <p><span class="mif-copyright mif-1g"></span> 2019 Góes & Nicoladelli Advogados Associados</p>
    </div> -->
@yield('principal_menu')
    <script src="/Elearning_layout/js/main.js"></script>
 </body>
</html>