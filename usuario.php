<?php
    include_once 'class/Usuario.php';
    include_once 'class/Conexao.php';
    include_once 'class/UsuarioDAO.php';
    include_once 'class/Autenticacao.php';
    
    //Autenticação
    $auth = new Autenticacao();
    $auth->autenticar();
    
    //declara e inicializa as variáveis
    $id = null;
    $usuario = null;
    $senha = null;
    $nome = null;
    $ativo = null;
    $perfil = null;
    $email = null;
    $celular = null;
    $telefone = null;
    $Usuario = new Usuario();
    $usuarioDAO = new UsuarioDAO();
    $msg = null;   
    $busca = (isset($_GET["busca"])) ? $_GET["busca"] : "";
    
    //verifica se a variavel id existe no array POST ou GET
    if (isset($_POST["id"])){
        $id = $_POST["id"];
    } elseif (isset($_GET["id"])) {
        $id = $auth->decripta($_GET["id"]); //decriptar id passado por GET
    } else {
        $id = null;
    }

    //verifica que tipo de operação está sendo passada, A - alterar ou D - deletar
    if (isset($_GET["operacao"])){
        $operacao = $_GET["operacao"];
    }
    elseif (isset($_POST["operacao"])){
        $operacao = $_POST["operacao"];
    }
    else{
        $operacao = "";
    }        

    if (!empty($id)) {
        $Usuario = $usuarioDAO->consultarId($id); 
        if ($operacao == "A") {         
            try {
                $usuario = (isset($_POST["usuario"])) ? $_POST["usuario"] : "";                
                $senha = $auth->hashSenha(isset($_POST["senha"]) ? $_POST["senha"] : "");
                $nome = (isset($_POST["nome"])) ? $_POST["nome"] : "";
                $ativo = (isset($_POST["ativo"])) ? $_POST["ativo"] : "";
                $perfil = (isset($_POST["perfil"])) ? $_POST["perfil"] : "";
                $email = (isset($_POST["email"])) ? $_POST["email"] : "";
                $celular = (isset($_POST["celular"])) ? $_POST["celular"] : "";
                $telefone = (isset($_POST["telefone"])) ? $_POST["telefone"] : "";

                $Usuario->setUsuario($usuario);
                $Usuario->setSenha($senha);
                $Usuario->setNome($nome);
                $Usuario->setAtivo($ativo);
                $Usuario->setPerfil($perfil);
                $Usuario->setEmail($email);
                $Usuario->setCelular($celular);
                $Usuario->setTelefone($telefone);    
                //atualizar      
                $usuarioDAO->alterar($Usuario);

                $msg ="<div class=\"alert alert-success\">
                        <button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>
                        <span class=\"text-success\"><strong>Atualizado com sucesso!</strong></span>
                       </div>";  

                $Usuario->setUsuario(null);
                $Usuario->setSenha(null);
                $Usuario->setNome(null);
                $Usuario->setAtivo(null);
                $Usuario->setPerfil(null);
                $Usuario->setEmail(null);
                $Usuario->setCelular(null);
                $Usuario->setTelefone(null);            
                $Usuario->setId(null);
                $id = null;
            } catch (Exception $e) {
                $msg = "<div class=\"alert alert-error\">
                         <button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>
                         <span class=\"text-error\"><strong>" . $e->getMessage() . "</strong></span>
                        </div>";
            }

        } elseif ($operacao == "D") {          
            try {
                //deletar
                $usuarioDAO->excluir($id);
                $msg =" <div class=\"alert alert-error\">
                         <button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>
                         <span class=\"text-error\"><strong>Deletado com sucesso!</strong></span>
                        </div>"; 

                $Usuario->setUsuario(null);
                $Usuario->setSenha(null);
                $Usuario->setNome(null);
                $Usuario->setAtivo(null);
                $Usuario->setPerfil(null);
                $Usuario->setEmail(null);
                $Usuario->setCelular(null);
                $Usuario->setTelefone(null);            
                $Usuario->setId(null);
                $id = null;
            } catch (Exception $e) {
                $msg = "<div class=\"alert alert-error\">
                         <button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>
                         <span class=\"text-error\"><strong>" . $e->getMessage() . "</strong></span>
                        </div>";
            }
        }
    } else {       
        if ($operacao == "I") {            
            try {
                $usuario = (isset($_POST["usuario"])) ? $_POST["usuario"] : "";                
                $senha = $auth->hashSenha(isset($_POST["senha"]) ? $_POST["senha"] : "");
                $nome = (isset($_POST["nome"])) ? $_POST["nome"] : "";
                $ativo = (isset($_POST["ativo"])) ? $_POST["ativo"] : "";
                $perfil = (isset($_POST["perfil"])) ? $_POST["perfil"] : "";
                $email = (isset($_POST["email"])) ? $_POST["email"] : "";
                $celular = (isset($_POST["celular"])) ? $_POST["celular"] : "";
                $telefone = (isset($_POST["telefone"])) ? $_POST["telefone"] : "";

                $Usuario->setUsuario($usuario);
                $Usuario->setSenha($senha);
                $Usuario->setNome($nome);
                $Usuario->setAtivo($ativo);
                $Usuario->setPerfil($perfil);
                $Usuario->setEmail($email);
                $Usuario->setCelular($celular);
                $Usuario->setTelefone($telefone);
                //inserir
                $usuarioDAO->inserir($Usuario); 
                $msg = "<div class=\"alert alert-success\">
                         <button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>
                         <span class=\"text-success\"><strong>Inserido com sucesso!</strong></span>
                        </div>"; 

                $Usuario->setUsuario(null);
                $Usuario->setSenha(null);
                $Usuario->setNome(null);
                $Usuario->setAtivo(null);
                $Usuario->setPerfil(null);
                $Usuario->setEmail(null);
                $Usuario->setCelular(null);
                $Usuario->setTelefone(null);  
                $Usuario->setId(null);
            } catch (Exception $e) {
                    $msg = "<div class=\"alert alert-error\">
                             <button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>
                             <span class=\"text-error\"><strong>" . $e->getMessage() . "</strong></span>
                            </div>"; 
            }
        }
    }    

  //paginacao do relatorio
  $pag = (isset($_GET["pag"])) ? $_GET["pag"] : 0;

  $usuarios_pag = 10; //usuários por página
  $inicio = $pag * $usuarios_pag;
  $total_usuarios = (int) $usuarioDAO->totalUsuarios();
  $total_pag = ceil($total_usuarios/$usuarios_pag);
  $usuarios = $usuarioDAO->consultarTodos($inicio, $usuarios_pag, $busca);

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
        <script src="js/bootstrap.min.js"></script>
        <script>
            var req;
            function consulta(){
                if(window.XMLHttpRequest) { 
                    req = new XMLHttpRequest(); 
                } else if(window.ActiveXObject) { 
                    req = new ActiveXObject("Microsoft.XMLHTTP"); 
                }
                var string = $('#busca').val();
                var url = "usuario.php?busca=" + string;
                req.open("Get", url, true);
                req.onreadystatechange = function(){
                    var resposta = req.responseText;   
                    document.getElementById('relatorio').innerHTML = resposta;
                }
            }

        </script>        
    </head>
    <body>
        <!--Cabeçalho-->
        <?php include_once 'header.php'; ?>
        <!--Formulário-->
        <div class="container">
            <?php
              $auth = new Autenticacao();
              $perfil = $auth->autenticarCadUsua();
              if ($perfil == "G"){
            ?>
            <form id="formUsuario" class="form-horizontal" method="POST" action="usuario.php">
                <legend>Cadastro de Usuário <!-- span style="font-size: 10pt">(Todos os campos são obrigatórios)</span--></legend>
                <div class="control-group">
                    <div class="controls">
                        <?php echo $msg;?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="usuario">Usuário</label>
                    <div class="controls">
                        <input type="text" value="<?php echo $Usuario->getUsuario();?>" name="usuario" id="usuario" placeholder="Digite o usuário">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="senha">Senha</label>
                    <div class="controls">
                        <input type="password" value="<?php echo $Usuario->getSenha(); ?>" name="senha" id="senha" placeholder="Digite a senha">
                    </div>    
                </div>
                <div class="control-group">
                    <label class="control-label" for="nome">Nome</label>
                    <div class="controls">
                        <input type="text" value="<?php echo $Usuario->getNome(); ?>" name="nome" id="nome" placeholder="Digite o nome">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="email">Email</label>
                    <div class="controls">
                        <input type="text" value="<?php echo $Usuario->getEmail(); ?>" name="email" id="email" placeholder="Digite o email">
                    </div>
                </div>
                 <div class="control-group">
                    <label class="control-label" for="celular">Celular</label>
                    <div class="controls">
                        <input type="text" value="<?php echo $Usuario->getCelular(); ?>" name="celular" id="celular" placeholder="Digite o celular">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="telefone">Telefone</label>
                    <div class="controls">
                        <input type="text" value="<?php echo $Usuario->getTelefone(); ?>" name="telefone" id="telefone" placeholder="Digite o telefone">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputAtivo">Ativo</label>
                    <div class="controls">
                        <select name="ativo" id="inputAtivo">
                            <option value="S" <?php echo $Usuario->getAtivo() == "S" ? "selected=\"selected\"" :  "" ?> >Sim</option>
                            <option value="N" <?php echo $Usuario->getAtivo() == "N" ? "selected=\"selected\"" : "" ?> >Não</option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputAtivo">Perfil</label>
                    <div class="controls">
                        <select name="perfil" id="inputAtivo">
                            <option value="E" <?php echo $Usuario->getPerfil() == "E" ? "selected=\"selected\"" :  "" ?> >Externo</option>
                            <option value="I" <?php echo $Usuario->getPerfil() == "I" ? "selected=\"selected\"" : "" ?> >Interno</option>
                            <option value="G" <?php echo $Usuario->getPerfil() == "G" ? "selected=\"selected\"" : "" ?> >Gestor</option>
                        </select>
                    </div>
                </div>
                <input type="hidden" name="operacao" id="operacao" value="<?php echo empty($id) ? "I" : "A"; ?>" />
                <input type="hidden" name="id" id="id" value="<?php echo $Usuario->getId(); ?>" />                
                <div class="control-group">
                    <div class="controls">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                        <button type="button" class="btn" onclick="window.location='usuario.php'">Cancelar</button>
                        <?php
                        if ($Usuario->getId() != null) {
                            ?>
                            <button type="button" class="btn btn-danger" onclick="if(confirm('Deseja realmente excluir?')) window.location='usuario.php?operacao=D&id=<?php echo $auth->encripta($id); ?>'">Excluir</button>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </form>
            <?php
              }
            ?>
            <br />
            <!--Busca-->
            <div class="controls"> 
                <input type="text"  class="span5 search-query" name="busca" id="busca" autocomplete="off" placeholder="BUSCA" tabindex="1" >
                <button type="button" class="btn" onclick="consulta()"><i class="icon-search icon-large"></i></button>
            </div>
            <br />
            <!--Relatório-->
            <?php                
                if (sizeof($usuarios) > 0) {
            ?>
                <table class="table table-hover" style="width: 100%" id="relatorio">
                    <thead>
                        <tr>
                            <?php                            
                              if ($perfil == "G"){
                            ?>
                            <th style="text-align:center">Editar</th>
                            <?php
                              }
                            ?>
                            <th>#</th>
                            <th>Nome</th>
                            <th>Usuario</th>
                            <th>Email</th>
                            <th>Celular</th>
                            <th>Telefone</th>
                            <th>Perfil</th>
                            <th>Ativo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($usuarios as $key => $usr) {
                            ?>
                            <tr>
                                <?php                            
                                  if ($perfil == "G"){
                                ?>
                                <td style="text-align:center"><a href="usuario.php?id=<?php echo $auth->encripta($usr->getId()); ?>"><i class="icon-pencil"></i></a></td>
                                <?php
                                  }
                                ?>
                                <td><?php echo $usr->getId(); ?></td>
                                <td><?php echo $usr->getNome(); ?></td>
                                <td><?php echo $usr->getUsuario(); ?></td>
                                <td><?php echo $usr->getEmail(); ?></td>
                                <td><?php echo $usr->getCelular(); ?></td>
                                <td><?php echo $usr->getTelefone(); ?></td>
                                <td><?php  switch ($usr->getPerfil()) {
                                                case "I":
                                                   echo "Interno";
                                                    break;
                                                case "E":
                                                    echo "Externo";
                                                    break;
                                                case "G":
                                                    echo "Gestor";
                                                break;
                                                default:                                                    
                                                    break;
                                            } ?></td>      
                                <td><?php  switch ($usr->getAtivo()) {
                                    case "S":
                                       echo "Sim";
                                        break;
                                    case "N":
                                        echo "Não";
                                        break;
                                    default:                                                    
                                        break;
                                } ?></td>                                        
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>                
                <?php
                }                
            ?>
        <!--Paginação do Relatório-->    
        <ul class="pager">
        <?php 
            if ($pag !=  0){
        ?>
          <li class="previous">
            <a href="usuario.php?pag=<?php echo $pag - 1; ?>">&larr; Anterior</a>
          </li>
          <?php 
            } 
            if ($pag < $total_pag){
          ?>
          <li class="next">
            <a href="usuario.php?pag=<?php echo $pag + 1; ?>"> Próximo &rarr;</a>
          </li>
          <?php
        }
        ?>
        </ul>
        </div>
    </body>
</html>