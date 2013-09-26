<?php    
    include_once 'class/Conexao.php';    
    include_once 'class/Autenticacao.php';    
    include_once 'class/UsuarioDAO.php';
    include_once 'class/TarefaDAO.php';

    //Conexão
    $conn = new Conexao();

    //Autenticação
    $auth = new Autenticacao($conn);
    $auth->autenticar();
    
    //declara e inicializa as variáveis    
    $usuarioDAO = new UsuarioDAO($conn);    
    $tarefaDAO = new TarefaDAO($conn);
    $tarefas = array();
    
    $usuario = isset($_POST["usuario"]) ? $_POST["usuario"] : "";
    
    if($usuario != ""){
        $tarefas = $tarefaDAO->consultarTodos(0,10,'','',$usuario,'','');    
    }
    
    //destruir conexão
    $conn->__destruct();
?>

    <!--Cabeçalho-->
    <?php include_once 'header.php'; ?>
        <script>
            $(function() {
                $( "#sortable" ).sortable();
                $( "#sortable" ).disableSelection();
            });
        </script>
        <style>
            #sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
            #sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 18px; }
            #sortable li span { position: absolute; margin-left: -1.3em; }
        </style>        

         <form id="formHDistribuicao" class="form-horizontal" method="POST" action="distribuicao.php">
            <legend>Distribuição</legend>                                
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
            <!--Botões-->   
            <div class="control-group">
                <div class="controls">
                    <!--Botão Pesquisar-->
                    <button type="submit" class="btn">Pesquisar</button>                
                </div>
            </div>
        </form>
    
        <ul id="sortable">
            <?php  if(sizeof($tarefas) > 0) {
                    foreach ($tarefas as $key => $value) { ?>
                <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span> <?php echo 'Tarefa: '.$value->getDescricao().' Data Criação: '.$value->getData(); ?> </li>
            <?php   }
                   } ?>
          
          <!--<li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 2</li>
          <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 3</li>
          <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 4</li>
          <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 5</li>
          <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 6</li>
          <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 7</li> -->
        </ul>
    </body>
</html>