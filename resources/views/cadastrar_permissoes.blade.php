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
@if (Session::has('message'))
   <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

<div class="container-fluid">
        <div class="col-md-4">
         <form method="get" action="{{ url('/tab_user_permissoes') }}">
         <h1 class="pull-left" style="margin-left: 44%"> Cadastrar Permissões Usuários </h1>
         <br><br><br><br>

         <label class="pull-left" style="margin-left: 25%" >Escolha Usuário :</label>
                <select class="form-control" name="user_select" id="user_select" required="" >
                    <option value=""> Escolha Usuário </option>
                    @foreach($tab_usuarios as $user)
                    <option value="{{$user->id}}"> {{$user->name}}</option>
                    @endforeach
                </select>
            <br><br><br><br>
        <div>
           
<!--                           INICIO  CARTEIRA COB 1                  -->
        <label class="pull-left" for="carteira_cob1" style="margin-left: 25%; display: none; "name="carteira_cob1" id="carteira_cob1" >Tabela Permissoes.</label>
                <select class="form-control" name="carteira_cob1" id="carteira_cob1"  >
                    <option value="" >Tabela Permissoes</option>
                </select>
              <br><br>
<!--                            FIM  CARTEIRA COB 1                  -->
         </div>
             <div class="col-md-2" name="avancar" id="avancar" style=" margin-left: 46%; margin-top: 2%" >
                    <button class="btn btn-success"> Avançar </button>
         </div>
       </div>
@yield('principal_menu')
    </form>
    <script src="/Elearning_layout/js/main.js"></script>
  </body>
 </html>
<script>
    var i = 0;
    function buttonClick(){
        document.getElementById('button').value = ++i;
    }
</script>
<script type="text/javascript">
            function addFields(){
            var number = document.getElementById("member").value;
            var container = document.getElementById("pergunta_quiz");
            while (container.hasChildNodes()) {
                container.removeChild(container.lastChild);
            }
            for (i=0;i<number;i++){
                container.appendChild(document.createTextNode("Member " + (i+1)));
                var input = document.createElement("input");
                input.type = "text";
                container.appendChild(input);
                container.appendChild(document.createElement("br"));
            }
          }
</script>
<script src="https://code.jquery.com/jquery-1.12.4.min.js">
    function pegaId($id){
    $sql = "SELECT * from 'carteiras_tab' where 'id_setor' = {$id_setor}";
    $stm = $pdo->prepare($sql);
    $stm->bindValue(1, $estado);
    $stm->execute();
    sleep(1);
    echo json_encode($stm->fetchAll(PDO::FETCH_ASSOC));
    $pdo = null;
    }
</script>
<script type="text/javascript"> 
    $(document).ready(function(){
        $('#setor_curso').change(function(){
            $('#cidade').load('listaCidades.php?estado='+$('#setor_curso').val());
        });
    });
</script>
<script type="text/javascript">
    $('select[id=setor_curso]').change(function () {
        var id_setor = $(this).val();
        $.get('/get_id_setor/' + id_setor, function (busca) {

            $('#carteira_cob1').show();
            $('select[id=carteira_cob1]').empty();
            $('select[id=carteira_cob1]').append('<option value=""> Selecione uma Carteira </option>');


            $.each(busca, function (key, value) {

                $('select[id=carteira_cob1]').append('<option value=' + value.Id_carteira + '>' + value.Nome_carteira + '</option>');
            });
        });
    });
</script>