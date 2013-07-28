<?php 
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
      </style>
      <!-- Scripts -->
      <script src="http://code.jquery.com/jquery.js"></script>
      <script src="js/bootstrap.min.js"></script>
  </head>
  <body>
    <div class="navbar navbar-fixed-top"> <!-- menu preto: navbar-inverse-->
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="#">Geoequipe</a>
          <div class="nav-collapse pull-right">
            <ul class="nav">
              <li class="dropdown">
                <a href="#contact" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-globe"></i> Gerenciar <b class="caret"></b></a> <!-- icone branco: icon-white-->
                <ul class="dropdown-menu">
                    <li><a href="#">Monitoramento</a></li>
                    <li><a href="#">Rastro</a></li>
                    <li><a href="#">Histórico</a></li>
                    <li><a href="#">Tarefas</a></li>
                    <li><a href="#">Agendamento</a></li>
                </ul>
              </li>
              <li class="dropdown">
                <a href="#contact" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-cog"></i></i> Cadastros <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="#">Equipamento</a></li>
                    <li><a href="#">Usuário</a></li>
                    <li><a href="#">Local</a></li>
                </ul>
              </li>
              <li class="dropdown">
                <a href="#contact" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-file"></i> Relatórios <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="#">Exemplo</a></li>
                    <li><a href="#">Exemplo</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                </ul>
              </li>        
              <li class="dropdown">
                <a href="#contact" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user"></i> Login <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="#">Sign Out</a></li>
                </ul>
              </li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
  </body>
</html>