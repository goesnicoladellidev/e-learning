<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validation;
use App\Arquivos;
use Storage;
use Illuminate\Http\File;
use DB;


class ArquivosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     public function store(Request $request)
    {   
        
        $id_setor = $request->id_setor;
        $id_carteira = $request->id_carteira;
        $id_modulo = $request->id_modulo;
       //dd($id_setor);
        $id_modulo = DB::table('modulo_cadastro')
        ->where('id_setor', $id_setor)
        ->where('id_carteira',$id_carteira)
        ->where('id_modulo', $id_modulo)
        ->count();

        $exist_modulo = DB::table('modulo_cadastro')
         ->where('id_setor',$id_setor)
         ->where('id_carteira', $id_carteira)
         ->where('id_modulo', $id_modulo)
         ->first();

        if ($id_modulo == null){
         $id_modulo = 1;

        }
         //dd($id_modulo);
         if ($request->file('arquivo') != null) {
            $ext = $request->file('arquivo')->getClientOriginalExtension();
            $nome_comple = $request->file('arquivo')->getClientOriginalName();
            $nome = explode('.', $nome_comple);

            /*$arquivo = new Arquivos();
            $arquivo->id_setor = $id_setor;
            $arquivo->id_carteira = $id_carteira;
            $arquivo->id_modulo = $id_modulo;
            $arquivo->numero_modulo = $id_modulo;
            $arquivo->aula_descricao = $request->descricao;
            $arquivo->link_aula = $request->file('arquivo')->storeAs('imagens',$nome[0].'.'.$ext,'local');
            $arquivo->save();*/
            $msg = "Arquivo enviado com Sucesso!";

            $update = DB::table('modulo_cadastro')
            ->where('id_modulo', $id_modulo)
            ->update([
                'id_setor' => $id_setor,
                'id_carteira' => $id_carteira,
                'id_modulo' => $id_modulo,
                'numero_modulo' => $id_modulo,
                'aula_descricao' => $request->descricao,
                'link_aula' => $request->file('arquivo')->storeAs('imagens',$nome[0].'.'.$ext,'local')

            ]);

            }else{

               /* $url_video = $request->input('url');
                $arquivo = new Arquivos();
                $arquivo->id_setor = $id_setor;
                $arquivo->id_carteira = $id_carteira;
                $arquivo->id_modulo = $id_modulo;
                $arquivo->numero_modulo = $id_modulo;
                $arquivo->aula_descricao = $request->descricao;
                $arquivo->link_aula = $url_video;
                $arquivo->save();*/

         $update = DB::table('modulo_cadastro')
             ->where('id_modulo', $id_modulo)
             ->update([
                'id_setor' => $id_setor,
                'id_carteira' => $id_carteira,
                'id_modulo' => $id_modulo,
                'numero_modulo' => $id_modulo,
                'aula_descricao' => $request->descricao,
                'link_aula' => $request->url

            ]);

                $msg = "Cadastro Realizado com Sucesso!";
            }

             return redirect()->back()->with('mensagem',$msg);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        $id_setor = $request->id_setor;
        $id_carteira = $request->id_carteira;
        $id_modulo = $request->id_modulo;
       //dd($id_setor);
        $id_modulo = DB::table('modulo_cadastro')
        ->where('id_setor', $id_setor)
        ->where('id_carteira',$id_carteira)
        ->where('id_modulo', $id_modulo)
        ->count();

        $exist_modulo = DB::table('modulo_cadastro')
         ->where('id_setor',$id_setor)
         ->where('id_carteira', $id_carteira)
         ->where('id_modulo', $id_modulo)
         ->first();

        if ($id_modulo == null){
         $id_modulo = 1;

        }
         //dd($id_modulo);
         if ($request->file('arquivo') != null) {
            dd('x');
            $ext = $request->file('arquivo')->getClientOriginalExtension();
            $nome_comple = $request->file('arquivo')->getClientOriginalName();
            $nome = explode('.', $nome_comple);

            /*$arquivo = new Arquivos();
            $arquivo->id_setor = $id_setor;
            $arquivo->id_carteira = $id_carteira;
            $arquivo->id_modulo = $id_modulo;
            $arquivo->numero_modulo = $id_modulo;
            $arquivo->aula_descricao = $request->descricao;
            $arquivo->link_aula = $request->file('arquivo')->storeAs('imagens',$nome[0].'.'.$ext,'local');
            $arquivo->save();*/
            $msg = "Arquivo enviado com Sucesso!";


            $update = DB::table('modulo_cadastro')
            ->where('id', $id)
            ->update([
                'id_setor' => $id_setor,
                'id_carteira' => $id_carteira,
                'id_modulo' => $id_modulo,
                'numero_modulo' => $id_modulo,
                'aula_descricao' => $request->descricao,
                'link_aula' => $request->file('arquivo')->storeAs('imagens',$nome[0].'.'.$ext,'local')

            ]);

            }else{

               /* $url_video = $request->input('url');
                $arquivo = new Arquivos();
                $arquivo->id_setor = $id_setor;
                $arquivo->id_carteira = $id_carteira;
                $arquivo->id_modulo = $id_modulo;
                $arquivo->numero_modulo = $id_modulo;
                $arquivo->aula_descricao = $request->descricao;
                $arquivo->link_aula = $url_video;
                $arquivo->save();*/

         $update = DB::table('modulo_cadastro')
             ->where('id', $id)
             ->update([
                'id_setor' => $id_setor,
                'id_carteira' => $id_carteira,
                'id_modulo' => $id_modulo,
                'numero_modulo' => $id_modulo,
                'aula_descricao' => $request->descricao,
                'link_aula' => $request->url

            ]);
             
                $msg = "Cadastro Realizado com Sucesso!";
            }

             return redirect()->back()->with('mensagem',$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
