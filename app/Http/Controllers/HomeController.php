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
  { //recebe parametro id_carteira
    

    $user = auth::user();


    $controller_modulo = DB::table('modulo_cadastro as a')
      ->join('modulo_controller as b', 'a.id_modulo', '=', 'b.id_modulo_cadastrado')
      ->select('a.*','b.*','a.id as Id','a.id_modulo as Modulo_num','a.aula_descricao as Aula_descricao','a.link_aula as Aula_link')
      ->where('b.id_user', '=', $user->id)
      ->where('id_setor',$id_setor)
      ->where('id_carteira',$id_carteira)
      ->orderby('a.id_modulo', 'asc')
      ->get();
   //dd($controller_modulo);
    $controller_modulo2 = DB::table('modulo_cadastro as a')
      ->join('modulo_controller as b', 'a.id_modulo', '=', 'b.id_modulo_cadastrado')
      ->select('a.*','b.*','a.id as Id','a.id_modulo as Modulo_num','a.aula_descricao as Aula_descricao','a.link_aula as Aula_link','b.modulo_visibilidade as Modulo_visibilidade','b.modulo_concluido as Modulo_concluido', 'b.media_questao_user as Media_questao_user')
      ->where('b.id_user', '=', $user->id)
      ->where('id_setor',$id_setor)
      ->where('id_carteira', $id_carteira)
      ->orderby('a.id_modulo', 'asc')
      ->get();

      //WHERE SETOR E CARTEIRA 
    $verifica_modulos_existentes = DB::table('respostas_questionario as a')
     ->select('a.id_modulo_cadastrado as Modulos')
     ->distinct('a.id_modulo')
     ->get(); 
    //dd($verifica_modulos_existentes);
    //VERIFICAR ESSA FUNÇÃO / NÃO ESTÁ FUNCIONANDO 100%
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

  public function rota_resp_questionario($id_setor, $id_carteira, $id){ 
  
           $input = Request::all();
           $resp_questionario = DB::table("respostas_questionario")
            ->where('id_modulo_cadastrado', $id)
            ->get();

           return view('questionario_elearning')
            ->with('resp_questionario', $resp_questionario)
            ->with('id',$id);
       }

public function result_respostas($id){
  
    $input = Request::all();

    $qtd_questoes = DB::table('respostas_questionario')
            ->where('id_modulo_cadastrado', $id)
            ->count('id_modulo_cadastrado');

    $questionario = DB::table('respostas_questionario')
     ->where('id_modulo_cadastrado', $id)
     ->get();

    $media_requisito = 5;
    $valor_nota = (10 / $qtd_questoes);
    $resp_correta = 0;
    $media_final = 0;
    $cont_resp = 0;

    for ($i=1; $i <= $qtd_questoes ; $i++) { 
              
            if ($input['questao_'.$i] == 's' ) {

              $resp_correta = $valor_nota;
              $cont_resp = $cont_resp + 1;
              $media_final = $media_final + $valor_nota;
             
           }else{

              $resp_correta = 0;
              $cont_resp = $cont_resp + 0;
              $media_final = $media_final + $resp_correta; 

          }
        }

      if ($media_final >= $media_requisito) {

         DB::table('modulo_controller')
         ->where('id_modulo_cadastrado', $id) 

             ->update([
               'modulo_concluido'  => 'S',
               'modulo_visibilidade'  => 'S',
               'media_questao_user' => $media_final,
               'qtd_acertos'  => $cont_resp
           ]);

             $id += 1;

             DB::table('modulo_controller')->where('id_modulo_cadastrado', $id)
             ->update([
               'modulo_visibilidade'  => 'S'
           ]);
         }else{

          DB::table('modulo_controller')
          ->where('id_modulo_cadastrado', $id)
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
    //dd($count_modulos );
    $base_setores = DB::table('setor_tab') 
     ->get();   

   return view('cadastro_perguntas')
  // ->with('num_questao', $verifica_qtd_questoes)
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
        //dd($quantidade_perguntas);
        $id_modulo = Request::input('num_modulo');
        $link_aula = Request::input('url');
        $aula_descricao = Request::input('descricao');
        //dd($url,$descri);

        $num_questao = 0;
        //$aula_descricao = "descrição do input";
        $arquivo_nome = "nomeArquivo";
        $extensao_arquivo = "mp4"; 
        //$link_aula = "/Elearning_layout/treinamentos/".$arquivo_nome.".".$extensao_arquivo;

       
        //dd($id_modulo_cadastrado);
       /* if (empty($id_modulo_cadastrado) || $id_modulo_cadastrado == null) {
          $id_modulo_cadastrado = 1;
        }*/

        if (empty($id_modulo) || $id_modulo == null) {
          $id_modulo = 1;
        }
        if (empty($id_cadastro )) {
           $id_cadastro = 1;
        }

         //cria id +1
       
        $exist_modulo = DB::table('modulo_cadastro')
         ->where('id_setor',$id_setor)
         ->where('id_carteira', $id_carteira)
         ->where('id_modulo', $id_modulo)
         ->first();


        $numero_questao = DB::table('respostas_questionario_user')
         ->where('id', $user->id)
         ->get();

      
          
          var_dump("arrumar aq");
          $cont_modulos = DB::table('modulo_cadastro')
          ->where('id_setor',$id_setor)
          ->where('id_carteira', $id_carteira)
          ->where('id_modulo', $id_modulo)
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
    
       //SE MODULO FOR NOVO ENTÃO VAI PARA A BLADE ANEXAR MATERIAIS VIDEO/FOTO/SLIDES, SE NÃO CADASTRA PERGUNTAS NORMALMENTE.
            //dd($exist_modulo);

       if ($exist_modulo == null) {
       // ESTÁ DANDO INSERT AQUI E NA MODEL. ARRUMAR!!!!!

         DB::table('modulo_cadastro')
            ->insert([

              //'id' => $id_cadastro,
              'id_setor' => $id_setor,
              'id_carteira' => $id_carteira,
              'id_modulo' => $id_modulo,
              'aula_descricao' => $aula_descricao,
              'link_aula' => $link_aula

            ]);
           
          }

        // ****************** ARRUMAR AQUI INSERT ID_MODULO_CADASTRADO **************************

          // COLOCAR ESSE ID_MODULO EM ID_MODULO_CADASTRADO
       /*    $id_modulo_resp = DB::table('modulo_cadastro as a')
          ->join('respostas_questionario as b','a.id','=','b.id_modulo_cadastrado')
          ->select('a.id as Id', 'b.id_setor as Id_setor', 'b.id_carteira as Id_carteira')
          ->where('b.id_setor', $id_setor) 
          ->where('b.id_carteira', $id_carteira)
          ->first();*/
        //dd($id_modulo_resp);
          //$id_modulo = $id_modulo_resp->Id;

           $last_id_insert_modulo = DB::table('modulo_cadastro')
          ->select('id')
          ->where('id_setor', $id_setor)
          ->where('id_carteira',$id_carteira)
          ->where('id_modulo',$id_modulo) 
          ->max('id');

          $id_cadastro = $last_id_insert_modulo +1;

          $id_modulo_cadastrado = $last_id_insert_modulo;

          if ($id_modulo_cadastrado == 0) {
             $id_modulo_cadastrado = 1;
          }

          // ************************************************************

           //dd($cont_modulos,$exist_modulo);
          // QUANDO MODULO É NOVO, NÃO ENTRA AQUI!!!;

          if ($cont_modulos == 0 && $exist_modulo == null){

           //dd('entrou aqui');
             DB::table('modulo_controller')
             ->insert([

              'id_user' => $user->id,
              'id_modulo_cadastrado' => $id_modulo_cadastrado,
              'modulo_visibilidade' => 'S',
              'modulo_concluido' => 'N'

            ]);

           }elseif ($cont_modulos > 0 && $exist_modulo != null){
          
             //$id_modulo_cadastrado += 1;

             DB::table('modulo_controller')
             ->insert([
              'id_user' => $user->id,
              'id_modulo_cadastrado' => $id_modulo_cadastrado,
              'modulo_visibilidade' => 'N',
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
   ///////okk
      
      //BUSCAR O ULTIMO NUMERO DO MODULO ABERTO, INSERIR O PROXIMO VALOR;

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
    //rota upload video
    if (empty($exist_modulo) || $exist_modulo == null) {  
      
      //return view('upload_videos')
       return redirect('/menu_inicial')
     ->with('id_setor', $id_setor)
     ->with('id_carteira', $id_carteira)
     ->with('id_modulo', $id_modulo);
    }
 $msg = "Cadastro Realizado com Sucesso!";

     //return view('cadastrar_curso')
     return redirect('/menu_inicial')
    // return redirect('anexar_videos')
     ->with('mensagem',$msg)
     ->with('id_setor', $id_setor)
     ->with('cursos_setor', $cursos_setor)
     ->with('id_carteira', $id_carteira)
     ->with('id_modulo', $id_modulo);

  }

  
  //obs : armazenamento dos arquivos estão no controller ArquivosController;

  public function cadastrar_permissoes(){
      
      $user = Auth::user();
      $tab_usuarios = DB::table('users')
      ->get();

       return view('cadastrar_permissoes')
    ->with('tab_usuarios', $tab_usuarios);

  }

  public function tab_user_permissoes(){

      $user = Auth::user();
      
      //fazer join com tabela de permissoes dos usuarios;
      $tab_usuarios = DB::table('users')
      ->get();


    return view('cadastrar_permissoes')
    ->with('tab_usuarios', $tab_usuarios);

  }


}
