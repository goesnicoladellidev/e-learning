@extends('menu_principal')
<!DOCTYPE html>
<html lang="pt-br">
<body>
    <header id="top">

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

   <form method="get" action="{{ url('/inserir_permiss', [$qtd_categorias, $id_user]) }}">

    <div id="ranking" class="tbl-ranking">
       <div class="panel-group" style="margin-top: 200%" >
        <h4 style=" margin-left: -250% "><strong>Usuário: {{$nome}}</strong></h4>
        <br>
        <div class="panel panel-default" style=" margin-left: -250% " > <!--  cria linha que separa os buttons    -->

            <h4 class="panel-title" style="margin-left: 1%" >
                <a data-toggle="collapse"  > Permissões - Pastas</a>
            </h4>
            <h4 class="panel-title">
            </h4>
            <!-- </div> -->
           
            @foreach($paineis_permiss as $key=>$categorias)

            <?php 
                $keys =  $key;
         $resp = DB::table('permissoes_categorias as a')
            ->join('permissoes_paineis as b','a.id','=','b.id_categoria_permiss')
            ->select('b.*') 
            ->orderBy('b.id','asc')
            ->where('b.id_categoria_permiss', $key+1) //arrumar aqui ;
            ->get();
            ?>

            <div class="panel-heading" style="margin-left: 1%" >
              <h4 class="panel-title"><input class= "first" type="checkbox" multiple="" name="radio_button_all_{{$keys}}" id=radio_button_all_{{$keys}}" value="1" onclick="toggle(this,'radio_button_{{$keys}}')"> <span class="fa fa-folder fa-lg"></span></a>
                <a  data-toggle="collapse" href="#collapse-{{$keys}}" >{{$categorias->nome_pasta}} -  {{$categorias->descricao}}
                </a>
            </h4>
        </div>
        <div id="collapse-{{$keys}}" class="panel-collapse collapse" >
          <ul class="list-group">
            @foreach($resp as $key=>$categoria)
            <li class="list-group-item">
                <input class="{{$categoria->nome_painel}}" id="radio_button_{{$keys}}" type="checkbox" multiple="" name="radio_button_{{$keys}}" value="1">
                {{$categoria->nome_painel}} {{$key}}
            </li>
            @endforeach
        </ul>
    </div>
    @endforeach
</div>
<br><br><br><br>
<div class="col-md-2" name="avancar" id="avancar" style=" margin-left: -90%; margin-top: 2%" >
    <button class="btn btn-success"> Avançar </button>
</div>

</div>
</div>
</section>
<div class="footer">
    <p><span class="mif-copyright mif-1g"></span> 2019 Góes & Nicoladelli Advogados Associados</p>
</div>

<script type="text/javascript">
    $('input:radio').bind('click mousedown', (function() {
        var isChecked;
        return function(event) {
            if(event.type == 'click') {
                if(isChecked) {
                    isChecked = this.checked = false;
                } else {
                    isChecked = true;
                }
            } else {
                isChecked = this.checked;
            }
        }})());
    </script>

    <script type="text/javascript">

        function toggle(source,valor) {

          checkboxes = document.getElementsByName(valor);
          rb_0 = document.getElementsByName('radio_button_0');
          rb_1 = document.getElementsByName('radio_button_1');

   for(var i=0, n=checkboxes.length; i<n;i++) {

        checkboxes[i].checked = source.checked;
    
  }
}
</script>


<!-- teste 1 ok -->
  <script type="text/javascript">

        function toggle3(source,valor) {

          checkboxes = document.getElementsByName(valor);
          rb_0 = document.getElementsByName('radio_button_0');
          rb_1 = document.getElementsByName('radio_button_1');
         
   for(var i=0, n=checkboxes.length; i<n;i++) {

        checkboxes[i].checked = source.checked;
    }
  }
}
</script>

<!-- teste 2 -->
  <script type="text/javascript">

        function toggle3(source,valor) {

           // alert(valor);
          checkboxes = document.getElementsByName(valor);
          //rb_0 = document.getElementsByName('radio_button_0');
          //rb_1 = document.getElementsByName('radio_button_1');
 
   for(var i=0, n=checkboxes.length; i<n;i++) {
    

    if (valor == "radio_button_0") {
        //alert('x');
        var val = 'radio_button_'+i;
        //alert('x');
        checkboxes1 = document.getElementsByName(val);
        checkboxes1[i].checked = source.checked;
        alert('x');
        for (var y = 0; y < 35; y++) {//INVERTER O FOREACH !!!!!! 

        var vall = 'radio_button_all_'+y;
        checkboxes0 = document.getElementsByName(vall);

        checkboxes0[i].checked = source.checked;
        //nao esta percorrento todos os indices desse array;

        }
       
    }else{

        checkboxes[i].checked = source.checked;
    }
  }
}
</script>
