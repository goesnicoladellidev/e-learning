@extends('menu_principal')
<!DOCTYPE html>

    </header>
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

    </header>
<section class="container-fluid">
    </script>
    <div class="container-fluid">
        <h2 class="pull-left" style="margin-left: 35%"> Responder Questionário </h2>
        <!-- <div class="pull-right" style="margin-top: 1.7%;">
            <a href="" class="btn btn-primary"> Voltar </a>
        </div> -->
    </div>
    <hr>
    <div class="container-fluid">
    @if(session("success"))
    <div class="alert alert-success" id="alerta">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>{{ session("success") }}</strong>
    </div>
    @endif
    @if(session("error"))
    <div class="alert alert-danger" id="alerta">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>{{ session("error") }}</strong>
    </div>
    @endif
    </div>
    <form method="get" action="{{ url('/result_resposta', $id) }}">
     {!! csrf_field() !!}
    <div class="container-fluid" style="margin-left: 23%; margin-right: 20% ">
        <div class="form-group">
            <div class="clearfix">
                <table class="table table-striped table-responsive table-bordered" style="width:50% margin-left 20%">
                    <thead>
                        <tr style="width:100%">
                            <th style="width:50%">Questões</th>
                            <th style="width: 50%; ">Opções</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- QUESTÃO 1 -->
                        @foreach($resp_questionario as $key=>$resp_questionario)
                        <tr>
                         <td style="text-align: left;" colspan="2">
                                <strong>  {{$resp_questionario->num_questao}})  {{$resp_questionario->titulo_pergunta}} : </strong>
                            </td>
                        </tr>
                        <tr>
                          <td style="text-align: left;"> {{$resp_questionario->num_questao}}) {{$resp_questionario->questao}}</td>
                            <td>
                                <select class="form-control select_1" name="questao_{{$resp_questionario->num_questao}}" id="questao_{{$resp_questionario->num_questao}}" required="required">       
                                    <option value="" disabled="disabled">Selecione</option>
                                    <option value="{{$resp_questionario->valor_resp_1}}">{{$resp_questionario->resposta_1}}</option>
                                    <option value="{{$resp_questionario->valor_resp_2}}">{{$resp_questionario->resposta_2}}</option>        
                                    <option value="{{$resp_questionario->valor_resp_3}}">{{$resp_questionario->resposta_3}}</option>        
                                    <option value="{{$resp_questionario->valor_resp_4}}">{{$resp_questionario->resposta_4}}</option>   
                                </select>
                            </td>
                        </tr>
                    @endforeach
                        </div>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
        <hr>
        <div class="col-md-3" style="margin-left: 35%;">
            <button class="btn btn-lg btn-block btn-primary">
                Finalizar Teste
            </button>
        </div>
    </form>
</section>
<!-- SCRIPTS -->
 <script>
    var contador = 2;
    setTimeout(temporizador,1000);
  
    function temporizador()
    {
        if(contador > 0)
        {
            setTimeout(temporizador,1000);
        }else 
        {
            $("#alerta").slideUp(1500);
        }
        contador--;
    }
