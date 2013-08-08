<?php
    include_once 'class/Tarefa.php';
    include_once 'class/Conexao.php';
    include_once 'class/TarefaDAO.php';
    include_once 'class/Autenticacao.php';

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
                $data = (isset($_POST["data"])) ? $_POST["data"] : "";
                $usuario = (isset($_POST["usuario"])) ? $_POST["usuario"] : "";
                
                $Tarefa->setLocal($local);
                $Tarefa->setDescricao($descricao);
                $Tarefa->setData($data);
                $Tarefa->setUsuario($usuario);
                //atualizar
                $tarefaDAO->alterar($Tarefa);
                $msg ="<div class=\"alert alert-success\">
                            <button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>
                            <span class=\"text-success\"><strong>Atualizado com sucesso!</strong></span>
                        </div>";       

                $Tarefa->setLocal(null);
                $Tarefa->setDescricao(null);
                $Tarefa->setData(null);
                $Tarefa->setUsuario(null);                
                $Tarefa->setId(null);
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
                $tarefaDAO->excluir($id);
                $msg ="<div class=\"alert alert-error\">
                            <button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>
                            <span class=\"text-error\"><strong>Deletado com sucesso!</strong></span>
                        </div>"; 
                
                $Equipamento->setNumero(null);
                $Equipamento->setDescricao(null);
                $Equipamento->setImei(null);
                $Equipamento->setAtivo(null);               
                $Equipamento->setId(null);
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
                    $local = (isset($_POST["local"])) ? $_POST["local"] : "";
                    $descricao = (isset($_POST["descricao"])) ? $_POST["descricao"] : "";
                    $data = (isset($_POST["data"])) ? $_POST["data"] : "";
                    $usuario = (isset($_POST["usuario"])) ? $_POST["usuario"] : "";              
                    
                    $Tarefa->setLocal($local);
                    $Tarefa->setDescricao($descricao);
                    $Tarefa->setData($data);
                    $Tarefa->setUsuario($usuario);
                    //inserir
                    $tarefaDAO->inserir($Tarefa); 
                    $msg = "<div class=\"alert alert-success\">
                                <button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>
                                <span class=\"text-success\"><strong>Inserido com sucesso!</strong></span>
                            </div>"; 

                    $Tarefa->setLocal(null);
                    $Tarefa->setDescricao(null);
                    $Tarefa->setData(null);
                    $Tarefa->setUsuario(null);                
                    $Tarefa->setId(null);
                    $id = null;
                    $id = null;
            } catch (Exception $e) {
                    $msg = "<div class=\"alert alert-error\">
                                <button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>
                                <span class=\"text-error\"><strong>" . $e->getMessage() . "</strong></span>
                            </div>"; 
            }
        }
    }      
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
            <form id="formUsuario" class="form-horizontal" method="POST" action="equipamento.php">
                <legend>Cadastro de Tarefas <!-- span style="font-size: 10pt">(Todos os campos são obrigatórios)</span--></legend>
                <div class="control-group">
                    <div class="controls">
                        <?php echo $msg;?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="numero">Código</label>
                    <div class="controls">
                        <input type="text" value="" name="codigo" id="codigo" placeholder="Digite o código">
                    </div>
                </div>    

                <!--local-->
                <div class="control-group">
                    <label class="control-label" for="numero">Local</label>
                    <div class="controls">
                <?php                    
                   include_once 'class/LocalDAO.php';
                   include_once 'class/Local.php';
                   $localDAO = new LocalDAO;
                   echo $localDAO->selecionar();
                ?>
                    </div>
                </div>    

                <div class="control-group">
                    <label class="control-label" for="descricao">Descrição</label>
                    <div class="controls">
                        <input type="text" value="<?php echo $Tarefa->getDescricao();?>" name="descricao" id="descricao" placeholder="Digite a descrição">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="imei">Data Abertura</label>
                    <div class="controls">
                        <input type="text" value="<?php echo $Tarefa->getData(); ?>" name="data" id="data" placeholder="Digite a data de abertura">
                    </div>    
                </div>
                <div class="control-group">
                    <label class="control-label" for="imei">Usuário Abertura</label>
                    <div class="controls">
                        <input type="text" value="<?php echo $Tarefa->getUsuario(); ?>" name="usuario" id="usuario" placeholder="Digite o usuário de abertura">
                    </div>    
                </div>                
                <input type="hidden" name="operacao" id="operacao" value="<?php echo empty($id) ? "I" : "A"; ?>" />
                <input type="hidden" name="id" id="id" value="<?php echo $Tarefa->getId(); ?>" />                
                <div class="control-group">
                    <div class="controls">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                        <button type="button" class="btn" onclick="window.location='cadastroTarefa.php'">Cancelar</button>
                        <?php
                        if ($Tarefa->getId() != null) {
                        ?>
                            <button type="button" class="btn btn-danger" onclick="if(confirm('Deseja realmente excluir?')) window.location='cadastroTarefa.php?operacao=D&id=<?php echo $auth->encripta($id); ?>'">Excluir</button>
                        <?php
                            }
                        ?>
                    </div>
                </div>
            </form>
            <br />
            <!--Relatório-->
            <!--Paginação do Relatório-->            
        </div>
    </body>
</html>