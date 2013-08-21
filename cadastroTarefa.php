<?php
    include_once 'class/Conexao.php';
    include_once 'class/Autenticacao.php';
    include_once 'class/Tarefa.php';    
    include_once 'class/TarefaDAO.php';
    include_once 'class/Movimento.php';    
    include_once 'class/MovimentoDAO.php';
    include_once 'class/Usuario.php';    
    include_once 'class/UsuarioDAO.php';
    include_once 'class/LocalDAO.php';
    include_once 'class/Local.php';
   
    //Autenticação
    $auth = new Autenticacao();
    $auth->autenticar();

    //declara e inicializa as variáveis
    $id = null;
    $local = null;
    $usuario = null;
    $descricao = null;
    $data = null;    
    $Tarefa = new Tarefa();
    $tarefaDAO = new TarefaDAO();
    $Movimento = new Movimento();
    $movimentoDAO = new MovimentoDAO();
    $Usuario = new Usuario();
    $usuarioDAO = new UsuarioDAO();
    $localDAO = new LocalDAO; 
    $movimentos = null;
    $msg = null;   

    //verifica se a variavel id existe no array POST
    if (isset($_POST["id"])){
        $id = $_POST["id"];
    } elseif (isset($_GET["id"])) {
        $id = $auth->decripta($_GET["id"]); //decripta id passado por GET
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
        $Tarefa = $tarefaDAO->consultarId($id);        
        if ($operacao == "A") {
            try {
                $local = (isset($_POST["local"])) ? $_POST["local"] : "";
                $descricao = (isset($_POST["descricao"])) ? $_POST["descricao"] : "";                
                //atualizar tarefa
                $Tarefa->setLocal($local); 
                $Tarefa->setDescricao($descricao);                                
                $tarefaDAO->alterar($Tarefa);
                //inserir movimento
                //$Movimento->setTarefa($id);
                //$Movimento->setUsuario($usuario);                
                //$movimentoDAO->inserir($Movimento);

                $msg ="<div class=\"alert alert-success\">
                            <button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>
                            <span class=\"text-success\"><strong>Atualizado com sucesso!</strong></span>
                        </div>";       
                
                $Tarefa->setLocal(null);
                $Tarefa->setDescricao(null);                    
                $Tarefa->setUsuario(null);                
                $Tarefa->setId(null);
                $Tarefa->setData(null);
                //$Movimento->setTarefa(null);
                //$Movimento->setUsuario(null);
                //$Movimento->setStatus(null);
                $id = null;
            } catch (Exception $e) {
                $msg = "<div class=\"alert alert-error\">
                            <button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>
                            <span class=\"text-error\"><strong>" . $e->getMessage() . "</strong></span>
                        </div>";
            }

        } //deleta tarefa retirado
    } else {       
        if ($operacao == "I") {
            try {   
                    $local = (isset($_POST["local"])) ? $_POST["local"] : "";
                    $descricao = (isset($_POST["descricao"])) ? $_POST["descricao"] : "";                    
                    //pegar usuario da sessão
                    $usuario = $auth->autenticarCadTarefa();
                    //inserir tarefa
                    $Tarefa->setLocal($local); 
                    $Tarefa->setDescricao($descricao);                    
                    $Tarefa->setUsuario($usuario);                    
                    $idTarefa = $tarefaDAO->inserir($Tarefa); //retorna id da tarefa inserida
                    //inserir movimento
                    $Movimento->setTarefa($idTarefa);
                    $Movimento->setUsuario($usuario);                           
                    $Movimento->setStatus("A");                                                        
                    $movimentoDAO->inserir($Movimento);

                    $msg = "<div class=\"alert alert-success\">
                                <button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>
                                <span class=\"text-success\"><strong>Inserido com sucesso!</strong></span>
                            </div>"; 

                    $Tarefa->setLocal(null);
                    $Tarefa->setDescricao(null);                    
                    $Tarefa->setUsuario(null);                
                    $Tarefa->setId(null);
                    $Movimento->setTarefa(null);
                    $Movimento->setUsuario(null);
                    $Movimento->setStatus(null);
                    $id = null;
            } catch (Exception $e) {
                    $msg = "<div class=\"alert alert-error\">
                                <button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>
                                <span class=\"text-error\"><strong>" . $e->getMessage() . "</strong></span>
                            </div>"; 
            }
        }
    }    

    $movimentos = $movimentoDAO->consultarTodos($id);
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
        <!--Cabeçalho-->
        <?php include_once 'header.php'; ?>
        <!--Formulário-->
        <div class="container">
            <form id="formTarefa" class="form-horizontal" method="POST" action="cadastroTarefa.php">
                <legend>Cadastro de Tarefas <!-- span style="font-size: 10pt">(Todos os campos são obrigatórios)</span--></legend>
                <div class="control-group">
                    <div class="controls">
                        <?php echo $msg;?>
                    </div>
                </div>
                <!--Código-->
                <?php if ($Tarefa->getId() != null){ ?>
                <div class="control-group">
                    <label class="control-label" for="codigo">Código</label>
                    <div class="controls">
                        <input class="input-mini" type="text" value="<?php echo $Tarefa->getId();?>" name="codigo" id="codigo" readonly="true" placeholder="Digite o código">
                    </div>
                </div>    
                <?php } ?>
                <!--Local-->
                <div class="control-group">
                    <label class="control-label" for="local">Local</label>
                    <div class="controls">
                        <select name="local" id="local">
                            <?php                  
                               echo $localDAO->selecionar($Tarefa->getLocal());
                            ?>
                        </select>
                    </div>
                </div>
                <!--Descrição-->
                <div class="control-group">
                    <label class="control-label" for="descricao">Descrição da tarefa</label>
                    <div class="controls">
                        <textarea name="descricao" id="descricao" placeholder="Digite a descrição da tarefa"><?php echo $Tarefa->getDescricao(); ?></textarea>    
                    </div>
                </div>
                <!--Data Abertura-->
                <?php if ($Tarefa->getData() != null){ ?>
                <div class="control-group">
                    <label class="control-label" for="data">Data abertura</label>
                    <div class="controls">
                        <input type="text" value="<?php echo strftime("%d/%m/%Y %H:%M:%S", strtotime($Tarefa->getData())); ?>" name="data" id="data" placeholder="Digite a data de abertura" readonly="true">
                    </div>    
                </div>
                <?php } ?>                                        
                <!--Usuario-->
                <input type="hidden" value="<?php echo $Tarefa->getUsuario(); ?>" name="usuario" id="usuario" />           
                <!--Operação-->
                <input type="hidden" name="operacao" id="operacao" value="<?php echo empty($id) ? "I" : "A"; ?>" />
                <!--ID-->
                <input type="hidden" name="id" id="id" value="<?php echo $Tarefa->getId(); ?>" />                
                <div class="control-group">
                    <div class="controls">
                        <!--Botão Submitar-->
                        <button type="submit" class="btn btn-primary">Salvar</button>
                        <!--Botão Cancelar-->
                        <button type="button" class="btn" onclick="window.location='tarefas.php'">Cancelar</button>
                        <?php
                        if ($Tarefa->getId() != null) {
                        ?>  <!--Botão Delete-->
                            <!--<button type="button" class="btn btn-danger" onclick="if(confirm('Deseja realmente excluir?')) window.location='cadastroTarefa.php?operacao=D&id=<?php echo $auth->encripta($id); ?>'">Excluir</button>-->
                        <?php
                            }
                        ?>
                    </div>
                </div>
            </form>
            <br />
            <!--Relatório-->
            <?php 
            if (sizeof($movimentos) > 0) {
                ?>
                <table class="table table-hover" style="width: 100%">
                    <thead>
                        <tr>                                                    
                            <th>Status</th>
                            <th>Data</th>
                            <th>Usuario</th>                            
                            <th>Apontamento</th>                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($movimentos as $key => $mov) {
                            ?>
                            <tr>                            
                                <td><?php switch ($mov->getStatus()) {
                                    case "A":
                                        echo "Aberto";
                                        break;
                                    case "C":
                                        echo "Cancelado";
                                        break;
                                    case "G":
                                        echo "Agendado";
                                        break;
                                    case "T":
                                        echo "Atendido";
                                        break;
                                    case "N":
                                        echo "Não Atendido";
                                        break;                                                                                                                                                            
                                    default:                                        
                                        break;
                                }  ?></td>
                                <td><?php echo strftime("%d/%m/%Y %H:%M:%S", strtotime($mov->getData())); ?></td>                                
                                <td><?php $nome_usuario = $usuarioDAO->consultarId($mov->getUsuario());
                                          echo $nome_usuario->getNome(); ?>
                                </td>
                                <td><?php echo $mov->getApontamento(); ?></td>                                
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
        </div>
    </body>
</html>