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
    $id = null;
    $auth = new Autenticacao();
    $auth->autenticar();
    $Tarefa = new Tarefa();
    $tarefaDAO = new TarefaDAO();
    $Movimento = new Movimento();
    $movimentoDAO = new MovimentoDAO();
    $Usuario = new Usuario();
    $usuarioDAO = new UsuarioDAO();
    $Local = new Local();
    $localDAO = new LocalDAO();
    $acao = (isset($_GET["acao"])) ? $_GET["acao"] : "";

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




	        if(!empty($acao)){                        
	            if($acao == "AG"){
	                $Movimento->setTarefa($Tarefa->getId());
	                //$Movimento->setUsuario(/*campo usuario*/);
	                $Movimento->setApontamento((isset($_POST["apontamento"])) ? $_POST["apontamento"] : "");
	                $Movimento->setStatus($acao);
	                $movimentoDAO->inserir($Movimento);
	                $Movimento->setTarefa(null);
	                $Movimento->setUsuario(null);
	                $Movimento->setApontamento(null);
	                $Movimento->setStatus(null);
	                $id = null;
	            } elseif ($acao == "CA") {
	                $Movimento->setTarefa($Tarefa->getId());
	                //$Movimento->setUsuario(/*campo usuario*/);
	                $Movimento->setApontamento((isset($_POST["apontamento"])) ? $_POST["apontamento"] : "");
	                $Movimento->setStatus($acao);
	                $movimentoDAO->inserir($Movimento);
	                $Movimento->setTarefa(null);
	                $Movimento->setUsuario(null);
	                $Movimento->setApontamento(null);
	                $Movimento->setStatus(null);
	                $id = null;
	            } elseif ($acao == "CO") {
	                $Movimento->setTarefa($Tarefa->getId());
	                //$Movimento->setUsuario(/*campo usuario*/);
	                $Movimento->setApontamento((isset($_POST["apontamento"])) ? $_POST["apontamento"] : "");
	                $Movimento->setStatus($acao);
	                $movimentoDAO->inserir($Movimento);
	                $Movimento->setTarefa(null);
	                $Movimento->setUsuario(null);
	                $Movimento->setApontamento(null);
	                $Movimento->setStatus(null);
	                $id = null;
	            } elseif ($acao == "AD") {
	                $Movimento->setTarefa($Tarefa->getId());
	                //$Movimento->setUsuario(/*campo usuario*/);
	                $Movimento->setApontamento((isset($_POST["apontamento"])) ? $_POST["apontamento"] : "");
	                $Movimento->setStatus($acao);
	                $movimentoDAO->inserir($Movimento);
	                $Movimento->setTarefa(null);
	                $Movimento->setUsuario(null);
	                $Movimento->setApontamento(null);
	                $Movimento->setStatus(null);
	                $id = null;
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
            <div class="hero-unit">
            	<div class="container-fluid">
	            	<h3 class="pagination-centered">Dados da Tarefa</h3>
	            	<p><strong>Código:</strong> <?php echo $Tarefa->getId(); ?></p>
	            	<p><strong>Local:</strong>  <?php $Local = $localDAO->consultarId($Tarefa->getLocal()); 
	            	                 echo $Local->getNome(); ?>
	            	</p> 
	            	<p><strong>Descrição da Tarefa:</strong> <?php echo $Tarefa->getDescricao(); ?></p>
	            	<p><strong>Data de abertura:</strong> <?php echo strftime("%d/%m/%Y %H:%M:%S", strtotime($Tarefa->getData())); ?></p>
	            	<p><strong>Usuário Abertura:</strong> <?php $Usuario = $usuarioDAO->consultarId($Tarefa->getUsuario());
	            	                           echo $Usuario->getNome() ?></p>
                    <p><strong>Ação selecionada:</strong> <?php switch ($acao) {
								                                    case "AG":
								                                        echo "Agendamento";
								                                        break;
								                                    case "CA":
								                                        echo "Cancelar";
								                                        break;
								                                    case "CO":
								                                        echo "Concluir";
								                                        break;
								                                    case "AD":
								                                        echo "Adiar";
								                                        break;								                                    
								                                    default:                                        
								                                        break;
								                                }
                    ?></p>
                </div>
            </div>            
        </div>
    </body>
</html>