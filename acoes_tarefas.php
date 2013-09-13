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

    $id = null;
    $Tarefa = new Tarefa();
    $tarefaDAO = new TarefaDAO();
    $Movimento = new Movimento();
    $movimentoDAO = new MovimentoDAO();
    $Usuario = new Usuario();
    $usuarioDAO = new UsuarioDAO();
    $Local = new Local();
    $localDAO = new LocalDAO();
    $acaoGET = (isset($_GET["acao"])) ? $_GET["acao"] : "";
    $acaoPOST = (isset($_POST["acao"])) ? $_POST["acao"] : "";
    $msg = null;

    //verifica se a variavel id existe no array POST
    if (isset($_POST["id"])){
        $id = $_POST["id"];
    } elseif (isset($_GET["id"])) {
        $id = $auth->decripta($_GET["id"]); //decripta id passado por GET
    } else {
        $id = null;
    }    

    	//ações
	    if(!empty($id)){
	        $Tarefa = $tarefaDAO->consultarId($id);
	        if(!empty($acaoPOST)){                        
	            if($acaoPOST == "G"){ 
                    //set atributos da movimentação
	                $Movimento->setTarefa($Tarefa->getId());
	                $Movimento->setUsuario((isset($_POST["usuario"])) ? $_POST["usuario"] : "");	               
	                $Movimento->setStatus($acaoPOST);
                    //trata a data para o padrão do banco             
                    $data = implode("-",array_reverse(explode("/",(isset($_POST["data_agendamento"])) ? $_POST["data_agendamento"] : "")));
                    $Movimento->setData($data);
                    $Movimento->setApontamento((isset($_POST["apontamento"])) ? $_POST["apontamento"] : "");
                    //insere movimentação
	                $movimentoDAO->inserir($Movimento); 
                    $Movimento = null;
	                $id = null;
                    $msg ="<div class=\"alert alert-success\">
                            <button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>
                            <span class=\"text-success\"><strong>Agendado com sucesso!</strong></span>
                        </div>";
	            } elseif ($acaoPOST == "C") {
	                $Movimento->setTarefa($Tarefa->getId());	                
                    $Movimento->setUsuario($auth->autenticarCadTarefa());             
	                $Movimento->setStatus($acaoPOST);
                    $Movimento->setApontamento((isset($_POST["apontamento"])) ? $_POST["apontamento"] : "");
	                $movimentoDAO->inserir($Movimento);
                    $Movimento = null;
	                $id = null;
                    $msg ="<div class=\"alert alert-success\">
                            <button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>
                            <span class=\"text-success\"><strong>Cancelado com sucesso!</strong></span>
                        </div>";                    
	            } elseif ($acaoPOST == "T") {
	                $Movimento->setTarefa($Tarefa->getId());
                    //pega usuario agendado para tarefa
                    $usuarioAgendado = $movimentoDAO->usuarioAgendado($Tarefa->getId());
	                $Movimento->setUsuario($usuarioAgendado->getUsuario());
                    $Movimento->setStatus($acaoPOST);
	                $Movimento->setApontamento((isset($_POST["apontamento"])) ? $_POST["apontamento"] : "");	                
	                $movimentoDAO->inserir($Movimento);
                    $Movimento = null;
	                $id = null;
                    $msg ="<div class=\"alert alert-success\">
                            <button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>
                            <span class=\"text-success\"><strong>Concluído com sucesso!</strong></span>
                        </div>";                    
	            } elseif ($acaoPOST == "N") {
	                $Movimento->setTarefa($Tarefa->getId());
	                //pega usuario agendado para tarefa
                    $usuarioAgendado = $movimentoDAO->usuarioAgendado($Tarefa->getId());
                    $Movimento->setUsuario($usuarioAgendado->getUsuario());
                    $Movimento->setStatus($acaoPOST);
	                $Movimento->setApontamento((isset($_POST["apontamento"])) ? $_POST["apontamento"] : "");	                
	                $movimentoDAO->inserir($Movimento);
                    $Movimento = null;
	                $id = null;
                    $msg ="<div class=\"alert alert-success\">
                            <button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>
                            <span class=\"text-success\"><strong>Adiado com sucesso!</strong></span>
                        </div>";                    
	            }
	        }
	    }
 ?>

        <!--Cabeçalho-->
      <!--  <?php //include_once 'header.php'; ?> -->
        <!--relatório-->
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
              padding-top: 0px;
          }
      </style>
      <!-- Scripts -->
      <script src="js/jquery-1.10.2.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
      <script src="js/bootstrap-datepicker.js"></script>
      <script src="js/bootstrap-datepicker.pt-BR.js" charset="UTF-8"></script>      
  </head>
  <body>        
        <div class="container">      
            <!--Formulário-->        
            <form id="formAcao" class="form-horizontal" method="POST" action="acoes_tarefas.php">
                <legend><?php switch ($acaoGET) {
                            case "G":
                                echo "Agendar Tarefa";
                                break;
                            case "C":
                                echo "Cancelar Tarefa";
                                break;
                            case "T":
                                echo "Concluir Tarefa";
                                break;
                            case "N":
                                echo "Adiar Tarefa";
                                break;                                                                
                            default:
                                null;
                                break;
                        } ?> 
                </legend>
                <div class="control-group">
                    <div class="controls">
                        <?php echo $msg;?>
                    </div>
                </div>
                <!--Data Agendamento-->
                <?php if($acaoGET){
                        if($acaoGET == "G") {?>
                <!--Usuario-->
                <div class="control-group">
                    <label class="control-label" for="usuario">Usuário</label>
                    <div class="controls">
                        <select name="usuario" id="usuario">
                            <?php                  
                               echo $usuarioDAO->selecionar();
                            ?>
                        </select>
                    </div>
                </div>
                <!--Data Agendamento-->
                <div class="control-group">
                    <label class="control-label" for="data_agendamento">Data Agendamento</label>
                    <div class="controls">
                        <!--<div class="input-append date">-->
                              <input type="text" id="data_agendamento" name="data_agendamento" class="input-small datepicker" placeholder="dd/mm/yyyy">
                              <!--<span class="add-on"><i class="icon-calendar"></i></span>-->
                        <!--</div>-->
                    </div>
                </div>
                <?php } ?>
                <!--Apontamento-->
                <div class="control-group">
                    <label class="control-label" for="apontamento">
                        <?php switch ($acaoGET) {
                            case "C":
                                echo "Motivo cancelamento";
                                break;
                            case "N":
                                echo "Motivo adiamento";
                                break;                            
                            default:
                                echo "Apontamento";
                                break;
                        }?>
                    </label>
                    <div class="controls">
                        <textarea name="apontamento" id="apontamento" rows="4" placeholder="Digite o apontamento/motivo"></textarea>    
                    </div>
                </div>
                <?php } ?>
                <!--ID-->
                <input type="hidden" name="id" id="id" value="<?php echo $Tarefa->getId(); ?>" />                
                <input type="hidden" name="acao" id="acao" value="<?php echo $acaoGET; ?>" />
                <!--Botões-->
                <div class="control-group">
                    <div class="controls">
                        <!--Botão Submitar-->
                    <?php if($id != null) { ?>
                        <button type="submit" class="btn btn-primary">
                        <?php switch ($acaoGET) {
                            case "G":
                                echo "Agendar";
                                break;
                            case "C":
                                echo "Cancelar";
                                break;
                            case "T":
                                echo "Concluir";
                                break;
                            case "N":
                                echo "Adiar";
                                break;                                                                
                            default:
                                null;
                                break;
                        } ?>                            
                        </button>
                    <?php } ?>
                        <!--Botão Voltar-->
                        <!-- <button type="button" class="btn" onclick="window.location='tarefas.php'">Voltar</button> -->
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
        </div>
      <script type="text/javascript">
        $(function(){
            $(".datepicker").datepicker({
                language: "pt-BR",
                orientation: "top",
                format: "dd/mm/yyyy",
                autoclose: true,
                startDate: new Date()
            });
        });
        </script>   
    </body>
</html>