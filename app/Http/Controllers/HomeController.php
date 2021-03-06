<?php

namespace App\Http\Controllers;


use Request;
//use App\Http\Controller\Input;
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
use Illuminate\Support\Facades\Input;


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

   public function rota_upload_videos(){

    return view('upload_videos');
   }

   public function rota_cadastrar_curso(){

       $setor = Request::input('setor_curso');
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

   $pontos_quiz = ($valor_pontuacao * 200);
   $valor_exp = ($valor_pontuacao * 85);
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
    
   $user = auth::user();

   $tab_premios =  DB::table("ranking_users")
    ->where('id_user', $user->id)
    ->get();

    //SE O VALOR DO PREMIO = 1 NO BANCO ENTÃO MUDA SPRITE E CONFIRMA QUE RECEBEU PREMIO;
   $input = Request::all();
    if (!empty($input['btn_premio_1'])) {
       
       $premio_get = $input['btn_premio_1'];
       $insere = DB::table('ranking_users')
         ->where('id_user', $user->id)
         ->update([
           'premio_1' => $premio_get
         ]);
        
    }else if (!empty($input['btn_premio_2'])) {
       
       $premio_get = $input['btn_premio_2']; 
    
       $insere = DB::table('ranking_users')
         ->where('id_user', $user->id)
         ->update([
           'premio_2' => $premio_get
         ]);
 
    }else if (!empty($input['btn_premio_3'])) {
       
       $premio_get = $input['btn_premio_3'];

       $insere = DB::table('ranking_users')
         ->where('id_user', $user->id)
         ->update([
           'premio_3' => $premio_get
         ]);

    }else if (!empty($input['btn_premio_4'])) {
       
       $premio_get = $input['btn_premio_4'];

       $insere = DB::table('ranking_users')
         ->where('id_user', $user->id)
         ->update([
           'premio_4' => $premio_get
         ]); 
   
    }else if (!empty($input['btn_premio_5'])) {
       
       $premio_get = $input['btn_premio_5'];
       $insere = DB::table('ranking_users')
         ->where('id_user', $user->id)
         ->update([
           'premio_5' => $premio_get
         ]);
    }else if (!empty($input['btn_premio_6'])) {
       
       $premio_get = $input['btn_premio_6']; 

       $insere = DB::table('ranking_users')
         ->where('id_user', $user->id)
         ->update([
           'premio_6' => $premio_get
         ]);
    }

    //COMO SERÁ COMUNICAÇÃO DE CONTROLE ENTRE GESTOR X COLABORADOR??.
    
   return back();
}


