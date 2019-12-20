<?php

namespace App\Http\Controllers;


use Request;
use App\Http\Controller\Input;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Session;
use Auth;
use App\Status;
use Carbon\Carbon;
use Mail;
use File;
use Storage;
use Response;
use App\FinanceiroDevedores;
use Redirect;


class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return view('home');
    }



    public function rota_santander(){
        return view('treinamento_santander');
    }

    public function rota_cad_perguntas(){

       return view('cadastro_perguntas');
   }

   public function rota_cadastrar_curso(){

       $cursos_setor = DB::table('setor_tab')
       ->orderby('nome_curso', 'asc')
       ->get();

       $carteiras = DB::table('carteiras_tab')
       ->where ('id_setor', 1)
       ->orderby('nome_carteira', 'asc')
       ->get();

       return view('cadastrar_curso')
       ->with('carteiras', $carteiras)
       ->with('cursos_setor', $cursos_setor);
   }

   public function get_id_setor($id_setor)
   {


    if ($id_setor == '6') {

    //quando setor for geral pega todas as carteiras de todos os setores;
    //ARRUMAR A LOGICA DISSO! 
    //QUANDO GERAL, NAO PRECISA SELECIONAR NENHUMA, PEGA AUTOMATICO TODOS;

       $dados = DB::table('setor_tab as a')
      ->join('carteiras_tab as b','a.id','=','b.id_setor')
      ->select('a.id as Id_setor', 'b.id as Id_carteira', 'b.nome_carteira as Nome_carteira')
      ->whereIn('id_setor',  array(1,2,3,4,5)) 
      ->orderBy('b.Nome_carteira','asc')
      ->get();

  }else{

      $dados = DB::table('setor_tab as a')
      ->join('carteiras_tab as b','a.id','=','b.id_setor')
      ->select('a.id as Id_setor', 'b.id as Id_carteira', 'b.nome_carteira as Nome_carteira')
      ->where('id_setor', $id_setor)
      ->orderBy('b.Nome_carteira','asc')
      ->get();
  }
  return Response::JSON($dados);
}

public function rota_menu_inicial(){

    $user = auth::user();
    $valor_pontuacao = 0;
    $check_cursos_concluidos = DB::table("modulo_controller")
      ->where('id_user','=', $user->id) 
      ->where('modulo_concluido', 'S')
      ->count();

    $check_points_quiz = DB::table("modulo_controller")
      ->where('id_user',$user->id)
      ->where('qtd_acertos','!=','0')
      ->get();

    $check_user = DB::table("ranking_users")
    ->where('id_user',$user->id)
    ->get();
    
    $tab_ranking = DB::table("ranking_users")
    ->orderby('points_user', 'desc')
    ->paginate(5);

    $qtd_modulos = DB::table("modulo_controller")
    ->where('id_user',$user->id)
    ->count();

    foreach ($check_points_quiz as $key => $value) {
      $valor_pontuacao += $value->qtd_acertos;
  }

  $pontos_quiz = ($valor_pontuacao * 100);
  $valor_exp = ($valor_pontuacao * 45);
  $patente_check = $this->verifica_nivel($valor_exp);

  if (empty($check_user)) {

    $user_ranking =  DB::table('ranking_users')
    ->insert([

        'id_user' => $user->id,
        'name_user' => $user->name,
        'exp_user' => $valor_exp,
        'points_user' => $pontos_quiz,
        'qtd_modulos_concluidos' => $check_cursos_concluidos,
        'nivel' => $patente_check

    ]);
}else{

  $user_ranking =  DB::table('ranking_users')->where('id_user', $user->id)
  ->update([
    'exp_user' => $valor_exp,
    'name_user' => $user->name,
    'points_user' => $pontos_quiz,
    'qtd_modulos_concluidos' => $check_cursos_concluidos,
    'nivel' => $patente_check
    ]);
}

return view('treinamento_menu')
 ->with('check_cursos_concluidos', $check_cursos_concluidos)
 ->with('pontos_quiz',$pontos_quiz)
 ->with('valor_exp',$valor_exp)
 ->with('user', $user)
 ->with('patente_check',$patente_check)
 ->with('check_user', $tab_ranking);
}

public function receber_premio(){
  
   $tab_premios =  DB::table("ranking_users")
    ->where('id_user', $user->id)
    ->get();
   return back();
}

