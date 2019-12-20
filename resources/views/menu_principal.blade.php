
<div class="container">

    <head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GN Treinamento</title>
    <link rel="stylesheet" href="/Elearning_layout/font-awesome-4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdn.rawgit.com/olton/Metro-UI-CSS/master/build/css/metro-icons.min.css">
    <link rel="stylesheet" type="text/css" href="/Elearning_layout/css/estilo.css">
    <link rel="stylesheet" type="text/css" href="/Elearning_layout/css/boxes2.css">
    <link rel="shortcut icon" href="/Elearning_layout/img/student_icon.jpg" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
</head>
    @yield('menu_principal')
       
        <nav>
            <ul id="menu_principal">
                <li><a href="http://elearning.goesnicoladelli.net/menu_inicial"><span class="mif-home mif-3x principais"></span>Início</a></li>
                <li>


                    <label for="drop-cursos">
                        <span class="mif-books mif-3x principais"></span>
                        Cursos
                        <span class="mif-chevron-right mif-2x direita"></span>
                        <span class="mif-expand-more mif-2x direita"></span>
                    </label>
                    <input type="checkbox" id="drop-cursos">
                    <ul>
                        <li>
                            <label for="drop-cobranca">
                                <span class="mif-chart-dots mif-2x"></span>
                                Cobrança
                                <span class="mif-chevron-right mif-2x direita"></span>
                                <span class="mif-expand-more mif-2x direita"></span>
                            </label>
                            <input type="checkbox" id="drop-cobranca">

                            <ul>
                                <li><a href="http://elearning.goesnicoladelli.net/treinamento_negociadores_iframe">Negociadores</a></li>
                                <li><a href="#">Desbloquear</a></li>
                            </ul>
                        </li>

                        <li>
                            <label for="drop-juridico">
                                <span class="mif-justice mif-2x"></span>
                                Jurídico
                                <span class="mif-chevron-right mif-2x direita"></span>
                                <span class="mif-expand-more mif-2x direita"></span>
                            </label>
                            <input type="checkbox" id="drop-juridico">
                            <ul>
                                <li><a href="#"> Desbloquear 1</a></li>
                                <li><a href="#"> Desbloquear 2</a></li>
                                <li><a href="#"> Desbloquear 3</a></li>
                                <li><a href="#"> Desbloquear 4</a></li>
                            </ul>
                        </li>
                        <li>
                            <label for="drop-rh">
                                <span class="mif-organization mif-2x"></span>
                                RH
                                <span class="mif-chevron-right mif-2x direita"></span>
                                <span class="mif-expand-more mif-2x direita"></span>
                            </label>
                            <input type="checkbox" id="drop-rh">

                            <ul>
                                <li><a href="#">Desbloquear</a></li>
                                <li><a href="#">Desbloquear</a></li>
                                <li><a href="#">Desbloquear</a></li>
                            </ul>
                        </li>
                        <li>
                            <label for="drop-adm">
                                <span class="mif-paste mif-2x"></span>
                                Administração
                                <span class="mif-chevron-right mif-2x direita"></span>
                                <span class="mif-expand-more mif-2x direita"></span>
                            </label>
                            <input type="checkbox" id="drop-adm">
                            <!-- <ul>
                                <li><a href="#">Apresentações</a></li>
                                <li><a href="#">Manuais</a></li>
                                <li><a href="#">Vídeos</a></li>
                            </ul> -->
                        </li>
                    </ul>
                </li>
                <li>
                    <label for="drop-ranking">
                        <span class="mif-chart-bars mif-3x principais"></span>
                        Ranking
                        <span class="mif-chevron-right mif-2x direita"></span>
                        <span class="mif-expand-more mif-2x direita"></span>
                    </label>
                    <input type="checkbox" id="drop-ranking">
                    <ul>
                        <li><a href="http://elearning.goesnicoladelli.net/rota_ranking/premiacoes">Premiações</a></li>
                    </ul>
                </li>
                <li>
                    <label for="drop-jornada">
                        <span class="mif-suitcase mif-3x principais"></span>Minha Jornada
                        <span class="mif-chevron-right mif-2x direita"></span>
                        <span class="mif-expand-more mif-2x direita"></span>
                    </label>
                    <input type="checkbox" id="drop-jornada">
                    <ul>
                        <li><a href="#">Fases (EM BREVE)</a></li>
                        <li><a href="#">Medalhas (EM BREVE)</a></li>
                        <li><a href="#">Pontos/EXP (EM BREVE)</a></li>
                        <li><a href="#">Certificados (EM BREVE)</a></li>
                    </ul>
                </li>
                 <li>
                    <label for="drop-jornada1">
                        <span class="mif-cog mif-3x principais"></span>Configurações
                        <span class="mif-chevron-right mif-2x direita"></span>
                        <span class="mif-expand-more mif-2x direita"></span>
                    </label>
                    <input type="checkbox" id="drop-jornada1">

                    <ul>
                        <li><a href="http://elearning.goesnicoladelli.net/rota_cadastrar_curso">Cadastrar Perguntas</a></li>
                        <li><a href="#">Permissões</a></li>
                    
                    </ul>
                </li>
            </ul>
        </nav>
          <script src="/Elearning_layout/js/main.js"></script>
    </div>
