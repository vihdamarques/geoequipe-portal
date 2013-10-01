<?php    
    include_once 'class/Conexao.php';    
    include_once 'class/Autenticacao.php';    
    include_once 'class/UsuarioDAO.php';
    include_once 'class/TarefaDAO.php';
    include_once 'class/MovimentoDAO.php';

    //Conexão
    $conn = new Conexao();

    //Autenticação
    $auth = new Autenticacao($conn);
    $auth->autenticar();
    
    //declaração variáveis    
    $usuarioDAO = new UsuarioDAO($conn);    
    $tarefaDAO = new TarefaDAO($conn);
    $movimentoDAO = new MovimentoDAO($conn);
    $tarefas = array();
    $ordenar = isset($_GET['ordenar']) ? $_GET['ordenar'] : "";
    $ordem = isset($_GET['ordem']) ? $_GET['ordem'] : "";
    $usuario = isset($_POST["usuario"]) ? $_POST["usuario"] : "";
    $msg = null;    

    if($usuario != ""){
        $tarefas = $tarefaDAO->consultarJson($usuario,1); 
    }

    if($ordenar == "S"){        
        foreach (split(",", $auth->decripta($ordem)) as $key => $value) {
            $movimentoDAO->atualizaOrdem($value, $key + 1);

            $msg ="<div class=\"alert alert-success\">
                        <button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>
                        <span class=\"text-success\"><strong>Atualizado com sucesso!</strong></span>
                    </div>"; 
         }
    }  
    //destruir conexão
    $conn->__destruct();
    //include do arquivo cabeçalho da página
    include_once 'header.php';
?>
    <!--Cabeçalho-->
    <script>
        $(function() {
            $( "#sortable" ).sortable({
                axis: "y"                    
            });
        });

        function pegaOrdem(){
            var array = [];
            $('li[name*="li_"]').each(function() {
                array.push($(this).val());                    
            });
            $('#ordem').val(array);
            var ordem = btoa($('#ordem').val());
            window.location='distribuicao.php?ordenar=S&ordem='+ordem;
        }
    </script>
    <style>
        #sortable { list-style-type: none; margin: 0; padding: 0; width: 50%; }
        #sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 14px; height: auto; }
        #sortable li span { position: absolute; margin-left: -1.3em; }
    </style>       
    <div class="container">
        <form id="formDistribuicao" class="form-horizontal" method="POST" action="distribuicao.php">
            <legend>Distribuição</legend>
            <div class="control-group">
                <div class="controls">
                    <?php echo $msg; ?>
                </div>
            </div>                                     
            <!--Usuario-->   
            <div class="control-group">
                <label class="control-label" for="usuario">Usuário</label>
                <div class="controls">
                    <select name="usuario" id="usuario">
                        <?php echo $usuarioDAO->selecionar($usuario); ?>
                    </select>
                </div>
            </div>
            <!--Botões-->   
            <div class="control-group">
                <div class="controls">
                    <!--Botão Pesquisar-->
                    <button type="submit" class="btn">Pesquisar</button>
                    <input type="hidden" id="ordem" />
                    <!--Botão Salvar Ordem-->
                    <button type="button" class="btn btn-primary" onclick="pegaOrdem();">Salvar Ordem</button>
                    <p class="help-block" style="margin-top:10px;">Clique e arraste as tarefas para ordenar</p> 
                </div>
            </div>
        </form>   
        <ul id="sortable">
            <?php if(sizeof($tarefas) > 0 and $usuario != 0) {
                    foreach ($tarefas as $key => $value) { 
            ?>
            <li class="ui-state-default" name="<?php echo 'li_'.$value["movimento"]->getId(); ?>" value="<?php echo $value["movimento"]->getId(); ?>">
                <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>                    
                <?php echo '<b># </b>'.$value["tarefa"]->getId()
                          .' <b>Tarefa: </b>'.$value["tarefa"]->getDescricao()
                          .' <b>em </b>'.$value["local"]->getNome(); 
                ?>                     
            </li>
            <?php   }
                } 
            ?>
        </ul>
    </div>
    </body>
</html>