public function rota_ranking(){

        $user = auth::user();
        $premiacao_liberada = false; // controla botao de premiacao liberada;
        $pegou_premiacao = false; // verifica se a premiacao liberada foi recebida;
        $premios = 0;

        $qtd_pontos = DB::table("ranking_users")
        ->where('id_user', $user->id)
        ->get();

        $modulos_concluidos = 0;

        $pontuacao_total = $qtd_pontos[0]->points_user;

        $premios = $this->verifica_premios_concluidos($pontuacao_total);
  
        return view('treinamento_ranking')
        ->with('pontuacao_total',$pontuacao_total)
        ->with('modulos_concluidos',$modulos_concluidos)
        ->with('premios',$premios);

    }

    public function verifica_premios_concluidos($pontuacao_total){

        if($pontuacao_total > 399 ){
            $premios_concluidos = 0;
        }
        if($pontuacao_total >= 400 ){
            $premios_concluidos = 1;

        }if ($pontuacao_total >= 800){
            $premios_concluidos = 2;

        }if ($pontuacao_total >= 1200){
            $premios_concluidos = 3;

        }if ($pontuacao_total >= 1600){
            $premios_concluidos = 4;

        }if ($pontuacao_total >= 1800){
            $premios_concluidos = 5;

        }if ($pontuacao_total >= 2000){
            $premios_concluidos = 6;
        }

        return $premios_concluidos;
    }   

    public function verifica_nivel($xp_required){

        switch ($xp_required) {

          case ($xp_required > 0 && $xp_required <= 180):
          $patente = "Recruta GN 1";
          break;

          case ($xp_required >= 181 && $xp_required <= 360):
          $patente = "Recruta GN 2";

          break;
          case ($xp_required >= 361 && $xp_required <= 540):
          $patente = "Recruta GN 3";

          break;
          case ($xp_required >= 541 && $xp_required <= 720):
          $patente = "Recruta GN 4";

          break;
          case ($xp_required >= 721 && $xp_required <= 900):
          $patente = "Lenda GN";

          break;
          case ($xp_required >= 901 && $xp_required <= 1300):
          $patente = "Lenda GN 2";

          break;
          default:
          break;
      }

      return $patente;
  }

  public function rota_treinamentos_iframe()
  {

    $user = auth::user();
   

    $controller_modulo = DB::table('modulo_cadastro as a')
      ->join('modulo_controller as b', 'a.id', '=', 'b.id_modulo_cadastrado')
      ->select('a.*','b.*','a.id as Id','a.id_modulo as Modulo_num','a.aula_descricao as Aula_descricao','a.link_aula as Aula_link')
      ->where('b.id_user', '=', $user->id)
      ->get();
    

    $controller_modulo2 = DB::table('modulo_cadastro as a')
      ->join('modulo_controller as b', 'a.id', '=', 'b.id_modulo_cadastrado')
      ->select('a.*','b.*','a.id as Id','a.id_modulo as Modulo_num','a.aula_descricao as Aula_descricao','a.link_aula as Aula_link','b.modulo_visibilidade as Modulo_visibilidade','b.modulo_concluido as Modulo_concluido', 'b.media_questao_user as Media_questao_user')
      ->where('b.id_user', '=', $user->id)
      ->get();


    $verifica_modulos_existentes = DB::table('respostas_questionario as a')
    ->select('a.id_modulo as Modulos')
    ->distinct('a.id_modulo')
    ->get(); 


    //VERIFICAR ESSA FUNÇÃO / NÃO ESTÁ FUNCIONANDO 100%
    foreach ($verifica_modulos_existentes as $key => $value) {

        $modulo[] =  array('index' => $value->Modulos );

     }
              $modulos_abertos = DB::table("modulo_controller")
              ->where('id_user', $user->id)
              ->where('modulo_concluido', 'N')
              ->get();

              $modulos_concluidos = DB::table("modulo_controller")
              ->where('id_user', $user->id)
              ->where('modulo_concluido', 'S')
              ->get();

    //verificará se o usuario tem permissao para visualizar o modulo.

            return view('treinamento_negociadores_iframe')
               ->with('controller_modulo', $controller_modulo)
               ->with('controller_modulo2', $controller_modulo2);
          }

  public function rota_resp_questionario($id_setor, $id_carteira, $id){ 
  
           $input = Request::all();
           $resp_questionario = DB::table("respostas_questionario")
            ->where('id_modulo', $id)
            ->get();

           return view('questionario_elearning')
            ->with('resp_questionario', $resp_questionario)
            ->with('id',$id);
       }

       //RESULTADO DO QUIZ
       public function result_respostas($id) //passar mais parametros aqui!;
       {

          //INSERIR NOVO MÓDULO PRIMEIRO = MODULO_CADASTRO DEPOIS ANEXAR MODULO_CONTROLLER PARA VISIBILIDADE E UNIFICAR A PERGUNTA = RESPOSTA_QUESTIONARIO  DENTRO DO MÓDULO CRIADO;
          //obs a questao 1 deve sempre ficar visivel inicialmente.
           $input = Request::All();

           $qtd_questoes = DB::table('respostas_questionario')
            ->where('id_modulo', $id)
            ->max('id_modulo');

           $media_requisito = ($qtd_questoes / 2);

           $resp_correta_1 = 0;
           $resp_correta_2 = 0;
           $resp_correta_3 = 0;
           $resp_correta_4 = 0;

           if ($input['questao_1'] == 's' ) {

               $resp_correta_1 = 2.5;
               $cont_resp_1 = 1;

           }else{

            $resp_correta_1 = 0;
            $cont_resp_1 = 0;

        }
        if ($input['questao_2'] == 's' ) {

           $resp_correta_2 = 2.5;
           $cont_resp_2 = 1;

       }else{

        $resp_correta_2 = 0;
        $cont_resp_2 = 0;

    }
    if ($input['questao_3'] == 's' ) {

       $resp_correta_3 = 2.5;
       $cont_resp_3 = 1;

   }else{

    $resp_correta_3 = 0;
    $cont_resp_3 = 0;

}
if ($input['questao_4'] == 's' ) {

   $resp_correta_4 = 2.5;
   $cont_resp_4 = 1;

}else{

    $resp_correta_4 = 0;
    $cont_resp_4 = 0;

}

$media_nota_usuario = $resp_correta_1 + $resp_correta_2 + $resp_correta_3 + $resp_correta_4; 

$qtd_acertos = $cont_resp_1 + $cont_resp_2 + $cont_resp_3 + $cont_resp_4;

    if ($media_nota_usuario >= $media_requisito) {
   
            //BUSCA WHERE DEVE SER ALTERADA de 'id',id para id_modulo;
            //precisa ser criada uma tabela onde armazena os modulos genéricos e perguntas genericas.
             DB::table('modulo_controller')->where('id', $id) //valor na fecha pq id modulo deve ser igual numero da questao;
             ->update([
               'modulo_concluido'  => 'S',
               'modulo_visibilidade'  => 'S',
               'media_questao_user' => $media_nota_usuario,
               'qtd_acertos'  => $qtd_acertos
           ]);

             $id += 1;

             DB::table('modulo_controller')->where('id', $id)
             ->update([

               'modulo_visibilidade'  => 'S'

           ]);
         }else{

          DB::table('modulo_controller')->where('id', $id)
          ->update([
           'media_questao_user' => $media_nota_usuario,
           'qtd_acertos'  => $qtd_acertos
        ]);
      }

      $tab_questionario = DB::table("respostas_questionario")
      ->where('id_modulo', $id)
      ->get();

      $this->rota_menu_inicial();

      return Redirect('treinamento_negociadores_iframe')
      ->with('id', $id);

  }

  public function cadastro_cursos(){

    return view('cadastro_cursox');

}

