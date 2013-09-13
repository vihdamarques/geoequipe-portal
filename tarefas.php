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
    $local;
    $usuario;
    $status;
    $descricao;
    $data;
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

    $status = (isset($_POST["status"])) ? $_POST["status"] : '';
    $local = (isset($_POST["local"])) ? $_POST["local"] : '';
    $usuario = (isset($_POST["usuario"])) ? $_POST["usuario"] : '';
    $descricao = (isset($_POST["descricao"])) ? $_POST["descricao"] : '';
    $data = (isset($_POST["data"])) ? $_POST["data"] : '';
    
    //paginacao do relatorio
    $pag = (isset($_GET["pag"])) ? $_GET["pag"] : 0;
    $tarefa_pag = 10; //tarefas por página
    $inicio = $pag * $tarefa_pag;
    $total_tarefa = (int) $tarefaDAO->totalTarefas();
    $total_pag = ceil($total_tarefa/$tarefa_pag);  

    $tarefas = $tarefaDAO->consultarTodos($inicio, $tarefa_pag, $status, $local, $usuario, $descricao, $data);

?>

        <!--Cabeçalho-->
        <?php include_once 'header.php'; ?>
        <!--Formulário-->        
    <div class="container">
        <form id="formTarefas" class="form-horizontal" method="POST" action="tarefas.php">
            <legend>Filtros</legend>
                <button type="button" class="btn" onclick="window.location='cadastroTarefa.php'">Criar</button>
                <input type="hidden" name="id" id="id" value="" />
             <!--Status-->   
            <div class="control-group">
                <label class="control-label" for="status">Status</label>
                <div class="controls">
                    <select class="input-medium" name="status" id="status">
                        <option value=""> Selecionar</option>
                        <option value="A" <?php echo ($status == 'A') ?  'selected' : '' ?> > Aberto</option>
                        <option value="C" <?php echo ($status == 'C') ?  'selected' : '' ?> > Cancelado</option>
                        <option value="G" <?php echo ($status == 'G') ?  'selected' : '' ?> > Agendado</option>
                        <option value="T" <?php echo ($status == 'T') ?  'selected' : '' ?> > Atendido</option>
                        <option value="N" <?php echo ($status == 'N') ?  'selected' : '' ?> > Não Atendido</option>
                    </select>
                </div>
            </div>
             <!--Local-->   
            <div class="control-group">
                <label class="control-label" for="local">Local</label>                
                <div class="controls">
                    <select name="local" id="local">
                        <?php                  
                           echo $localDAO->selecionar($local);
                        ?>
                    </select>
                </div>
            </div>
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
            <!--Descrição-->
            <div class="control-group">
                <label class="control-label" for="descricao">Descrição</label>
                <div class="controls">
                    <input class="input-medium" type="text" name="descricao" id="descricao" placeholder="Descrição" value="<?php echo $descricao; ?>">
                </div>
            </div>
            <!--Data-->
            <div class="control-group">
                <label class="control-label" for="data">Data Criação</label>
                <div class="controls">                    
                    <input type="text" id="data" name="data" class="input-small datepicker" placeholder="dd/mm/yyyy" value="<?php echo $data; ?>">
                </div>
            </div>
        
            <div class="control-group">
                <div class="controls">
                    <!--Botão Submitar-->
                    <button type="submit" class="btn btn-primary">Pesquisar</button>
                    <script type="text/javascript">
                        function limparPesquisa(){
                            $('#status').val('');
                            $('#local').val('');
                            $('#usuario').val('');
                            $('#descricao').val('');
                            $('#data').val('');
                        }
                    </script>
                    <!--Botão Limpar-->
                    <button type="button" class="btn" onclick="limparPesquisa();">Limpar</button>
                </div>
            </div>
        </form>
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
                                <td class="id" style="display:none;"><?php echo $auth->encripta($tar->getId()); ?></td> <!--id criptografado a ser passado po GET-->
                                <td><?php echo $tar->getId();?></td>                                
                                <td><?php echo $tar->getDescricao();?></td>
                                <td><?php $ultimo_status = $movimentoDAO->consultarUltimoStatus($tar->getId());                              
                                    switch ($ultimo_status->getStatus()) {
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
                                <td><?php echo date("d/m/Y H:i:s", strtotime($tar->getData()));?></td>
                                <td><?php $nome_local = $localDAO->consultarId($tar->getLocal());
                                          echo $nome_local->getNome(); ?>
                                </td>

                                <td><?php $nome_usuario = $usuarioDAO->consultarId($tar->getUsuario());
                                          echo $nome_usuario->getNome(); ?>
                                </td>
                                <td>Detalhes</td>
                                <td>                                    
                                    <?php if($ultimo_status->getStatus() == "A" or $ultimo_status->getStatus() == "N") {
                                            echo "<select name=\"acao\" class=\"input-medium\">                                        
                                                      <option value=\"0\">Selecione</option>
                                                      <option value=\"G\">Agendar</option>
                                                      <option value=\"C\">Cancelar</option>
                                                  </select>";    
                                             } elseif ($ultimo_status->getStatus() == "G") {
                                                echo "<select name=\"acao\" class=\"input-medium\"> 
                                                          <option value=\"0\">Selecione</option>
                                                          <option value=\"C\">Cancelar</option>
                                                          <option value=\"T\">Concluir</option>
                                                          <option value=\"N\">Adiar</option>
                                                      </select>";    
                                             } else {
                                                 echo '-';
                                             }                                       
                                    ?>                                                                                
                                   
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>                
                <?php
                } else echo 'Nenhum registro encontrado!';
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
                    $("#modal_iframe").attr("src","acoes_tarefas.php?id="+id+"&acao="+acao);
                    $('#modal').modal();
                }
            });
        });

        $('#modal').on('hidden', function () {
          document.location.reload();
        });

    </script>     
    <script type="text/javascript">
        $(function(){
            $(".datepicker").datepicker({
                language: "pt-BR",
                orientation: "top",
                format: "dd/mm/yyyy",
                autoclose: true                
            });
        });
    </script> 

        <!--Modal-->   
        <div id="modal" class="modal hide fade" style="width: auto; height: auto; margin-left:-325px;">          
            <div class="modal-body">  
                <iframe src="" width="650px" height="370px" id="modal_iframe" frameborder="0"> </iframe>
            </div>  
            <div class="modal-footer">           
                <a href="#" class="btn" data-dismiss="modal">Fechar</a>  
            </div>
        </div>
    </div>
    </body>
</html>