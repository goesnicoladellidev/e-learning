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
            <div class="panel-heading" style="margin-left: 1%" >
              <h4 class="panel-title"><input class= "first" type="checkbox" multiple="" name="radio_button_all{{$key}}" value="radio_button_all " onclick="toggle(this,'radio_button_{{$key}}')"> <span class="fa fa-folder fa-lg"></span></a>
                <a  data-toggle="collapse" href="#collapse-{{$key}}" >{{$categorias->nome_pasta}} -  {{$categorias->descricao}}
                </a>
            </h4>
        </div>
        <div id="collapse-{{$key}}" class="panel-collapse collapse" >
          <ul class="list-group">
             <li class="list-group-item">
                <input class="{{$categorias->nome_pasta}}" id="radio_button_{{$key}}" type="checkbox" multiple="" name="radio_button_{{$key}}" value="1">
                {{$categorias->nome_painel}} {{$key}}
            </li>
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


<!-- <script type="text/javascript">
    
 function selectAll(id, isSelected) {

 alert("id="+id+" selected? "+isSelected);
 var selectObj=document.getElementById(id);
 //alert("obj="+selectObj.type);
 var options=selectObj.options;
 //alert("option length="+options.length);
 for(var i=0; i<options.length; i++) {
    options[i].selected=isSelected;
 }
}

</script>
-->

<script type="text/javascript">
    
    function toggle(source,valor) {
 
  checkboxes = document.getElementsByName(valor);
  //alert(source,checkboxes);
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;

  }
}
</script>

<!-- 
<script type="text/javascript">
    $(document).ready(function(){
    $('#radio_button_0, #radio_button_1, #radio_button_2, #radio_button_3,#radio_button_4,#radio_button_5,.radio_button_6').click(function(){
        $(this).val(this.checked ? 1 : 0);
    });
});
</script> -->

<!-- <script type="text/javascript">
    function selectAll(id) {
        var selectObj=document.getElementById(id);
        var options=selectObj.options;
        alert(id);
        $(".first").click(function(){
            $(".id").prop("checked",$(this).prop("checked"));
            x.options = true;
        });
    }
</script> -->

