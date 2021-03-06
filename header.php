<?php 
  include_once('class/Autenticacao.php');
?>
<!DOCTYPE html>
<html>
  <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
      <meta charset="utf-8">

      <title>Geoequipe</title>
      <!-- CSS -->      
      <link href="css/bootstrap.min.css" rel="stylesheet">
      <link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet">
      <link href="css/bootstrap-responsive.min.css" rel="stylesheet">
      <link href="css/smoothness/jquery-ui.min.css" rel="stylesheet">
      <style>
          body {
              padding-top: 60px;
          }
      </style>
      <!-- Scripts -->
      <script src="js/jquery-1.10.2.min.js"></script>      
      <script src="js/bootstrap.min.js"></script>
      <script src="js/bootstrap-datetimepicker.min.js"></script>
      <script src="js/bootstrap-datetimepicker.pt-BR.js"></script>
      <script src="js/jquery-ui-1.10.3.custom.min.js"></script>
  </head>
  <body>
    <div class="navbar navbar-fixed-top navbar-inverse"> <!-- menu preto: navbar-inverse-->
      <div class="navbar-inner">
        <div class="container-fluid">
          <img src="img/logo.png" style="float: left; margin: 5px 5px 0px 0px;"/>
          <a class="brand" href="index.php">Geoequipe</a>
          <div class="nav-collapse pull-right">
            <ul class="nav">
              <li class="dropdown">
                <a href="#contact" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-globe icon-white"></i> Gerenciar <b class="caret"></b></a> <!-- icone branco: icon-white-->
                <ul class="dropdown-menu">
                    <li><a href="index.php">Monitoramento</a></li>
                    <li><a href="rastro.php">Rastro</a></li>
                    <li><a href="historico.php">Histórico</a></li>
                    <li><a href="tarefas.php">Tarefas</a></li>
                    <li><a href="distribuicao.php">Distribuição</a></li>
                </ul>
              </li>
              <li class="dropdown">
                <a href="#contact" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-cog icon-white"></i></i> Cadastros <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="equipamento.php">Equipamento</a></li>
                    <li><a href="usuario.php">Usuário</a></li>
                    <li><a href="local.php">Local</a></li>
                </ul>
              </li>
              <li class="dropdown">
                <a href="#contact" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-file icon-white"></i> Relatórios <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="grafico.php">Gráficos</a></li>                    
                </ul>
              </li>        
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user icon-white"></i> 
                      <?php include_once 'class/Usuario.php'; 
                            $string = isset($_SESSION["usuario"]) ? $_SESSION["usuario"]: "" ;
                            $usuario_login = new Usuario();
                            $usuario_login = unserialize($string);
                            echo $usuario_login->getUsuario();                            
                      ?>
                  <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="logout.php">Sair</a></li>
                </ul>
              </li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
  