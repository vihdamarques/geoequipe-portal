<?php    
    include_once 'class/Conexao.php';    
    include_once 'class/Autenticacao.php';    
    include_once 'class/Usuario.php';    
    include_once 'class/UsuarioDAO.php';
    include_once 'class/Equipamento.php';    
    include_once 'class/EquipamentoDAO.php';
    include_once 'class/Sinal.php';    
    include_once 'class/SinalDAO.php';

    //Conexão
    $conn = new Conexao();

    //Autenticação
    $auth = new Autenticacao($conn);
    $auth->autenticar();
    
    //declara e inicializa as variáveis
    $id = null;       
    $usuario;
    $data_inicial;
    $data_final;
    $historico;
    $sinal = new Sinal();
    $usuario = new Usuario();
    $equipamento = new Equipamento();
    $sinalDAO = new SinalDAO($conn);
    $usuarioDAO = new UsuarioDAO($conn);
    $equipamentoDAO = new EquipamentoDAO($conn);
    $msg = null; 
    
    //verifica se a variavel id existe no array POST
    if (isset($_POST["id"])){
        $id = $_POST["id"];
    } elseif (isset($_GET["id"])) {
        $id = $auth->decripta($_GET["id"]); //decripta id passado por GET
    } else {
        $id = null;
    }

    $usuario = isset($_POST["usuario"]) ? $_POST["usuario"] : null;
    $data_inicial = isset($_POST["data_ini"]) ? $_POST["data_ini"] : null;
    $data_final = isset($_POST["data_fin"]) ? $_POST["data_fin"] : null;
    
    //paginacao do relatorio
   /* $pag = (isset($_GET["pag"])) ? $_GET["pag"] : 0;
    $tarefa_pag = 10; //tarefas por página
    $inicio = $pag * $tarefa_pag;
    $total_tarefa = (int) $tarefaDAO->totalTarefas();
    $total_pag = ceil($total_tarefa/$tarefa_pag);  */

    $historico = $sinalDAO->consultarPorPeriodo($usuario, $data_inicial, $data_final);

    //destruir conexão
    $conn->__destruct();
?>

    <!--Cabeçalho-->
    <?php include_once 'header.php'; ?>
    <!--Formulário-->        
    <div class="container">
        <form id="formHistorico" class="form-horizontal" method="POST" action="historico.php">
            <legend>Histórico</legend>                
                <input type="hidden" name="id" id="id" value="" />
             <!--Usuario-->   
            <div class="control-group">
                <label class="control-label" for="usuario">Usuário</label>
                <div class="controls">
                    <select name="usuario" id="usuario">
                        <?php                  
                           echo $usuarioDAO->selecionar($usuario);
                        ?>
                    </select>
                </div>
            </div>
            <!--Data Inicial-->
            <div class="control-group">
                <label class="control-label" for="data_ini">Data Inicial</label>
                <div class="controls">           
                    <div id="data_ini_container" class="input-append date">
                      <input data-format="dd/MM/yyyy hh:mm" type="text" class="input-medium" id="data_ini" name="data_ini" value="<?php echo date("d/m/Y H:i", strtotime("-2 hours")); ?>"></input>
                      <span class="add-on">
                        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                      </span>
                    </div>                           
                </div>
            </div>
            <!--Data Final-->
            <div class="control-group">
                <label class="control-label" for="data_fin">Data Final</label>
                <div class="controls">           
                    <div id="data_fin_container" class="input-append date">
                      <input data-format="dd/MM/yyyy hh:mm" type="text" class="input-medium" id="data_fin" name="data_fin" value="<?php echo date("d/m/Y H:i"); ?>"></input>
                      <span class="add-on">
                        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                      </span>
                    </div>                                            
                </div>
            </div>
            <!--Botões-->   
            <div class="control-group">
                <div class="controls">
                    <!--Botão Pesquisar-->
                    <button type="submit" class="btn">Pesquisar</button>                
                </div>
            </div>
        </form>
            <!--Relatório-->
            <?php 
            if (sizeof($historico) > 0) {
                ?>
                <table class="table table-hover" style="width: 100%">
                    <thead>
                        <tr>
                            <th>Visualizar</th>                    
                            <th>Usuário</th>
                            <th>Equipamento</th>
                            <th>Data</th>
                            <th>Hora</th>                                                        
                            <th>Endereço</th>                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($historico as $key => $linha) {
                            ?>
                            <tr>
                                <td style="text-align:center"><a href="index.php?sinal=<?php echo $linha->getId(); ?>"><i class="icon-search"></i></a></td>
                                <td><?php echo $linha->getUsuario()->getNome(); ?></td>                                
                                <td><?php echo $linha->getEquipamento()->getNumero();?></td>
                                <td><?php echo date("d/m/Y", strtotime($linha->getDataServidor()));?></td>           
                                <td><?php echo date("H:i", strtotime($linha->getDataServidor()));?></td>
                                <td><?php echo $linha->getEndereco();;?></td>                                                                
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>                
                <?php
                }
            ?>       
  
    <script type="text/javascript">
        $('#data_ini_container , #data_fin_container').datetimepicker({
          language: "pt-BR"
         ,pickSeconds: false         
        });            
    </script> 
    </div>    
    </body>
</html>