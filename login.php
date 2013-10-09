<?php 
    include_once 'class/Conexao.php';
    include_once 'class/Autenticacao.php';
    include_once 'class/Usuario.php';

    //Conexão
    $conn = new Conexao();

    //declara e inicializa as variaveis
    $usuario = null;
    $senha = null;
    $msg = "";
    $auth = new Autenticacao($conn);

    if($_SERVER["REQUEST_METHOD"]  == "POST"){
        $usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : "";
        $senha = $auth->hashSenha(isset($_POST['senha']) ? $_POST['senha'] : "");       
        $valida = $auth->login($usuario, $senha); 

        if ($valida == true){
            header("Location: index.php");
        } else {
            //redireciona para pagina de login com mensagem
            $msg = "<div class=\"alert alert-error\">
                        <button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>
                        <span class=\"text-error\"><strong>Usuário inválido</strong></span>
                    </div>";
        }
    }

    //destruir conexão
    $conn->__destruct();    
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
        <div class="navbar navbar-fixed-top navbar-inverse"> <!-- menu preto: navbar-inverse-->
          <div class="navbar-inner">
            <div class="container-fluid">
              <img src="img/logo.png" style="float: left; margin: 5px 5px 0px 0px;"/>
              <a class="brand" href="index.php">Geoequipe</a>     
            </div>
          </div>
        </div>
        <div class="container">
            <form class="form-horizontal" method="POST" action="login.php">
                <legend>Login</legend>                
                    <div class="control-group">
                        <div class="controls">
                            <?php if(!empty($msg)){ echo $msg; } ?>
                        </div>
                    </div>                
                <div class="control-group">
                    <label class="control-label" for="usuario">Usuário</label>
                    <div class="controls">
                        <input type="text" name="usuario" id="usuario" placeholder="Digite seu usuário">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="senha">Senha</label>
                    <div class="controls">
                        <input type="password" name="senha" id="senha" placeholder="Digite sua senha">
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <button type="submit" class="btn btn-primary">Entrar</button>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>