</script>
<script>

    jQuery(function($) {
    var backups = {};

    $(".select_1").change(function() {
        var v = $(this).val();
        var f = false;
        
        $(".select_1").not(this).each(function() {
            if($(this).val() == v) {
                f = true;
                return;                
            }
        });
        if(f) {

        }
    }).val(null);

    $(".select_2").change(function() {
        var v = $(this).val();
        var f = false;
        
        $(".select_2").not(this).each(function() {
            if($(this).val() == v) {
                f = true;
                return;                
            }
        });
        if(f) {
           
            

        }
    }).val(null);

    $(".select_3").change(function() {
        var v = $(this).val();
        var f = false;
        
        $(".select_3").not(this).each(function() {
            if($(this).val() == v) {
                f = true;
                return;                
            }
        });
        if(f) {
           
            alert("Você já utilizou essa resposta, escolha uma diferente!"); 
             $(this).val(backups[$(this).attr("questao_3")]);

        }
    }).val(null);

    $(".select_4").change(function() {
        var v = $(this).val();
        var f = false;
        
        $(".select_4").not(this).each(function() {
            if($(this).val() == v) {
                f = true;
                return;                
            }
        });
        if(f) {
           
            alert("Você já utilizou essa resposta, escolha uma diferente!"); 
             $(this).val(backups[$(this).attr("questao_4")]);

        }
    }).val(null);

    $(".select_5").change(function() {
        var v = $(this).val();
        var f = false;
        
        $(".select_5").not(this).each(function() {
            if($(this).val() == v) {
                f = true;
                return;                
            }
        });
        if(f) {
           
            alert("Você já utilizou essa resposta, escolha uma diferente!"); 
             $(this).val(backups[$(this).attr("questao_5")]);

        }
    }).val(null);

    $(".select_6").change(function() {
        var v = $(this).val();
        var f = false;
        
        $(".select_6").not(this).each(function() {
            if($(this).val() == v) {
                f = true;
                return;                
            }
        });
        if(f) {
           
            alert("Você já utilizou essa resposta, escolha uma diferente!"); 
             $(this).val(backups[$(this).attr("questao_6")]);

        }
    }).val(null);


    $(".select_7").change(function() {
        var v = $(this).val();
        var f = false;
        
        $(".select_7").not(this).each(function() {
            if($(this).val() == v) {
                f = true;
                return;                
            }
        });
        if(f) {
           
            alert("Você já utilizou essa resposta, escolha uma diferente!"); 
             $(this).val(backups[$(this).attr("questao_7")]);
        }
    }).val(null);

    $(".select_8").change(function() {
        var v = $(this).val();
        var f = false;
        
        $(".select_8").not(this).each(function() {
            if($(this).val() == v) {
                f = true;
                return;                
            }
        });
        if(f) {
           
            alert("Você já utilizou essa resposta, escolha uma diferente!"); 
             $(this).val(backups[$(this).attr("questao_8")]);
        }
    }).val(null);
    
    $(".select_9").change(function() {
        var v = $(this).val();
        var f = false;
        
        $(".select_9").not(this).each(function() {
            if($(this).val() == v) {
                f = true;
                return;                
            }
        });
        if(f) {
           
            alert("Você já utilizou essa resposta, escolha uma diferente!"); 
             $(this).val(backups[$(this).attr("questao_9")]);

        }
    }).val(null);

    $(".select_10").change(function() {
        var v = $(this).val();
        var f = false;
        
        $(".select_10").not(this).each(function() {
            if($(this).val() == v) {
                f = true;
                return;                
            }
        });
        if(f) {
           
            alert("Você já utilizou essa resposta, escolha uma diferente!"); 
             $(this).val(backups[$(this).attr("questao_10")]);

        }
    }).val(null);

    $(".select_11").change(function() {
        var v = $(this).val();
        var f = false;
        
        $(".select_11").not(this).each(function() {
            if($(this).val() == v) {
                f = true;
                return;                
            }
        });
        if(f) {
           
            alert("Você já utilizou essa resposta, escolha uma diferente!"); 
             $(this).val(backups[$(this).attr("questao_11")]);

        }
    }).val(null);

    $(".select_12").change(function() {
        var v = $(this).val();
        var f = false;
        
        $(".select_12").not(this).each(function() {
            if($(this).val() == v) {
                f = true;
                return;                
            }
        });
        if(f) {
           
            alert("Você já utilizou essa resposta, escolha uma diferente!"); 
             $(this).val(backups[$(this).attr("questao_12")]);

        }
    }).val(null);

    $(".select_13").change(function() {
        var v = $(this).val();
        var f = false;
        
        $(".select_13").not(this).each(function() {
            if($(this).val() == v) {
                f = true;
                return;                
            }
        });
        if(f) {
           
            alert("Você já utilizou essa resposta, escolha uma diferente!"); 
             $(this).val(backups[$(this).attr("questao_13_a")]);

        }
    }).val(null);

    $(".select_14").change(function() {
        var v = $(this).val();
        var f = false;
        
        $(".select_14").not(this).each(function() {
            if($(this).val() == v) {
                f = true;
                return;                
            }
        });
        if(f) {
           
            alert("Você já utilizou essa resposta, escolha uma diferente!"); 
             $(this).val(backups[$(this).attr("questao_14_a")]);

        }
    }).val(null);

    $(".select_15").change(function() {
        var v = $(this).val();
        var f = false;
        
        $(".select_15").not(this).each(function() {
            if($(this).val() == v) {
                f = true;
                return;                
            }
        });
        if(f) {
           
            alert("Você já utilizou essa resposta, escolha uma diferente!"); 
             $(this).val(backups[$(this).attr("questao_15_a")]);

        }
    }).val(null);

    $(".select_16").change(function() {
        var v = $(this).val();
        var f = false;
        
        $(".select_16").not(this).each(function() {
            if($(this).val() == v) {
                f = true;
                return;                
            }
        });
        if(f) {
           
            alert("Você já utilizou essa resposta, escolha uma diferente!"); 
             $(this).val(backups[$(this).attr("questao_16_a")]);

        }
    }).val(null);

    $(".select_17").change(function() {
        var v = $(this).val();
        var f = false;
        
        $(".select_17").not(this).each(function() {
            if($(this).val() == v) {
                f = true;
                return;                
            }
        });
        if(f) {
           
            alert("Você já utilizou essa resposta, escolha uma diferente!"); 
             $(this).val(backups[$(this).attr("questao_17_a")]);

        }
    }).val(null);

    $(".select_18").change(function() {
        var v = $(this).val();
        var f = false;
        
        $(".select_18").not(this).each(function() {
            if($(this).val() == v) {
                f = true;
                return;                
            }
        });
        if(f) {
           
            alert("Você já utilizou essa resposta, escolha uma diferente!"); 
             $(this).val(backups[$(this).attr("questao_18_a")]);

        }
    }).val(null);

    $(".select_19").change(function() {
        var v = $(this).val();
        var f = false;
        
        $(".select_19").not(this).each(function() {
            if($(this).val() == v) {
                f = true;
                return;                
            }
        });
        if(f) {
           
            alert("Você já utilizou essa resposta, escolha uma diferente!"); 
             $(this).val(backups[$(this).attr("questao_19_a")]);

        }
    }).val(null);

    $(".select_20").change(function() {
        var v = $(this).val();
        var f = false;
        
        $(".select_20").not(this).each(function() {
            if($(this).val() == v) {
                f = true;
                return;                
            }
        });
        if(f) {
           
            alert("Você já utilizou essa resposta, escolha uma diferente!"); 
             $(this).val(backups[$(this).attr("questao_20_a")]);

        }
    }).val(null);
 
 });  
</script>

