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
        
       /*$this->validate($request, [
        'file'  => 'mimes:mp4,mov,ogg,qt | max:20000000'
    ]);
         */
          
           /* ini_set('max_file_uploads', 50);
            ini_set('post_max_size', 10);
            ini_set('memory_limit', 32);*/
    
            $ext = $request->file('arquivo')->getClientOriginalExtension();

            $nome_comple = $request->file('arquivo')->getClientOriginalName();
            //$name2 = pathinfo($name);
            $nome = explode('.', $nome_comple);
            //dd($nome[0]);

            $arquivo = new Arquivos();
            $arquivo->descricao = $request->descricao;
            $arquivo->url = $request->file('arquivo')->storeAs('imagens',$nome[0].'.'.$ext,'local');
            $arquivo->save();
            
            $msg = "Arquivo enviado com sucesso";
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
