<?php

    include_once 'class/Usuario.php';
    include_once 'class/Conexao.php';
    include_once 'class/UsuarioDAO.php';

    $usuario = null;
    $nome = null;

    if (isset($_POST["id"])){
        $id = $_POST["id"];
    }else{
        $id = null;
    }

    if (isset($_GET["operacao"])){
        $operacao = $_GET["operacao"];
    }      
    elseif (isset($_POST["operacao"])){
        $operacao = $_POST["operacao"];
    }           
    else{
        $operacao = "";
    }        

    $usuarioDAO = new UsuarioDAO();

    if (!empty($id)) {
        $usuario = $usuarioDAO->consultaId($id);

        if ($operacao == "A") {

            try {
                // atualizar
                $usuario->setNome($_POST["nome"]);
                $usuario->setAtivo($_POST["ativo"]);
                $usuarioDAO->alterar($usuario);
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

            // Deletar
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
        $usuario = new Usuario();
        try {
            if (isset($_POST["nome"])){
                $nome = $_POST["nome"];
            } 
            $usuario->setNome($nome);
            //$usuario->setAtivo($_POST["ativo"]);
            //$id = $usuarioDAO->inserir($usuario);
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
   $usuarios = $usuarioDAO->consultaTodos();

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
                        <!--<?php echo $msg;?>-->
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="usuario">Usuário</label>
                    <div class="controls">
                        <input type="text" value="<?php echo $usuario->getUsuario(); ?>" name="categoria" id="usuario" placeholder="Digite o usuário">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="senha">Senha</label>
                    <div class="controls">
                        <input type="text" value="<?php echo $usuario->getSenha(); ?>" name="categoria" id="senha" placeholder="Digite a senha">
                    </div>    
                </div>
                <div class="control-group">
                    <label class="control-label" for="nome">Nome</label>
                    <div class="controls">
                        <input type="text" value="<?php echo $usuario->getNome(); ?>" name="categoria" id="nome" placeholder="Digite o nome">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="email">Email</label>
                    <div class="controls">
                        <input type="text" value="<?php echo $usuario->getEmail(); ?>" name="categoria" id="email" placeholder="Digite o email">
                    </div>
                </div>
                 <div class="control-group">
                    <label class="control-label" for="celular">Celular</label>
                    <div class="controls">
                        <input type="text" value="<?php echo $usuario->getCelular(); ?>" name="categoria" id="celular" placeholder="Digite o celular">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="telefone">Telefone</label>
                    <div class="controls">
                        <input type="text" value="<?php echo $usuario->getTelefone(); ?>" name="categoria" id="telefone" placeholder="Digite o telefone">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputAtivo">Ativo</label>
                    <div class="controls">
                        <select name="ativo" id="inputAtivo">
                            <option value="S" <?php echo $usuario->getAtivo() == "S" ? "selected=\"selected\"" :  "" ?> >Sim</option>
                            <option value="N" <?php echo $usuario->getAtivo() == "N" ? "selected=\"selected\"" : "" ?> >Não</option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputAtivo">Perfil</label>
                    <div class="controls">
                        <select name="ativo" id="inputAtivo">
                            <option value="E" <?php echo $usuario->getPerfil() == "E" ? "selected=\"selected\"" :  "" ?> >Externo</option>
                            <option value="I" <?php echo $usuario->getPerfil() == "I" ? "selected=\"selected\"" : "" ?> >Interno</option>
                            <option value="G" <?php echo $usuario->getPerfil() == "G" ? "selected=\"selected\"" : "" ?> >Gestor</option>
                        </select>
                    </div>
                </div>
                <input type="hidden" name="operacao" id="operacao" value="<?php echo isset($id) ? "A" : "I"; ?>" />
                <input type="hidden" name="id" id="id" value="<? echo $usuario->getId(); ?>" />
                <div class="control-group">
                    <div class="controls">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                        <button type="button" class="btn" onclick="window.location='usuario'">Cancelar</button>
                        <?php
                        if ($usuario->getId() != null) {
                            ?>
                            <button type="button" class="btn btn-danger" onclick="if(confirm('Deseja realmente excluir?')) window.location='usuario.php?operacao=D&id=<? echo $id; ?>'">Excluir</button>;
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
                                <td style="text-align:center"><a href="$usuario.php?id=<? echo $usr->getId(); ?>"><i class="icon-pencil"></i></a></td>
                                <td><?php echo $usr->getId(); ?></td>
                                <td><?php echo $usr->getNome(); ?></td>
                                <td><?php echo $usr->getUsuario(); ?></td>
                                <td><?php echo $usr->getEmail(); ?></td>
                                <td><?php echo $usr->getCelular(); ?></td>
                                <td><?php echo $usr->getTelefone(); ?></td>
                                <td><?php echo $usr->getPerfil(); ?></td>
                                <td><?php echo $usr->getAtivo(); ?></td>  
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