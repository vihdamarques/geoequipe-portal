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
      <link href="css/datepicker.css" rel="stylesheet">
      <link href="css/bootstrap-responsive.min.css" rel="stylesheet">
      <style>
          body {
              padding-top: 60px;
          }
      </style>
      <!-- Scripts -->
      <script src="js/jquery-1.10.2.min.js"></script>      
      <script src="js/bootstrap.min.js"></script>
      <script src="js/bootstrap-datepicker.js"></script>
      <script src="js/bootstrap-datepicker.pt-BR.js" charset="UTF-8"></script>      
  </head>
  <body>
    <div class="navbar navbar-fixed-top navbar-inverse"> <!-- menu preto: navbar-inverse-->
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="index.php">Geoequipe</a>
          <div class="nav-collapse pull-right">
            <ul class="nav">
              <li class="dropdown">
                <a href="#contact" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-globe icon-white"></i> Gerenciar <b class="caret"></b></a> <!-- icone branco: icon-white-->
                <ul class="dropdown-menu">
                    <li><a href="index.php">Monitoramento</a></li>
                    <li><a href="rastro.php">Rastro</a></li>
                    <li><a href="#">Histórico</a></li>
                    <li><a href="tarefas.php">Tarefas</a></li>
                    <li><a href="#">Agendamento</a></li>
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
                    <li><a href="#">Gráficos</a></li>
                    <li><a href="#">Relatórios</a></li>                    
                </ul>
              </li>        
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user icon-white"></i> Login <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="logout.php">Sair</a></li>
                </ul>
              </li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
  