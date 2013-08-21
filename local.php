<?php
    include_once 'class/Local.php';
    include_once 'class/Conexao.php';
    include_once 'class/LocalDAO.php';
    include_once 'class/Autenticacao.php';
    
    //Autenticação
    $auth = new Autenticacao();
    $auth->autenticar();
    
    //declara e inicializa as variáveis
    $id = null;       
    $nome = null;
    $descricao = null;
    $ativo = null;
    $latitude = null;
    $longitude = null;
    $coordenada = null;
    $logradouro = null;
    $numero = null;
    $bairro = null;
    $cidade = null;
    $estado = null;
    $pais = null;
    $cep = null;
    $telefone_1 = null;
    $telefone_2 = null;
    $email = null;
    $Local = new Local();
    $localDAO = new LocalDAO();
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
        $Local = $localDAO->consultarId($id);
        if ($operacao == "A") {        
            try {
                $nome = (isset($_POST["nome"])) ? $_POST["nome"] : "";                
                $descricao = (isset($_POST["descricao"])) ? $_POST["descricao"] : "";
                $ativo = (isset($_POST["ativo"])) ? $_POST["ativo"] : "";
                $latitude = (isset($_POST["latitude"])) ? $_POST["latitude"] : "";
                $longitude = (isset($_POST["longitude"])) ? $_POST["longitude"] : "";
                $coordenada = (isset($_POST["coordenada"])) ? $_POST["coordenada"] : "";
                $logradouro = (isset($_POST["logradouro"])) ? $_POST["logradouro"] : "";
                $numero = (isset($_POST["numero"])) ? $_POST["numero"] : "";
                $bairro = (isset($_POST["bairro"])) ? $_POST["bairro"] : "";                
                $cidade = (isset($_POST["cidade"])) ? $_POST["cidade"] : "";
                $estado = (isset($_POST["estado"])) ? $_POST["estado"] : "";
                $pais = (isset($_POST["pais"])) ? $_POST["pais"] : "";
                $cep = (isset($_POST["cep"])) ? $_POST["cep"] : "";
                $telefone_1 = (isset($_POST["telefone_1"])) ? $_POST["telefone_1"] : "";
                $telefone_2 = (isset($_POST["telefone_2"])) ? $_POST["telefone_2"] : "";
                $email = (isset($_POST["email"])) ? $_POST["email"] : "";
                                
                $Local->setNome($nome);
                $Local->setDescricao($descricao);
                $Local->setAtivo($ativo);
                $Local->setLatitude($latitude);
                $Local->setLongitude($longitude);
                $Local->setCoordenada($coordenada);
                $Local->setLogradouro($logradouro);
                $Local->setNumero($numero);
                $Local->setBairro($bairro);
                $Local->setCidade($cidade);
                $Local->setEstado($estado);
                $Local->setPais($pais);
                $Local->setCep($cep);
                $Local->setTelefone_1($telefone_1);
                $Local->setTelefone_2($telefone_2);      
                $Local->setEmail($email);      
                //atualizar
                $localDAO->alterar($Local);
                $msg = "<div class=\"alert alert-success\">
                            <button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>
                            <span class=\"text-success\"><strong>Atualizado com sucesso!</strong></span>
                        </div>";       
                //destrói objeto
                $Local = null;
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
                $localDAO->excluir($id);
                $msg ="<div class=\"alert alert-error\">
                            <button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>
                            <span class=\"text-error\"><strong>Deletado com sucesso!</strong></span>
                        </div>"; 
                //destrói objeto
                $Local = null;
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
            try {   $nome = (isset($_POST["nome"])) ? $_POST["nome"] : "";                
                    $descricao = (isset($_POST["descricao"])) ? $_POST["descricao"] : "";
                    $ativo = (isset($_POST["ativo"])) ? $_POST["ativo"] : "";
                    $latitude = (isset($_POST["latitude"])) ? $_POST["latitude"] : "";
                    $longitude = (isset($_POST["longitude"])) ? $_POST["longitude"] : "";
                    $coordenada = (isset($_POST["coordenada"])) ? $_POST["coordenada"] : "";
                    $logradouro = (isset($_POST["logradouro"])) ? $_POST["logradouro"] : "";
                    $numero = (isset($_POST["numero"])) ? $_POST["numero"] : "";
                    $bairro = (isset($_POST["bairro"])) ? $_POST["bairro"] : "";                
                    $cidade = (isset($_POST["cidade"])) ? $_POST["cidade"] : "";
                    $estado = (isset($_POST["estado"])) ? $_POST["estado"] : "";
                    $pais = (isset($_POST["pais"])) ? $_POST["pais"] : "";
                    $cep = (isset($_POST["cep"])) ? $_POST["cep"] : "";
                    $telefone_1 = (isset($_POST["telefone_1"])) ? $_POST["telefone_1"] : "";
                    $telefone_2 = (isset($_POST["telefone_2"])) ? $_POST["telefone_2"] : "";
                    $email = (isset($_POST["email"])) ? $_POST["email"] : "";
                                    
                    $Local->setNome($nome);
                    $Local->setDescricao($descricao);
                    $Local->setAtivo($ativo);
                    $Local->setLatitude($latitude);
                    $Local->setLongitude($longitude);
                    $Local->setCoordenada($coordenada);
                    $Local->setLogradouro($logradouro);
                    $Local->setNumero($numero);
                    $Local->setBairro($bairro);
                    $Local->setCidade($cidade);
                    $Local->setEstado($estado);
                    $Local->setPais($pais);
                    $Local->setCep($cep);
                    $Local->setTelefone_1($telefone_1);
                    $Local->setTelefone_2($telefone_2);      
                    $Local->setEmail($email);    
                    //inserir
                    $localDAO->inserir($Local); 
                    $msg = "<div class=\"alert alert-success\">
                                <button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>
                                <span class=\"text-success\"><strong>Inserido com sucesso!</strong></span>
                            </div>"; 
                    //destrói objeto
                    $Local = null;
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
  $local_pag = 10; //usuários por página
  $inicio = $pag * $local_pag;
  $total_local = (int) $localDAO->totalLocal();
  $total_pag = ceil($total_local/$local_pag);  
  $locais = $localDAO->consultarTodos($inicio,$local_pag);

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
            <form id="formUsuario" class="form-horizontal" method="POST" action="local.php">
                <legend>Cadastro de Local <!-- span style="font-size: 10pt">(Todos os campos são obrigatórios)</span--></legend>
                <div class="control-group">
                    <div class="controls">
                        <?php echo $msg;?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="nome">Nome</label>
                    <div class="controls">
                        <input class="input-xlarge" type="text" value="<?php echo ($Local) ? $Local->getNome() : "";?>" name="nome" id="nome" placeholder="Digite o local" maxlength="60">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="descricao">Descrição</label>
                    <div class="controls">                      
                       <textarea name="descricao" id="descricao" placeholder="Digite a descrição do local"><?php echo ($Local) ? $Local->getDescricao() : ""; ?></textarea>    
                    </div>    
                </div>
                <div class="control-group">
                    <label class="control-label" for="logradouro">Logradouro</label>
                    <div class="controls">
                        <input class="input-xlarge" type="text" value="<?php echo ($Local) ? $Local->getLogradouro() : ""; ?>" name="logradouro" id="logradouro" placeholder="Digite o logradouro" maxlength="300">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="numero">Numero</label>
                    <div class="controls">
                        <input class="input-small" type="text" value="<?php echo ($Local) ? $Local->getNumero() : ""; ?>" name="numero" id="numero" placeholder="Digite o nº" maxlength="8">
                    </div>
                </div>
                 <div class="control-group">
                    <label class="control-label" for="bairro">Bairro</label>
                    <div class="controls">
                        <input type="text" value="<?php echo ($Local) ? $Local->getBairro() : ""; ?>" name="bairro" id="bairro" placeholder="Digite o bairro" maxlength="60">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="cidade">Cidade</label>
                    <div class="controls">
                        <input type="text" value="<?php echo ($Local) ? $Local->getCidade() : ""; ?>" name="cidade" id="cidade" placeholder="Digite a cidade" maxlength="60">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="estado">Estado</label>
                    <div class="controls">
                        <input class="input-medium" type="text" value="<?php echo ($Local) ? $Local->getEstado() : ""; ?>" name="estado" id="estado" placeholder="Digite o estado" maxlength="20">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="pais">País</label>
                    <div class="controls">
                        <input class="input-medium" type="text" value="<?php echo ($Local) ? $Local->getPais() : ""; ?>" name="pais" id="pais" placeholder="Digite o país" maxlength="60">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="cep">CEP</label>
                    <div class="controls">
                        <input class="input-small" type="text" value="<?php echo ($Local) ? $Local->getCep() : ""; ?>" name="cep" id="cep" placeholder="Digite o CEP" maxlength="9">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="telefone_1">Telefone 1</label>
                    <div class="controls">
                        <input class="input-medium" type="text" value="<?php echo ($Local) ? $Local->getTelefone_1() : ""; ?>" name="telefone_1" id="telefone_1" placeholder="Digite o telefone 1" maxlength="20">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="telefone_2">Telefone 2</label>
                    <div class="controls">
                        <input class="input-medium" type="text" value="<?php echo ($Local) ? $Local->getTelefone_2() : ""; ?>" name="telefone_2" id="telefone_2" placeholder="Digite o telefone 2" maxlength="20">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="email">Email</label>
                    <div class="controls">
                        <input class="input-xlarge" type="text" value="<?php echo ($Local) ? $Local->getEmail() : ""; ?>" name="email" id="email" placeholder="Digite o email" maxlength="70">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputAtivo">Ativo</label>
                    <div class="controls">
                        <select class="input-small" name="ativo" id="inputAtivo">
                            <option value="S" <?php echo ($Local) ? $Local->getAtivo() == "S" ? "selected=\"selected\"" : "" : ""?> >Sim</option>
                            <option value="N" <?php echo ($Local) ? $Local->getAtivo() == "N" ? "selected=\"selected\"" : "" : ""?> >Não</option>
                        </select>
                    </div>
                </div>                
                <input type="hidden" name="operacao" id="operacao" value="<?php echo empty($id) ? "I" : "A"; ?>" />
                <input type="hidden" name="id" id="id" value="<?php echo ($Local) ? $Local->getId() : ""; ?>" />                
                <div class="control-group">
                    <div class="controls">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                        <button type="button" class="btn" onclick="window.location='local.php'">Cancelar</button>
                        <?php
                        if ($id != null) {
                            ?>
                            <button type="button" class="btn btn-danger" onclick="if(confirm('Deseja realmente excluir?')) window.location='local.php?operacao=D&id=<?php echo $auth->encripta($id); ?>'">Excluir</button>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </form>
            <br />
            <!--Relatório-->
            <?php 
            if (sizeof($locais) > 0) {
                ?>
                <table class="table table-hover" style="width: 100%">
                    <thead>
                        <tr>
                            <th style="text-align:center">Editar</th>
                            <th>#</th>
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th>Endereço</th>                            
                            <th>CEP</th>
                            <th>Telefone 1</th>
                            <th>Telefone 2</th>
                            <th>Email</th>
                            <th>Ativo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($locais as $key => $loc) {
                            ?>
                            <tr>
                                <td style="text-align:center"><a href="local.php?id=<?php echo $auth->encripta($loc->getId()); ?>"><i class="icon-pencil"></i></a></td>
                                <td><?php echo $loc->getId(); ?></td>
                                <td><?php echo $loc->getNome(); ?></td>
                                <td><?php echo $loc->getDescricao(); ?></td>
                                <td><?php echo $loc->getLogradouro().", ".
                                      $loc->getNumero().", ".
                                      $loc->getBairro().", ".
                                      $loc->getCidade()." - ".
                                      $loc->getEstado()." - ".
                                      $loc->getPais(); ?>
                                </td>
                                <td><?php echo $loc->getCep(); ?></td>
                                <td><?php echo $loc->getTelefone_1(); ?></td>
                                <td><?php echo $loc->getTelefone_2(); ?></td>
                                <td><?php echo $loc->getEmail(); ?></td>                                
                                <td><?php  switch ($loc->getAtivo()) {
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
            <a href="local.php?pag=<?php echo $pag - 1; ?>">&larr; Anterior</a>
          </li>
          <?php 
            } 
            if ($pag < $total_pag){
          ?>
          <li class="next">
            <a href="local.php?pag=<?php echo $pag + 1; ?>"> Próximo &rarr;</a>
          </li>
          <?php
        }
        ?>
        </ul>
        </div>
    </body>
</html>