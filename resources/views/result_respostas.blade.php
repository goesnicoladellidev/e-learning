@extends('menu_principal')
<!DOCTYPE html>
<html lang="pt-br">

<body>
    <header id="top">
        <form action="" id="search" class="slide-fwd-left">
            <input type="search" placeholder="Buscar">
            <a href="http://elearning.goesnicoladelli.net/home">Usuário <span class="fa fa-user fa-lg"></span></a>
            <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
        </form>
    </header>
    <!-- <section>
    
        <div style=" margin-left: 28%" >
            <iframe src="/Elearning_layout/img/frame_goes.png" id="iframe"></iframe>
        </div>

<div class="panel-group" style=" margin-left: 1%"  >
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title " class="w-25 p-3">
        <a data-toggle="collapse" href="#collapse1">LIÇÃO 01</a><br>
      </h4>
      <br>
      <div id="collapse1" class="panel-collapse collapse"  style=" margin-left: 20%">
      <ul class="list-group">
        <li class="list-group-item"><a href="">1 - Como Negociar de modo correto</a></li>
        <li class="list-group-item"><a href="">2 - Como me Comportar em uma Ligação Gravada</a></li>
        <li class="list-group-item"><a href="">3 - Fechando Negócio da Forma Correta</a></li>
      </ul>
     </div>
  </div>

   <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse2" href="#collapse2">LIÇÃO 01</a><br>
      </h4>
      <br>
      <div id="collapse" class="panel-collapse collapse" style=" margin-left: 20%">
      <ul class="list-group">
        <li class="list-group-item"><a href="">1 - Como Negociar de modo correto</a></li>
        <li class="list-group-item"><a href="">2 - Como me Comportar em uma Ligação Gravada</a></li>
        <li class="list-group-item"><a href="">3 - Fechando Negócio da Forma Correta</a></li>
      </ul>
     </div>
  </div>

  </div>
</div>

   
        
    </section>
 -->

<section>

             <!--      ESSA FUNÇÃO troca frame       -->
            
                <!--  <iframe name="iframe" width="560" height="315" src="/Elearning_layout/modulo_certo/story_html5.html" id="iframe" style=" marker-end: 90" frameborder="0" allowfullscreen></iframe>
 -->
                 <video width="720" height="600" name="ivideo"  id="ivideo" controls="" style="margin-left: 30%">
                 <source src="/Elearning_layout/treinamentos/santander/gestao_judicial.mp4" type="video/mp4">
                Your browser does not support the video tag.
                </video>
          
          
        <div class="tbl-ranking" style="overflow-x:auto; margin-left: 90% margin-top: 20%">

           <div class="panel-group">
  <div class="panel panel-default"> <!--  cria linha que separa os buttons    -->
    <h4 class="panel-title">
        <a data-toggle="collapse"> Modulos - Treinamento Santander</a>
      </h4>
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" href="#collapse1">LIÇÃO 01</a>
      </h4>
    </div>
    <div id="collapse1" class="panel-collapse collapse">
      <ul class="list-group">
        <li class="list-group-item"><a href="/Elearning_layout/modulo_certo/story_html5.html" id="iframe" target="iframe">1 - COMO NEGOCIAR PARTE 1</a></li>
        <li class="list-group-item" ><a href="Elearning_layout//" id="iframe" target="ivideo">2 - COMO NEGOCIAR PARTE 2</a></li>
        <li class="list-group-item">
          <source src="/Elearning_layout/treinamentos/santander/gestao_judicial.mp4" type="video/mp4" target="ivideo">

          <a href="/Elearning_layout/treinamentos/santander/santander_rcb.mp4" target="ivideo">3 - COMO NEGOCIAR PARTE 3</a>
        </li>
      </ul>
    </div>

    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" href="#collapse2">LIÇÃO 02</a>
      </h4>
    </div>
    <div id="collapse2" class="panel-collapse collapse">
      <ul class="list-group">
        <li class="list-group-item"><a href="">1 - COMO NEGOCIAR PARTE 1</a></li>
        <li class="list-group-item"><a href="">2 - COMO NEGOCIAR PARTE 2</a></li>
        <li class="list-group-item"><a href="">3 - COMO NEGOCIAR PARTE 3</a></li>
      </ul>
    </div>
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" href="#collapse3">LIÇÃO 03</a>
      </h4>
    </div>
    <div id="collapse3" class="panel-collapse collapse">
      <ul class="list-group">
        <li class="list-group-item"><a href="">1 - COMO NEGOCIAR</a></li>
        <li class="list-group-item"><a href="">2 - COMO NEGOCIAR</a></li>
        <li class="list-group-item"><a href="">3 - COMO NEGOCIAR</a></li>
      </ul>
    </div>
  </div>
  </div>

</div>
  </div>
</div>
        </div>
    </section>
    <div class="footer">
        <p><span class="mif-copyright mif-1g"></span> 2019 Góes & Nicoladelli Advogados Associados</p>
    </div>

    <script src="/Elearning_layout/js/main.js"></script>
</body>
@yield('principal_menu')

</html>