public function opcao_cadastros(){

    $id_setor = Request::input('setor_curso');
    $id_carteira = Request::input('carteira_cob1');
    $qtd_perguntas = Request::input('qtd_perguntas');
    $id_modulo = 1;
 
    $count_modulos = DB::table('respostas_questionario')
        ->where('id_setor', $id_setor)
        ->where('id_carteira', $id_carteira)
        ->max('id_modulo');

    $verifica_qtd_questoes = DB::table('respostas_questionario')
    ->where('id_modulo', $id_modulo)
    ->count();

    $base_setores = DB::table('setor_tab') 
    ->get();

    //quantidade de perguntas existentes em um setor - modulo;
    $qtd_perguntas_exist = DB::table('respostas_questionario')
    ->where('id_setor', $id_setor)
    ->where('id_modulo', $id_modulo)
    ->max('num_questao');

    if ($id_setor == 6) {

      $verifica_cad = DB::table('respostas_questionario_user')
        ->whereIN('id_setor',  array(1,2,3,4,5)) //todos os setores puxar do banco - melhorar codigo.
        ->get();

    }else
        {

          $verifica_cad = DB::table('respostas_questionario_user')
          ->where('id_setor', $id_setor)
          ->get();

        }
    if (empty($verifica_cad)) {

      DB::table('respostas_questionario_user')
        ->insert([

            'qtd_perguntas' => $qtd_perguntas,
            'id_modulo' => $id_modulo,
            'aux_setor_id' => $id_setor
        ]);
    
    }else{

       //SE JÁ EXISTE FAZ UPDATE APENAS NA QUANTIDADE.
       DB::table('respostas_questionario_user')
       ->where('id_setor', $id_setor)
       ->where('id_modulo', $id_modulo)
       ->update([
           'qtd_perguntas' => $qtd_perguntas,
           'aux_setor_id' => $id_setor
       ]);
   }

   return view('cadastro_perguntas')
   ->with('num_questao', $verifica_qtd_questoes)
   ->with('id_setor', $id_setor)
   ->with('id_carteira', $id_carteira)
   ->with('qtd_perguntas',$qtd_perguntas)
   ->with('count_modulos',$count_modulos);
}

