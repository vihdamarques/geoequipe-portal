<?php 
    include_once 'class/Conexao.php';
    include_once 'class/Autenticacao.php';
    //Autenticação
    $auth = new Autenticacao();
    $auth->autenticar();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Geoequipe</title>
        <!-- CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <style>
        body {
            padding-top: 60px;
        }
        .twitter {border: 1px #005580 dashed}
        .twitter .twtr-hd {display:none !important;}
        .twitter .twtr-timeline {font-family:arial !important; font-size:12pt !important;}

        </style>
        <!-- Scripts -->
        <script src="js/bootstrap.min.js"></script>
    </head>
    <body>
        <!--Cabeçalho-->
        <?php include_once 'header.php'; ?>
        <!--Corpo-->
        <div class="container">
            <h1>Bem vindo ao sistema !</h1>
            <p>Utilize o menu acima para navegar</p>
            
        </div>
    </body>
</html>