public function rota_ranking(){

        $user = auth::user();
        $premiacao_liberada = false; // controla botao de premiacao liberada;
        $pegou_premiacao = false; // verifica se a premiacao liberada foi recebida;
        $premios = 0;

        $tab_ranking = DB::table("ranking_users")
        ->where('id_user', $user->id)
        ->get();

        $modulos_concluidos = 0;

        $pontuacao_total = $tab_ranking[0]->points_user;

        $premios = $this->verifica_premios_concluidos($pontuacao_total);
  
        return view('treinamento_ranking')
        ->with('pontuacao_total',$pontuacao_total)
        ->with('modulos_concluidos',$modulos_concluidos)
        ->with('premios',$premios)
        ->with('tab_ranking',$tab_ranking);

    }

    public function verifica_premios_concluidos($pontuacao_total){
      
      $premios_concluidos = 0;

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
          case ($xp_required >= 901):
          $patente = "Lenda GN 2";

          break;
          default:
          break;
      }

      return $patente;
  }

  public function rota_treinamentos_iframe($id_setor, $id_carteira)
  { 
  //recebe parametro id_carteira
    

    $user = auth::user();

    $controller_modulo = DB::table('modulo_cadastro as a')
      ->join('modulo_controller as b', 'a.id', '=', 'b.id_modulo_cadastrado')
      ->select('a.*','b.*','a.id as Id','a.id_modulo as Modulo_num','a.aula_descricao as Aula_descricao','a.link_aula as Aula_link')
      ->where('b.id_user', '=', $user->id)
      ->where('id_setor',$id_setor)
      ->where('id_carteira',$id_carteira)
      ->orderby('a.id_modulo', 'asc')
      ->get();
//dd($controller_modulo);

    $controller_modulo2 = DB::table('modulo_cadastro as a')
      ->join('modulo_controller as b', 'a.id', '=', 'b.id_modulo_cadastrado')
      ->select('a.*','b.*','a.id as Id','a.id_modulo as Modulo_num','a.aula_descricao as Aula_descricao','a.link_aula as Aula_link','b.modulo_visibilidade as Modulo_visibilidade','b.modulo_concluido as Modulo_concluido', 'b.media_questao_user as Media_questao_user')
      ->where('b.id_user', '=', $user->id)
      ->where('id_setor',$id_setor)
      ->where('id_carteira', $id_carteira)
      ->orderby('a.id_modulo', 'asc')
      ->get();

      //dd($controller_modulo,$controller_modulo2);
      //WHERE SETOR E CARTEIRA 
    $verifica_modulos_existentes = DB::table('respostas_questionario as a')
     ->select('a.id_modulo_cadastrado as Modulos')
     ->distinct('a.id_modulo')
     ->get(); 


    foreach ($verifica_modulos_existentes as $key => $value) {

        $modulo[] =  array('index' => $value->Modulos );

     }

             $modulos_abertos = DB::table('modulo_cadastro as a')
              ->join('modulo_controller as b', 'a.id', '=', 'b.id_modulo_cadastrado')
              ->select('a.*','b.*','a.id as Id','a.id_modulo as Modulo_num','a.aula_descricao as Aula_descricao','a.link_aula as Aula_link','b.modulo_visibilidade as Modulo_visibilidade','b.modulo_concluido as Modulo_concluido', 'b.media_questao_user as Media_questao_user')
              ->where('b.id_user', '=', $user->id)
              ->where('id_setor',$id_setor)
              ->where('id_carteira', $id_carteira)
              ->where('modulo_concluido', 'N')
              ->get();

             $modulos_concluidos = DB::table('modulo_cadastro as a')
              ->join('modulo_controller as b', 'a.id', '=', 'b.id_modulo_cadastrado')
              ->select('a.*','b.*','a.id as Id','a.id_modulo as Modulo_num','a.aula_descricao as Aula_descricao','a.link_aula as Aula_link','b.modulo_visibilidade as Modulo_visibilidade','b.modulo_concluido as Modulo_concluido', 'b.media_questao_user as Media_questao_user')

              ->where('b.id_user', '=', $user->id)
              ->where('id_setor',$id_setor)
              ->where('id_carteira', $id_carteira)
              ->where('modulo_concluido', 'S')
              ->get();

            return view('treinamento_negociadores_iframe')
               ->with('controller_modulo', $controller_modulo)
               ->with('controller_modulo2', $controller_modulo2)
               ->with('id_setor',$id_setor)
               ->with('id_carteira', $id_carteira);
          }

  public function rota_resp_questionario($id_setor, $id_carteira, $id_modulo){ 
  
           $input = Request::all();
          
          // $resp_questionario = DB::table("respostas_questionario")
           // ->where('id_modulo_cadastrado', $id_modulo)
            //->get();

            $resp_questionario = DB::table('modulo_cadastro as a')
              ->join('respostas_questionario as b', 'a.id', '=', 'b.id_modulo_cadastrado')
              ->select('a.*','b.*','a.id as Id','a.id_modulo as Modulo_num','a.aula_descricao as Aula_descricao','a.link_aula as Aula_link','b.id_modulo_cadastrado as Modulo_cadastro','b.titulo_pergunta as Titulo_pergunta','b.num_questao as Num_questao','b.questao as Questao', 'b.resposta_1 as Resposta_1','b.resposta_2 as Resposta_2','b.resposta_3 as Resposta_3','b.resposta_4 as Resposta_4','b.valor_resp_1 as Valor_resp_1','b.valor_resp_2 as Valor_resp_2','b.valor_resp_3 as Valor_resp_3','b.valor_resp_4 as Valor_resp_4')
              ->where('a.id_setor',$id_setor)
              ->where('a.id_carteira', $id_carteira)
              ->where('a.id_modulo', $id_modulo)
              ->get();

           return view('questionario_elearning')
            ->with('resp_questionario', $resp_questionario)
            ->with('id_setor', $id_setor)
            ->with('id_carteira', $id_carteira)
            ->with('id_modulo', $id_modulo);
       }