public function cadastra_pergunta($setor, $carteira, $qtd_perg){ 

        $user = auth::user();
        $id_setor = $setor;
        $id_carteira = $carteira;
        $quantidade_perguntas = $qtd_perg; 
        $id_modulo = Request::input('num_modulo');
        $num_questao = 0;
        $aula_descricao = "descrição do input";
        $arquivo_nome = "nomeArquivo";
        $extensao_arquivo = "mp4"; 
        $link_aula = "/Elearning_layout/treinamentos/".$arquivo_nome.".".$extensao_arquivo;

        //pega ultimo id
        $last_id_insert_modulo = DB::table('modulo_cadastro')
          ->select('id')
          ->max('id');
        
        $id_cadastro = $last_id_insert_modulo +1; //cria id +1

        //numero da questao;
        $numero_questao = DB::table('respostas_questionario_user')
         ->where('id', $user->id)
         ->get();


           DB::table('modulo_cadastro')
        ->insert([
          'id' => $id_cadastro,
          'id_setor' => $id_setor,
          'id_carteira' => $id_carteira,
          'id_modulo' => $id_cadastro,
          'aula_descricao' => $aula_descricao,
          'link_aula' => $link_aula,

        ]);

       
     
       //CONTROLA A VISIBILIDADE DO MODULO PELO CONTADOR COM QUANTIDADE DE MODULOS;
       /*$count_modulos_cad = DB::table('modulo_cadastro as a')
        ->join('modulo_controller as b', 'a.id_modulo','=','b.id_modulo_cadastrado')
        ->where('id_setor', $id_setor)
        ->where('id_carteira', $id_carteira)
        ->where('id_modulo', $id_modulo)
        ->count();*/

        $count_modulos_cad2 = DB::table('modulo_cadastro')
        ->where('id_setor', $id_setor)
        ->where('id_carteira', $id_carteira)
        ->where('id_modulo', $id_modulo)
        ->max('id_modulo');

        

        

// REVER ESSA VERIFICAÇÃO IF - CAINDO SEMPRE NULL;
       if (empty($count_modulos_cad2) ) {
          //dd("x");

           DB::table('modulo_controller')
            ->insert([
            'id_user' => $user->id,
            'id_modulo_cadastrado' => $last_id_insert_modulo,
            'modulo_visibilidade' => 'S',
            'modulo_concluido' => 'N'
            ]);
       }else{

          DB::table('modulo_controller')
            ->insert([
            'id_user' => $user->id,
            'id_modulo_cadastrado' => $last_id_insert_modulo,
            'modulo_visibilidade' => 'N',
            'modulo_concluido' => 'N'
            ]);
       }
       
       //NAO ESTA ADICIONANDO RESPOSTA PARA QUANDO SETOR/CARTEIRA NOVA, INEXISTENTE.
       for ($i=1; $i <= $quantidade_perguntas ; $i++) { 

         $verifica_qtd_questoes = DB::table('respostas_questionario')
          ->where('id_modulo', $id_modulo)
          ->where('id_setor', $id_setor)
          ->where('id_modulo', $id_modulo)
          ->max('num_questao');

        if ($verifica_qtd_questoes <= 0 || empty($verifica_qtd_questoes)) {     
            $num_questao = 1;
            $num_questao += 1;
        }else{

             $num_questao = $verifica_qtd_questoes;
             $num_questao += 1;
        }

         $perguntas_quiz = Request::input('pergunta_quiz_'.$i);
         $titulo_pergunta = Request::input('titulo_pergunta'.$i);
         $resposta_correta = Request::input('respostas_radio'.$i); //OBS:FAZER RADIO BUTTON REQUIRED!!!!!
         $respostas_quiz_1 = Request::input('respostas_quiz_a_'.$i); //FAZER CAMPOS RESPOSTAS, REQUIRED!!!
         $respostas_quiz_2 = Request::input('respostas_quiz_b_'.$i); //FAZER CAMPOS RESPOSTAS, REQUIRED!!!
         $respostas_quiz_3 = Request::input('respostas_quiz_c_'.$i); //FAZER CAMPOS RESPOSTAS, REQUIRED!!!
         $respostas_quiz_4 = Request::input('respostas_quiz_d_'.$i); //FAZER CAMPOS RESPOSTAS, REQUIRED!!!
        if ($resposta_correta == "a") {
           $valor_resp_1 = "s";  $valor_resp_2 = "n";  $valor_resp_3 = "nn";  $valor_resp_4 = "nnn";            
       }if ($resposta_correta == "b") {
           $valor_resp_1 = "n";  $valor_resp_2 = "s";  $valor_resp_3 = "nn";  $valor_resp_4 = "nnn";           
       }if ($resposta_correta == "c") {
           $valor_resp_1 = "n";  $valor_resp_2 = "nn";  $valor_resp_3 = "s";  $valor_resp_4 = "nnn";          
       }if ($resposta_correta == "d") {
           $valor_resp_1 = "n";  $valor_resp_2 = "nn";  $valor_resp_3 = "nnn";  $valor_resp_4 = "s";          
       }
     
      //FAZER JOIN MODULO_CONTROLLER E MODULO CADASTRO, SE ID_SETOR/ CARTEIRA do modulo cadastrado tiver resultaod = count 1, PRIMEIRO MODULO ESTARA VISIVEL = S. se nao visivel = N
      
      //BUSCAR O ULTIMO NUMERO DO MODULO ABERTO, INSERIR O PROXIMO VALOR;

       DB::table('respostas_questionario')
       ->insert([

        'id_setor' => $id_setor,
        'id_modulo' => $id_modulo,
        'id_carteira' => $id_carteira,
        'titulo_pergunta' => $titulo_pergunta,
        'questao' => $perguntas_quiz,
        'resposta_1' => $respostas_quiz_1,
        'resposta_2' => $respostas_quiz_2,
        'resposta_3' => $respostas_quiz_3,
        'resposta_4' => $respostas_quiz_4,  
        'num_questao'=> $num_questao,
        'valor_resp_1' => $valor_resp_1,
        'valor_resp_2' => $valor_resp_2,
        'valor_resp_3' => $valor_resp_3,
        'valor_resp_4' => $valor_resp_4
      ]);

       $cursos_setor = DB::table('setor_tab')
       ->orderby('nome_curso', 'asc')
       ->get();

       $carteiras = DB::table('carteiras_tab')
       ->where('id_setor', 1)
       ->orderby('nome_carteira', 'asc')
       ->get();

       var_dump($resposta_correta,$valor_resp_1,$valor_resp_2,$valor_resp_3,$valor_resp_4);
   }

     die();

}

    public function media_nota($qtd_pergtas,$setor, $cart, $modulo){

        $input = Request::All();
        $id_setor = $setor;
        $qtd_perguntas = $qtd_pergtas;
        $id_carteira = $cart;
        $id_modulo = $modulo;
        $requisito_media = ($qtd_perguntas/2);

     }
}
