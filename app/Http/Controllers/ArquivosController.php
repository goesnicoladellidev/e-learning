<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validation;
use App\Arquivos;
use Storage;
use Illuminate\Http\File;


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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        
        $id_setor = $request->id_setor;
        $id_carteira = $request->id_carteira;
        $id_modulo = $request->id_modulo;

        if ($request->file('arquivo') != null) {
               
            $ext = $request->file('arquivo')->getClientOriginalExtension();

            $nome_comple = $request->file('arquivo')->getClientOriginalName();
            $nome = explode('.', $nome_comple);

            $arquivo = new Arquivos();
            $arquivo->id_setor = $id_setor;
            $arquivo->id_cart = $id_cart;
            $arquivo->id_modulo = $id_modulo;
            $arquivo->aula_descricao = $request->descricao;
            $arquivo->link_aula = $request->file('arquivo')->storeAs('imagens',$nome[0].'.'.$ext,'local');
            $arquivo->save();
            $msg = "Arquivo enviado com Sucesso!";

            }else{


                $url_video = $request->input('url');
                $arquivo = new Arquivos();
                $arquivo->id_setor = $id_setor;
                $arquivo->id_carteira = $id_carteira;
                $arquivo->id_modulo = $id_modulo;
                $arquivo->aula_descricao = $request->descricao;
                $arquivo->link_aula = $url_video;
                $arquivo->save();

                $msg = "Cadastro Realizado com Sucesso!";
            }
            
           
             
            
      //return parent::render($request, $exception);
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
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