public function result_respostas($id_setor, $id_carteira, $id_modulo){
  
    $input = Request::all();


    $modulos = DB::table('modulo_cadastro as a')
              ->join('modulo_controller as b', 'a.id', '=', 'b.id_modulo_cadastrado')
              ->select('a.*','b.*','a.id as Id','a.id_modulo as Modulo_num','a.aula_descricao as Aula_descricao','a.link_aula as Aula_link','b.modulo_visibilidade as Modulo_visibilidade','b.modulo_concluido as Modulo_concluido', 'b.media_questao_user as Media_questao_user')
              ->where('a.id_setor',$id_setor)
              ->where('a.id_carteira', $id_carteira)
               ->where('a.id_modulo', $id_modulo)
              ->get();


    $qtd_questoes = DB::table('modulo_cadastro as a')
              ->join('respostas_questionario as b', 'a.id', '=', 'b.id_modulo_cadastrado')
              ->select('a.*','b.*','a.id as Id','a.id_modulo as Modulo_num','a.aula_descricao as Aula_descricao','a.link_aula as Aula_link','b.modulo_visibilidade as Modulo_visibilidade','b.modulo_concluido as Modulo_concluido', 'b.media_questao_user as Media_questao_user')
              ->where('a.id_setor',$id_setor)
              ->where('a.id_carteira', $id_carteira)
               ->where('a.id_modulo', $id_modulo)
              ->count();


    $questionario = DB::table('respostas_questionario')
     ->where('id_modulo_cadastrado', $id_modulo)
     ->get();

   
    $media_requisito = 5;
    $valor_nota = (10 / $qtd_questoes);
    $resp_correta = 0;
    $media_final = 0;
    $cont_resp = 0;
    //dd($input['questao_2']);
    for ($i=1; $i <= $qtd_questoes ; $i++) { 
              

          if ($input['questao_'.$i] == 's' ) {
             // var_dump($input['questao_'.$i]);
              $resp_correta = $valor_nota;
              $cont_resp = $cont_resp + 1;
              $media_final = $media_final + $valor_nota;
             
           }else{

              $resp_correta = 0;
              $cont_resp = $cont_resp + 0;
              $media_final = $media_final + $resp_correta; 
          }
        }

    //dd($qtd_questoes);
    //dd($id_setor,$id_carteira,$id_modulo);

      if ($media_final >= $media_requisito) {

         DB::table('modulo_controller as a')
         ->join('modulo_cadastro as b', 'b.id', '=', 'a.id_modulo_cadastrado')
         ->where('b.id_setor',$id_setor)
         ->where('b.id_carteira', $id_carteira)
         ->where('b.id_modulo', $id_modulo)
         ->update([
               'modulo_concluido'  => 'S',
               'modulo_visibilidade'  => 'S',
               'media_questao_user' => $media_final,
               'qtd_acertos'  => $cont_resp
           ]);

         }else{

                    //NAO ESTA CAINDO NO ELSE;
         DB::table('modulo_controller as a')
         ->join('modulo_cadastro as b', 'b.id', '=', 'a.id_modulo_cadastrado')
           ->where('b.id_setor',$id_setor)
           ->where('b.id_carteira', $id_carteira)
           ->where('b.id_modulo', $id_modulo)
           ->update([
           'media_questao_user' => $media_final,
           'qtd_acertos'  => $cont_resp

        ]);
      }

      $this->rota_menu_inicial();

      if ($media_final >= $media_requisito) {
        
         return Redirect('menu_inicial')->with('msg', "Você alcançou nota acima da média!");

      }

      return Redirect('menu_inicial');
}

  public function cadastro_cursos(){

    return view('cadastro_cursox');

}

