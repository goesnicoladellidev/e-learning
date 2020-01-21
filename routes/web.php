<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login_ead', [
		'uses' => 'ElearningController@index'
	]);
/*Route::get('/treinamento_negociadores', [
	'middleware' => 'auth',
	'uses' => 'HomeController@rota_treinamentos'
]);*/

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/menu_inicial', 'HomeController@rota_menu_inicial')->name('treinamento_menu');

//rota lições
Route::get('/treinamento_negociadores_iframe/{id_setor}/{id_carteira}', 'HomeController@rota_treinamentos_iframe')->name('treinamento_negociadores_iframe');

//Route::get('/treinamento_negociadores_iframe', 'HomeController@rota_treinamentos_iframe')->name('treinamento_negociadores_iframe');

Route::get('/questionario_elearning/{id_setor}/{id_carteira}/{id}', 'HomeController@rota_resp_questionario')->name('questionario_elearning');

/**------------------ RESSULTADO DO QUIZ -----------------------------*/

Route::get('/result_resposta/{id_setor}/{id_carteira}/{id_modulo}', 'HomeController@result_respostas')->name('result_respostas');

//--------------------------------------------------------
//cadastrar perguntas

Route::get('/opcao_cadastros', 'HomeController@opcao_cadastros')->name('cadastro_perguntas');

Route::get('/cadastra_pergunta/{setor}/{carteira}/{qtd_perg}', 'HomeController@cadastra_pergunta')->name('cadastra_pergunta');

/*Route::get('/upload_videos', 'HomeController@rota_upload_videos')->name('rota_upload_videos');
*/
Route::resource('/arquivo', "ArquivosController", ['names'=>['update'=>'upload']]);


Route::get('/anexar_videos', 'HomeController@anexar_videos')->name('cadastra_pergunta');


// NAME VIEW DEVE RECEBER OUTRA, NAO PODE FICAR cadastro_perguntas
/*Route::get('/cadastrar_perg/{setor}/{carteira}/{qtd_perg}','HomeController@cadastrar_perg')->name('cadastro_perguntas');*/
/*-------------------------------------------------------------------*/
//cadastro cursos:
Route::get('/rota_cadastrar_curso', 'HomeController@rota_cadastrar_curso')->name('cadastrar_curso');

//pega valor da seleção por json / jquery
Route::get('/get_id_setor/{id_setor}', 'HomeController@get_id_setor')->name('rota_cadastrar_curso');

//rota ranking
Route::get('/rota_ranking/premiacoes', 'HomeController@rota_ranking')->name('rota_ranking');

Route::get('/rota_ranking/receber_premio', 'HomeController@receber_premio')->name('rota_ranking');

Route::get('/cadastrar_permissoes', 'HomeController@cadastrar_permissoes')->name('cadastrar_permissoes');



//--------------------------------------------------------------------------
