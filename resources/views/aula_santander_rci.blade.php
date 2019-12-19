@extends('menu_principal')
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Menu DropDown Vertical Teste</title>
    <link rel="stylesheet" 
        href="https://cdn.rawgit.com/olton/Metro-UI-CSS/master/build/css/metro-icons.min.css">
        <link rel="stylesheet" href="/Elearning_layout/font-awesome-4.7.0/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="/Elearning_layout/css/estilo.css">
    <link rel="stylesheet" type="text/css" href="/Elearning_layout/css/boxes2.css">
    <link rel="shortcut icon" href="/Elearning_layout/img/student_icon.jpg" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
</head>

<body>
    <header id="top">
        <form action="" id="search" class="slide-fwd-left">
            <input type="search" placeholder="Buscar">
            <a href="http://elearning.goesnicoladelli.net/home">Usuário <span class="fa fa-user fa-lg"></span></a>
        </form>
    </header>
    <section>
        <iframe src="/Elearning_layout/modulo_certo/story_html5.html" id="iframe"></iframe>

        <div class="tbl-ranking" style="overflow-x:auto;">
            <table>
                <thead>
                    <tr>
                        <th>Avatar</th>
                        <th>Posição</th>
                        <th>Patente</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><img src="/Elearning_layout/img/avatar_1.png" alt="" class="avatar"></td>
                        <td>1º lugar</td>
                        <td><strong>Iniciante:</strong> 100 pts</td>
                    </tr>
                    <tr>
                        <td><img src="/Elearning_layout/img/avatar_1.png" alt="" class="avatar"></td>
                        <td>2º lugar</td>
                        <td><strong>Iniciante:</strong> 95 pts</td>
                    </tr>
                    <tr>
                        <td><img src="/Elearning_layout/img/avatar_1.png" alt="" class="avatar"></td>
                        <td>3º lugar</td>
                        <td><strong>Iniciante:</strong> 92 pts</td>
                    </tr>
                </tbody>    
            </table>
        </div>
    </section>

    <div class="footer">
        <p><span class="mif-copyright mif-1g"></span> 2019 Góes & Nicoladelli Advogados Associados</p>
    </div>

    <script src="/Elearning_layout/js/main.js"></script>
</body>
@yield('principal_menu')
</html>