public function opcao_cadastros(Request $request){

    $id_setor = Request::input('setor_curso');
    $id_carteira = Request::input('carteira_cob1');
    $qtd_perguntas = Request::input('qtd_perguntas');
    $num_modulo = Request::input('num_modulo');

    $count_modulos = DB::table('modulo_cadastro')
        ->where('id_setor', $id_setor)
        ->where('id_carteira', $id_carteira)
        ->count();

    $base_setores = DB::table('setor_tab') 
     ->get();   

   return view('cadastro_perguntas')
   ->with('id_setor', $id_setor)
   ->with('id_carteira', $id_carteira)
   ->with('qtd_perguntas',$qtd_perguntas)
   ->with('count_modulos',$count_modulos);
}

public function cadastra_pergunta($setor, $carteira, $qtd_perg, Request $request){ 

        $user = auth::user();
        $id_setor = $setor;
        $id_carteira = $carteira;
        $quantidade_perguntas = $qtd_perg;
        $id_modulo = Request::input('num_modulo');
        $url = Request::input('url');
        $aula_descricao = Request::input('descricao');
        $num_questao = 0;
        //$aula_descricao = "descrição do input";
        $arquivo_nome = "nomeArquivo";
        $extensao_arquivo = "mp4"; 

        $link_aula ="";
       /*$url_teste = '<iframe width="560" height="315" src="https://www.youtube.com/embed/DHfYI7o3_PU" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';*/
      if ($url != null) {

       $remove = '<iframe width="560" height="315" src="' ;
       
       $remove2 = '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';

       $subject = 'REGISTER 11223344 here' ;
       $search = '1223344' ;
       $url_par1 = str_replace($remove, '', $url) ;
       $link_aula = str_replace($remove2, '', $url_par1) ;

       }

        if (empty($id_modulo) || $id_modulo == null) {
          $id_modulo = 1;
        }
        if (empty($id_cadastro )) {
           $id_cadastro = 1;
        }

       
        $exist_modulo   = DB::table('modulo_cadastro')
         ->where('id_setor',$id_setor)
         ->where('id_carteira', $id_carteira)
         ->where('id_modulo', $id_modulo)
         ->first();


        $numero_questao = DB::table('respostas_questionario_user')
         ->where('id', $user->id)
         ->get();

      
          var_dump("arrumar aq");
        $cont_modulos_cad = DB::table('modulo_cadastro as a')
            ->join('modulo_controller as b', 'a.id_modulo', '=', 'b.id_modulo_cadastrado')
            ->select('a.*','b.*','a.id as Id','a.id_modulo as Modulo_num','a.aula_descricao as Aula_descricao','a.link_aula as Aula_link','b.modulo_visibilidade as Modulo_visibilidade','b.modulo_concluido as Modulo_concluido', 'b.media_questao_user as Media_questao_user')
            //->where('b.id_user', '=', $user->id)
            ->where('a.id_setor',$id_setor)
            ->where('a.id_carteira', $id_carteira)
            ->where('a.id_modulo', $id_modulo)
            //->where('b.qtd_acertos', 1)
            //->orderby('a.id_modulo', 'asc')
            ->count();

         
         //dd($cont_modulos);

        $modulo_concluidos = DB::table('modulo_cadastro as a')
            ->join('modulo_controller as b', 'a.id_modulo', '=', 'b.id_modulo_cadastrado')
            ->select('a.*','b.*','a.id as Id','a.id_modulo as Modulo_num','a.aula_descricao as Aula_descricao','a.link_aula as Aula_link','b.modulo_visibilidade as Modulo_visibilidade','b.modulo_concluido as Modulo_concluido', 'b.media_questao_user as Media_questao_user')
            ->where('b.id_user', '=', $user->id)
            ->where('id_setor',$id_setor)
            ->where('id_carteira', $id_carteira)
            ->where('b.qtd_acertos', 1)
            ->orderby('a.id_modulo', 'asc')
            ->count();
    
  

       if ($exist_modulo == '') {

         DB::table('modulo_cadastro')
            ->insert([

              'id_setor' => $id_setor,
              'id_carteira' => $id_carteira,
              'id_modulo' => $id_modulo,
              'aula_descricao' => $aula_descricao,
              'link_aula' => $link_aula

            ]);
          }

    
           $last_id_insert_modulo = DB::table('modulo_cadastro')
          ->select('id')
          ->where('id_setor', $id_setor)
          ->where('id_carteira',$id_carteira)
          ->where('id_modulo',$id_modulo) 
          ->max('id');

         // 

         
          $id_modulo_cadastrado = $last_id_insert_modulo;
          if ($id_modulo_cadastrado == 0) {
             $id_modulo_cadastrado = 1;
          }


          // ************************************************************ 

          //QUANDO JÁ POSSUI MODULO  NAO PODE CADASTRAR NOVO MODULO_CONTROLLER!
          //SE MODULO EXISTENTE FOR VISIBILIDADE = S ENTAO  VISIB = N; ELSE VISIB = S;

         
          $modulo_visivel = DB::table('modulo_cadastro as a')
            ->join('modulo_controller as b', 'a.id_modulo', '=', 'b.id_modulo_cadastrado')
            ->select('a.*','b.*','a.id as Id','a.id_modulo as Modulo_num','a.aula_descricao as Aula_descricao','a.link_aula as Aula_link','b.modulo_visibilidade as Modulo_visibilidade','b.modulo_concluido as Modulo_concluido', 'b.media_questao_user as Media_questao_user')
            ->where('id_setor',$id_setor)
            ->where('id_carteira', $id_carteira)
            ->orderby('a.id_modulo', 'asc')
            ->first();

            if ($cont_modulos_cad == 0 && $exist_modulo == ''){

             $id_cadastro = $last_id_insert_modulo +1;
             DB::table('modulo_controller')
             ->insert([
              'id_user' => $user->id,
              'id_modulo_cadastrado' => $id_modulo_cadastrado,
              'modulo_visibilidade' => 'S',
              'modulo_concluido' => 'N'
            ]);
           }
        
       $count_modulos_cad2 = DB::table('modulo_cadastro')
        ->where('id_setor', $id_setor)
        ->where('id_carteira', $id_carteira)
        ->where('id_modulo', $id_modulo)
        ->max('id_modulo');

       //SE TODOS OS ANTIGOS MODULOS FOREM CONCLUIDOS ENTÃO DEIXAR O MODULO CADASTRADO VISIVEL. SE NÃO DEIXAR INVISIVEL PARA QUE USUARIO DESBLOQUEI DE FORMA ORDENADA AO RESPONDER/CONCLUIR CADA MODULO;
        
       for ($i=1; $i <= $quantidade_perguntas ; $i++) { 

         $verifica_qtd_questoes = DB::table('respostas_questionario')
          ->where('id_modulo_cadastrado', $id_modulo_cadastrado)
          ->where('id_setor', $id_setor)
          ->where('id_carteira', $id_carteira)
          ->max('num_questao');

        if ($verifica_qtd_questoes <= 0 || empty($verifica_qtd_questoes)) { 
          $num_questao = 1;
        }else{

             $num_questao = $verifica_qtd_questoes;
             $num_questao += 1;
             var_dump('correção: id_modulo_cadastrado está vindo 2 e não valor 1 como deve ser!!!!!');

        }
        
         $perguntas_quiz = Request::input('pergunta_quiz_'.$i);
         $titulo_pergunta = Request::input('titulo_pergunta'.$i);
         $resposta_correta = Request::input('respostas_radio'.$i); //OBS:FAZER RADIO BUTTON REQUIRED!!!!!
         $respostas_quiz_1 = Request::input('respostas_quiz_a_'.$i); //FAZER CAMPOS RESPOSTAS, REQUIRED!!!
         $respostas_quiz_2 = Request::input('respostas_quiz_b_'.$i); //FAZER CAMPOS RESPOSTAS, REQUIRED!!!
         $respostas_quiz_3 = Request::input('respostas_quiz_c_'.$i); //FAZER CAMPOS RESPOSTAS, REQUIRED!!!
         $respostas_quiz_4 = Request::input('respostas_quiz_d_'.$i); //FAZER CAMPOS RESPOSTAS, REQUIRED!!!

        if ($resposta_correta == "a"){
           $valor_resp_1 = "s";  $valor_resp_2 = "n";  $valor_resp_3 = "nn";  $valor_resp_4 = "nnn";            
       }if ($resposta_correta == "b") {
           $valor_resp_1 = "n";  $valor_resp_2 = "s";  $valor_resp_3 = "nn";  $valor_resp_4 = "nnn";           
       }if ($resposta_correta == "c") {
           $valor_resp_1 = "n";  $valor_resp_2 = "nn";  $valor_resp_3 = "s";  $valor_resp_4 = "nnn";          
       }if ($resposta_correta == "d") {
           $valor_resp_1 = "n";  $valor_resp_2 = "nn";  $valor_resp_3 = "nnn";  $valor_resp_4 = "s";          
       }

    
       DB::table('respostas_questionario')
       ->insert([

        'id_setor' => $id_setor,
        'id_modulo_cadastrado' => $id_modulo_cadastrado,
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
   }

    if (empty($exist_modulo) || $exist_modulo == null) {  

       return redirect('/menu_inicial')
     ->with('id_setor', $id_setor)
     ->with('id_carteira', $id_carteira)
     ->with('id_modulo', $id_modulo);
    }
     
     $msg = "Cadastro Realizado com Sucesso!";


     return redirect('/menu_inicial')
     ->with('mensagem',$msg)
     ->with('id_setor', $id_setor)
     ->with('cursos_setor', $cursos_setor)
     ->with('id_carteira', $id_carteira)
     ->with('id_modulo', $id_modulo);

  }

  //obs : armazenamento dos arquivos estão no controller ArquivosController;

  public function  opcoes_permissoes(){
      
      $user = Auth::user();

      $tab_usuarios = DB::table('users')
      ->get();
     
     // dd( $checkbutton2);
      return view('cadastrar_permissoes')
       ->with('tab_usuarios', $tab_usuarios);
  }

  public function tab_user_permissoes(){

      $my_id = Auth::user();
      $id_user = Request::input('user_select');
      //fazer join com tabela de permissoes dos usuarios;

      $tab_permiss = DB::table('permissoes_categorias')
       ->get();

      $nome =  DB::table('users')
       ->where('id', $id_user)
       ->first();

      $paineis_permiss = DB::table('permissoes_categorias as a')
        ->orderBy('a.id','asc')
        ->get();
     
        $count =0;
        $qtd_categorias = $tab_permiss->count();
  
    //dd($qtd_categorias);

    return view('tabela_permissoes')
    ->with('nome', $nome->name)
    ->with('id_user', $id_user)
   //->with('resp',$resp)
    ->with('count',$count)
    ->with('tab_permiss', $tab_permiss)
    ->with('paineis_permiss', $paineis_permiss)
    ->with('qtd_categorias',$qtd_categorias);

  }

  public function inserir_permiss($qtd_categorias, $id_user){

  
    //$checkbox[] = '';$qtd_categorias
    for ($i=0; $i < 15; $i++) { 

    if (isset($_GET['radio_button_'.$i])) {
    
        $checkbox[] = intval($_GET['radio_button_'.$i]);

        $teste[] = array('radio_button_'.$i => $_GET['radio_button_'.$i]  );
        //dd($teste);
     }
}   
  foreach ($teste as $key => $value) {
    $valor[$key] = $value;
    $va[] = $value;
  }
  
   var_dump($checkbox);
   $search = array_search("radio_button_3", array_keys($valor));
   //$test = array_search($valor);
    dd($teste); //puxando corretamente o array
    //obs:  falta pegar os sub indices de cada array!!!!

   // b2 -> teste[0]
 die;


 
     /* $inserir_permiss = DB::table('permissoes_categorias as a')
            ->join('modulo_controller as b', 'a.id_modulo', '=', 'b.id_modulo_cadastrado')
            ->select('a.*','a.id as Id','a.id_modulo as Modulo_num','a.aula_descricao as Aula_descricao','a.link_aula as Aula_link','b.modulo_visibilidade as Modulo_visibilidade','b.modulo_concluido as Modulo_concluido', 'b.media_questao_user as Media_questao_user')
            ->where('id_user',$id_user)
            ->where('id_permissao', $id_permissao)
            ->first();*/
       return back();
  }
}
