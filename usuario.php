<?php

    include_once 'class/Usuario.php';
    include_once 'class/Conexao.php';
    include_once 'class/UsuarioDAO.php';

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
    $msg = "";
    
    //verifica se variavel id existe no array POST
    if (isset($_POST["id"])){
        $id = $_POST["id"];
    } elseif (isset($_GET["id"])) {
        $id = $_GET["id"];
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
        //atualizar
            try {
                 if (isset($_POST["usuario"])){
                    $usuario = $_POST["usuario"];
                } 
                if (isset($_POST["senha"])){
                    $senha = $_POST["senha"];
                } 
                if (isset($_POST["nome"])){
                    $nome = $_POST["nome"];
                }                 
                if (isset($_POST["ativo"])){
                    $ativo = $_POST["ativo"];
                } 
                if (isset($_POST["perfil"])){
                    $perfil = $_POST["perfil"];
                } 
                if (isset($_POST["email"])){
                    $email = $_POST["email"];
                } 
                if (isset($_POST["celular"])){
                    $celular = $_POST["celular"];
                } 
                if (isset($_POST["telefone"])){
                    $telefone = $_POST["telefone"];
                } 

                $Usuario->setUsuario($usuario);
                $Usuario->setSenha($senha);
                $Usuario->setNome($nome);
                $Usuario->setAtivo($ativo);
                $Usuario->setPerfil($perfil);
                $Usuario->setEmail($email);
                $Usuario->setCelular($celular);
                $Usuario->setTelefone($telefone);;                
                $usuarioDAO->alterar($Usuario);
                $msg = "Atualizado com sucesso!";
            } catch (Exception $e) {
                $msg = "
                        <div class=\"alert alert-error\">
                            <button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>
                            <span class=\"text-success\"><strong>" . $e->getMessage() . "</strong></span>
                        </div>
                       ";
            }

        } elseif ($operacao == "D") {
          //deletar
            try {
                $usuarioDAO->excluir($usuario);
                $msg = "Deletado com sucesso!";
            } catch (Exception $e) {
                $msg = "
                        <div class=\"alert alert-error\">
                            <button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>
                            <span class=\"text-success\"><strong>" . $e->getMessage() . "</strong></span>
                        </div>
                       ";
            }
        }
    } else {       
        if ($operacao == "I") {
        try {   
                if (isset($_POST["usuario"])){
                    $usuario = $_POST["usuario"];
                } 
                if (isset($_POST["senha"])){
                    $senha = $_POST["senha"];
                } 
                if (isset($_POST["nome"])){
                    $nome = $_POST["nome"];
                }                 
                if (isset($_POST["ativo"])){
                    $ativo = $_POST["ativo"];
                } 
                if (isset($_POST["perfil"])){
                    $perfil = $_POST["perfil"];
                } 
                if (isset($_POST["email"])){
                    $email = $_POST["email"];
                } 
                if (isset($_POST["celular"])){
                    $celular = $_POST["celular"];
                } 
                if (isset($_POST["telefone"])){
                    $telefone = $_POST["telefone"];
                } 
                $Usuario->setUsuario($usuario);
                $Usuario->setSenha($senha);
                $Usuario->setNome($nome);
                $Usuario->setAtivo($ativo);
                $Usuario->setPerfil($perfil);
                $Usuario->setEmail($email);
                $Usuario->setCelular($celular);
                $Usuario->setTelefone($telefone);
                $usuarioDAO->inserir($Usuario); 
                $msg = "
                            <div class=\"alert alert-success\">
                                <button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>
                                <span class=\"text-success\"><strong>Inserido com sucesso!</strong></span>
                            </div>
                       ";
        } catch (Exception $e) {
            $msg = "
                        <div class=\"alert alert-error\">
                            <button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>
                            <span class=\"text-success\"><strong>" . $e->getMessage() . "</strong></span>
                        </d/*iv>
                   "; 
     }
    }
  }    

  $usuarios = $usuarioDAO->consultarTodos(); 

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
    </head>
    <body>
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="brand" href="index.php">Geoequipe</a>
                    <div class="nav-collapse collapse">
                        <ul class="nav">
                            <li class="active"><a href="index.php">Início</a></li>
                            <li><a href="usuario.php">Cad. de Usuarios</a></li>
                            <li><a href="categoria.php">Cad. de Categoria</a></li>
                            <li><a href="despesa.php">Lançamento de Despesa</a></li>
                            <li><a href="relatorio.php">Relatório</a></li>
                            <li><a href="sair.php">Sair</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <form class="form-horizontal" method="POST" action="usuario.php">
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
                        <input type="text" value="<?php echo $Usuario->getSenha(); ?>" name="senha" id="senha" placeholder="Digite a senha">
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
                            <button type="button" class="btn btn-danger" onclick="if(confirm('Deseja realmente excluir?')) window.location='usuario.php?operacao=D&id=<?php echo $id; ?>'">Excluir</button>;
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </form>
            <br />
            <?php 
            if (sizeof($usuarios) > 0) {
                ?>
                <table class="table table-hover" style="width: 500px">
                    <thead>
                        <tr>
                            <th style="text-align:center">Editar</th>
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
                                <td style="text-align:center"><a href="usuario.php?id=<?php echo $usr->getId(); ?>"><i class="icon-pencil"></i></a></td>
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
        </div>
    </body>
</html>