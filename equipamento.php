<?php
    include_once 'class/Equipamento.php';
    include_once 'class/Conexao.php';
    include_once 'class/EquipamentoDAO.php';
    include_once 'class/Autenticacao.php';
    
    //Autenticação
    $auth = new Autenticacao();
    $auth->autenticar();
    
    //declara e inicializa as variáveis
    $id = null;
    $numero = null;
    $descricao = null;
    $imei = null;
    $ativo = null;    
    $Equipamento = new Equipamento();
    $equipamentoDAO = new EquipamentoDAO();
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
        $Equipamento = $equipamentoDAO->consultarId($id);
        if ($operacao == "A") {        
            try {
                $numero = (isset($_POST["numero"])) ? $_POST["numero"] : "";
                $descricao = (isset($_POST["descricao"])) ? $_POST["descricao"] : "";
                $imei = (isset($_POST["imei"])) ? $_POST["imei"] : "";
                $ativo = (isset($_POST["ativo"])) ? $_POST["ativo"] : "";
                
                $Equipamento->setNumero($numero);
                $Equipamento->setDescricao($descricao);
                $Equipamento->setImei($imei);
                $Equipamento->setAtivo($ativo);
                //atualizar
                $equipamentoDAO->alterar($Equipamento);              
                $msg ="<div class=\"alert alert-success\">
                            <button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>
                            <span class=\"text-success\"><strong>Atualizado com sucesso!</strong></span>
                        </div>";       

                $Equipamento->setNumero(null);
                $Equipamento->setDescricao(null);
                $Equipamento->setImei(null);
                $Equipamento->setAtivo(null);
                $Equipamento->setId(null);
                $id = null;
            } catch (Exception $e) {
                $msg = " <div class=\"alert alert-error\">
                            <button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>
                            <span class=\"text-error\"><strong>" . $e->getMessage() . "</strong></span>
                        </div>";
            }

        } elseif ($operacao == "D") {          
            try {
                //deletar
                $equipamentoDAO->excluir($id);
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
                    $numero = (isset($_POST["numero"])) ? $_POST["numero"] : "";                
                    $descricao = (isset($_POST["descricao"])) ? $_POST["descricao"] : "";
                    $imei = (isset($_POST["imei"])) ? $_POST["imei"] : "";
                    $ativo = (isset($_POST["ativo"])) ? $_POST["ativo"] : "";                
                    
                    $Equipamento->setNumero($numero);
                    $Equipamento->setDescricao($descricao);
                    $Equipamento->setImei($imei);
                    $Equipamento->setAtivo($ativo);
                    //inserir
                    $equipamentoDAO->inserir($Equipamento); 
                    $msg = "<div class=\"alert alert-success\">
                                <button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>
                                <span class=\"text-success\"><strong>Inserido com sucesso!</strong></span>
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
    }    
  //paginacao do relatorio  
  $pag = (isset($_GET["pag"])) ? $_GET["pag"] : 0;
  $equipamento_pag = 10; //equipamentos por página
  $inicio = $pag * $equipamento_pag; 
  $total_equipamento = (int) $equipamentoDAO->totalEquipamentos();
  $total_pag = ceil($total_equipamento/$equipamento_pag);  
  $equipamentos = $equipamentoDAO->consultarTodos($inicio,$equipamento_pag);
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
                <legend>Cadastro de Equipamento <!-- span style="font-size: 10pt">(Todos os campos são obrigatórios)</span--></legend>
                <div class="control-group">
                    <div class="controls">
                        <?php echo $msg;?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="numero">Número</label>
                    <div class="controls">
                        <input type="text" value="<?php echo $Equipamento->getNumero(); ?>" name="numero" id="numero" placeholder="Digite o número" maxlength="20">
                    </div>
                </div>    
                <div class="control-group">
                    <label class="control-label" for="descricao">Descrição</label>
                    <div class="controls">
                        <!--<input type="text" value="<?php echo $Equipamento->getDescricao();?>" name="descricao" id="descricao" placeholder="Digite a descrição">-->
                        <textarea name="descricao" id="descricao" placeholder="Digite a descrição do equipamento"><?php echo $Equipamento->getDescricao(); ?></textarea>    
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="imei">IMEI</label>
                    <div class="controls">
                        <input type="text" value="<?php echo $Equipamento->getImei(); ?>" name="imei" id="imei" placeholder="Digite o IMEI"maxlength="25">
                    </div>    
                </div>                        
                <div class="control-group">
                    <label class="control-label" for="inputAtivo">Ativo</label>
                    <div class="controls">
                        <select class="input-small" name="ativo" id="inputAtivo">
                            <option value="S" <?php echo $Equipamento->getAtivo() == "S" ? "selected=\"selected\"" :  "" ?> >Sim</option>
                            <option value="N" <?php echo $Equipamento->getAtivo() == "N" ? "selected=\"selected\"" : "" ?> >Não</option>
                        </select>
                    </div>
                </div>                
                <input type="hidden" name="operacao" id="operacao" value="<?php echo empty($id) ? "I" : "A"; ?>" />
                <input type="hidden" name="id" id="id" value="<?php echo $Equipamento->getId(); ?>" />                
                <div class="control-group">
                    <div class="controls">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                        <button type="button" class="btn" onclick="window.location='equipamento.php'">Cancelar</button>
                        <?php
                        if ($Equipamento->getId() != null) {
                            ?>
                            <button type="button" class="btn btn-danger" onclick="if(confirm('Deseja realmente excluir?')) window.location='equipamento.php?operacao=D&id=<?php echo $auth->encripta($id); ?>'">Excluir</button>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </form>
            <br />
            <!--Relatório-->
            <?php 
            if (sizeof($equipamentos) > 0) {
                ?>
                <table class="table table-hover" style="width: 100%">
                    <thead>
                        <tr>
                            <th style="text-align:center">Editar</th>
                            <th>#</th>
                            <th>Numero</th>
                            <th>Descrição</th>
                            <th>IMEI</th>
                            <th>Ativo</th>                                                
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($equipamentos as $key => $eqp) {
                            ?>
                            <tr>
                                <td style="text-align:center"><a href="equipamento.php?id=<?php echo $auth->encripta($eqp->getId()); ?>"><i class="icon-pencil"></i></a></td>
                                <td><?php echo $eqp->getId(); ?></td>
                                <td><?php echo $eqp->getNumero(); ?></td>
                                <td><?php echo $eqp->getDescricao(); ?></td>
                                <td><?php echo $eqp->getImei(); ?></td>                                                                
                                <td><?php  switch ($eqp->getAtivo()) {
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
            <a href="equipamento.php?pag=<?php echo $pag - 1; ?>">&larr; Anterior</a>
          </li>
          <?php 
            } 
            if ($pag < $total_pag){
          ?>
          <li class="next">
            <a href="equipamento.php?pag=<?php echo $pag + 1; ?>"> Próximo &rarr;</a>
          </li>
          <?php
        }
        ?>
        </ul>
        </div>
    </body>
</html>