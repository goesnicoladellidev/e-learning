@extends('menu_principal')
<!DOCTYPE html>
<html lang="pt-br">
<body>
    <header id="top">
        <form action="{{url('/treinamento_negociadores_iframe', [$id_setor, $id_carteira])}}" method="get" id="search" class="slide-fwd-left">
            <input type="search" placeholder="Buscar">
            <a href="http://elearning.goesnicoladelli.net/home">Usuário <span class="fa fa-user fa-lg"></span></a>
            <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
        </form>
    </header>
<section>
  @if (session('msg'))
    <div class="alert alert-success">
        {{ session('msg') }}
    </div>
@endif
             <!--      ESSA FUNÇÃO troca frame       -->
             <!--    PRECISA ESCONDER ESSA DIV ON CLICK;     -->
       @foreach($controller_modulo as $key=>$controller_modulo)
         <div class="resume" id="ivideo{{$controller_modulo->Modulo_num}}">
                 <video  width="720" height="600" name="gestao_judicial{{$controller_modulo->Modulo_num}}"  id="gestao_judicial{{$controller_modulo->Modulo_num}}" controls="" onclick="vid_listen_std_rcb('gestao_judicial','vd_checked_{{$controller_modulo->Modulo_num}}')" style="margin-left: 25%">
                 <source src="{{$controller_modulo->Aula_link}}" type="video/mp4">
                  Seu navegador não tem suporte para o formato mp4, escolha uma outra opção para navegar em nossa plataforma de ensino.
                </video>
         </div>
         <div class="resume" id="iframe{{$controller_modulo->Modulo_num}}">
          <iframe name="iframe{{$controller_modulo->Modulo_num}}" width="750" height="750" src="/Elearning_layout/modulo_certo/story_html5.html" id="iframe{{$controller_modulo->Modulo_num}}"  style=" margin-left: 25%; margin-top: 2%" frameborder="0" allowfullscreen></iframe>
         </div>
     @endforeach
        <div class="tbl-ranking">
           <div class="panel-group" style="margin-top: 200%" >
  <div class="panel panel-default" style=" margin-left: -250% "> <!--  cria linha que separa os buttons    -->
    <h4 class="panel-title" style="margin-left: 1%">
        <a data-toggle="collapse" > Módulos - Treinamento Santander</a>
    </h4>
 
  @foreach($controller_modulo2 as $key=>$controller_modulo)
  @if($controller_modulo->Modulo_visibilidade == "S")
   @if($controller_modulo->Modulo_concluido == "N")
    <div class="panel-heading">
      <h4 class="panel-title">
         @if($controller_modulo->Media_questao_user == 0)
        <a data-toggle="collapse" href="#collapse{{$controller_modulo->Modulo_num}}"><font color="red">Módulo {{$controller_modulo->Modulo_num}} (PENDENTE)</font></a>
        @else
         <a data-toggle="collapse" href="#collapse{{$controller_modulo->Modulo_num}}"><font color="red">Módulo {{$controller_modulo->Modulo_num}} (PENDENTE) / Nota: {{$controller_modulo->Media_questao_user}}</font></a>
        @endif
      </h4>
    </div>
    @elseif($controller_modulo->Modulo_concluido == "S")

    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" href="#collapse{{$controller_modulo->Modulo_num}}"><font color="green">Módulo {{$controller_modulo->Modulo_num}} (CONCLUÍDO)</font> / <font color="green">Nota: {{$controller_modulo->Media_questao_user}}</font></a>
      </h4>
    </div>
    @endif
     <div id="collapse{{$controller_modulo->Modulo_num}}" class="panel-collapse collapse">
      <ul class="list-group">
        @if($controller_modulo->Aula_descricao == '')
        @else
        <li class="list-group-item">
          <input type="radio" name="vd_checked_{{$controller_modulo->Modulo_num}}" value="vd_checked_{{$controller_modulo->Modulo_num}}">
             <a href="#ivideo{{$controller_modulo->Modulo_num}}" onclick="vid_start();">{{$controller_modulo->Aula_descricao}}
             </a>
        </li>
        @endif
          <li class="list-group-item">
            <input type="radio" name="vd_checked_{{$controller_modulo->Modulo_num}}" value="vd_checked_{{$controller_modulo->Modulo_num}}">
<a href="{{ url('/questionario_elearning', [$controller_modulo->id_setor,$controller_modulo->id_carteira, $controller_modulo->Id]) }}
" > QUESTIONÁRIO </a>
          </li>
      </ul>
    </div>
     @endif
   @endforeach

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
<script type="text/javascript">
 jQuery(document).ready(function($) {
  $('.resume') .hide()
$('a[href^="#"]').on('click', function(event) {
$('.resume') .hide()
    var target = $(this).attr('href');
    $('.resume'+target).toggle();
 });
});
</script>
<script type="text/javascript">
  function vid_listen_std_rcb(video,checked) {
    var video = document.getElementById(video);
    var checked2 = document.getElementById(checked);
    //DELETAR ESSE DEBUG APÓS TESTES.
    //window.location.href = "http://elearning.goesnicoladelli.net/update_treinamento";
    video.addEventListener('timeupdate', function() {
        if (!video.seeking) {
            if (video.currentTime > timeTracking.watchedTime) {
                timeTracking.watchedTime = video.currentTime;
                lastUpdated = 'watchedTime';
            } else {
                //tracking time updated  after user rewinds
                timeTracking.currentTime = video.currentTime;
                lastUpdated = 'currentTime';    
            }
        }

        if (!document.hasFocus()) {
            video.pause();
        }
    });
    
    window.addEventListener('blur', function() {
   
  video.pause();

});
    // prevent user from seeking
    video.addEventListener('seeking', function() {
        var delta = video.currentTime - timeTracking.watchedTime;
        if (delta > 0) {
            video.pause();
            //play back from where the user started seeking after rewind or without rewind
            video.currentTime = timeTracking[lastUpdated];
            video.play();
        }
    });
       video.addEventListener("ended", function() {
        // here the end is detected
        console.log("video terminou");
        checked2.checked = true;
        window.location.href = "http://elearning.goesnicoladelli.net/update_treinamento";
        // mark true when video is finished;
    //         pageRedirect();
        //PODE FUNCIONAR: QUANDO TERMINA O VIDEO, ATUALIZA PARA NOVA VIEW E MANDA PARA BANCO;
    });
}


function vid_start() {
    window.timeTracking = {
        watchedTime: 0,
        currentTime: 0
    };
    window.lastUpdated = 'currentTime';
}
</script>
<script type="text/javascript"> 
  $('input[type=radio]').click(function(){
    if (this.previous) {
        this.checked = false;
    }
    this.previous = this.checked;
});
</script>


<script type="text/javascript">
  
   function pageRedirect(checked) { //REDIRECIONAR PARA ROTA UPDATE DB;

      var checked2 = document.getElementById(checked);
      window.location.href = "http://elearning.goesnicoladelli.net/update_treinamento";

    }    
</script>