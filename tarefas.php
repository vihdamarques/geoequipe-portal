<?php    
    include_once 'class/Conexao.php';    
    include_once 'class/Autenticacao.php';
    include_once 'class/Tarefa.php';    
    include_once 'class/TarefaDAO.php';
    include_once 'class/Usuario.php';    
    include_once 'class/UsuarioDAO.php';
    include_once 'class/Local.php';    
    include_once 'class/LocalDAO.php';
    include_once 'class/Movimento.php';    
    include_once 'class/MovimentoDAO.php';

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
    $usuarioDAO = new UsuarioDAO();    
    $localDAO = new LocalDAO();    
    $movimentoDAO = new MovimentoDAO();
    $msg = null;   
    
    //verifica se a variavel id existe no array POST
    if (isset($_POST["id"])){
        $id = $_POST["id"];
    } elseif (isset($_GET["id"])) {
        $id = $auth->decripta($_GET["id"]); //decripta id passado por GET
    } else {
        $id = null;
    }
    
  //paginacao do relatorio
  $pag = (isset($_GET["pag"])) ? $_GET["pag"] : 0;
  $tarefa_pag = 10; //tarefas por página
  $inicio = $pag * $tarefa_pag;
  $total_tarefa = (int) $tarefaDAO->totalTarefas();
  $total_pag = ceil($total_tarefa/$tarefa_pag);  

  $tarefas = $tarefaDAO->consultarTodos($inicio,$tarefa_pag);

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
        <div class="controls">
            <button type="button" class="btn" onclick="window.location='cadastroTarefa.php'">Criar</button>
            <input type="hidden" name="id" id="id" value="" />
        </div>

            <!--Relatório-->
            <?php 
            if (sizeof($tarefas) > 0) {
                ?>
                <table class="table table-hover" style="width: 100%">
                    <thead>
                        <tr>
                            <th style="text-align:center">Editar</th>                            
                            <th>#</th>
                            <th>Descrição</th>
                            <th>Status</th>
                            <th>Data criação</th>                            
                            <th>Local</th>
                            <th>Usuário abertura</th>
                            <th>Detalhes</th>
                            <th>Ação</th>                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($tarefas as $key => $tar) {
                            ?>
                            <tr>
                                <td style="text-align:center"><a href="cadastroTarefa.php?id=<?php echo $auth->encripta($tar->getId()); ?>"><i class="icon-pencil"></i></a></td>
                                <td class="id" style="display:none;"><?php echo $auth->encripta($tar->getId()); ?></td>
                                <td><?php echo $tar->getId();?></td>                                
                                <td><?php echo $tar->getDescricao();?></td>
                                <td><?php $status = $movimentoDAO->consultarUltimoStatus($tar->getId());                                          
                                    switch ($status->getStatus()) {
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
                                    } ?>
                                </td>
                                <td><?php echo strftime("%d/%m/%Y %H:%M:%S", strtotime($tar->getData()));?></td>
                                <td><?php $nome_local = $localDAO->consultarId($tar->getLocal());
                                          echo $nome_local->getNome(); ?>
                                </td>

                                <td><?php $nome_usuario = $usuarioDAO->consultarId($tar->getUsuario());
                                          echo $nome_usuario->getNome(); ?>
                                </td>
                                <td>Detalhes</td>
                                <td>                                    
                                    <select name="acao" class="input-medium">
                                        <option value="0">Selecione</option>
                                        <option value="AG">Agendar</option>
                                        <option value="CA">Cancelar</option>
                                        <option value="CO">Concluir</option>
                                        <option value="AD">Adiar</option>
                                    </select>
                                </td>
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
            <a href="tarefas.php?pag=<?php echo $pag - 1; ?>">&larr; Anterior</a>
          </li>
          <?php 
            } 
            if ($pag < $total_pag){
          ?>
          <li class="next">
            <a href="tarefas.php?pag=<?php echo $pag + 1; ?>"> Próximo &rarr;</a>
          </li>
          <?php
        }
        ?>
        </ul>       
    <!--Selecionar ação-->    
    <script type="text/javascript">
        $(function(){
            $("select[name='acao']").change(function() {
                if ($(this).val() !== "0") {                         
                    var id = $(this).closest('tr').find('.id').text();
                    var acao = $(this).val();                    
                    window.location = "acoes_tarefas.php?id="+id+"&acao="+acao;
                }
            });
        });
    </script>        
    </body>
</html>