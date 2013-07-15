<?

    include_once "class/Usuario.php";
    include_once "class/UsuarioDAO.php";

    $id = $_GET["id"];

    if (isset($_GET["operacao"]))
        $operacao = $_GET["operacao"];
    else 
        if (isset($_POST["operacao"]))
            $operacao = $_POST["operacao"];
        else
            $operacao = "";

    $usuarioDAO = new UsuarioDAO();

    if (isset($id)) {
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

        } else if ($operacao == "D") {

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
            $usuario->setNome($_POST["nome"]);
            $usuario->setAtivo($_POST["ativo"]);
            $id = $usuarioDAO->inserir($usuario);
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
                        </div>
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
                    <a class="brand" href="index.php">Controle Financeiro</a>
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
                        <? echo $msg; ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="nome">Nome</label>
                    <div class="controls">
                        <input type="text" value="<? echo $usuario->getNome(); ?>" name="categoria" id="nome" placeholder="Digite o nome">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputAtivo">Ativo ?</label>
                    <div class="controls">
                        <select name="ativo" id="inputAtivo">
                            <option value="S" <? echo $usuario->getAtivo() == "S" ? "selected=\"selected\"" :  "" ?> >Sim</option>
                            <option value="N" <? echo $usuario->getAtivo() == "N" ? "selected=\"selected\"" : "" ?> >Não</option>
                        </select>
                    </div>
                </div>
                <input type="hidden" name="operacao" id="operacao" value="<? echo isset($id) ? "A" : "I"; ?>" />
                <input type="hidden" name="id" id="id" value="<? echo $usuario->getId(); ?>" />
                <div class="control-group">
                    <div class="controls">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                        <button type="button" class="btn" onclick="window.location='usuario'">Cancelar</button>
                        <?
                        if ($usuario->getId() != null) {
                            ?>
                            <button type="button" class="btn btn-danger" onclick="if(confirm('Deseja realmente excluir?')) window.location='usuario.php?operacao=D&id=<? echo $id; ?>'">Excluir</button>;
                            <?
                        }
                        ?>
                    </div>
                </div>
            </form>
            <br />
            <?
            if (count($usuarios) > 0) {
                ?>
                <table class="table table-hover" style="width: 500px">
                    <thead>
                        <tr>
                            <th style="text-align:center">Editar</th>
                            <th>#</th>
                            <th>Nome</th>
                            <th>Ativo ?</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?
                        foreach ($usuarios as $usr) {
                            ?>
                            <tr>
                                <td style="text-align:center"><a href="$usuario.php?id=<? echo $usr->getId(); ?>"><i class="icon-pencil"></i></a></td>
                                <td><? echo $usr->getId(); ?></td>
                                <td><? echo $usr->getNome(); ?></td>
                                <td><? echo $usr->getAtivo() ==  ? "Sim" : "Não"; ?></td>
                            </tr>
                            <?
                        }
                        ?>
                    </tbody>
                </table>
                <?
            }
            ?>
        </div>
    </body>
</html>