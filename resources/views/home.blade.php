@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Aviso:</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    Você está logado!
                </div>
                @yield('principal_menu')
                 <div class="links" style=" margin-left: 2%">
                    <button><a href="http://elearning.goesnicoladelli.net/menu_inicial">ENTRAR</a></button>
                   
                </div>
                <br>
            </div>
        </div>
    </div>
</div>
@endsection
