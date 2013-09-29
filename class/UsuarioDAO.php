<?php

    //include_once 'class/Conexao.php';
    include_once 'class/Usuario.php';

    class UsuarioDAO{
        private $_conn;

        //construtor
        public function __construct($_conn){
              $this->_conn = $_conn;
        }

        //função para INSERT dos dados na tabela ge_usuario
        public function inserir($_usuario){
            try{                
                $this->_conn->beginTransaction();
                $stmt = $this->_conn->prepare("INSERT INTO ge_usuario (  id_usuario
                                                                        ,usuario
                                                                        ,senha
                                                                        ,nome
                                                                        ,email
                                                                        ,celular
                                                                        ,telefone
                                                                        ,ativo
                                                                        ,perfil) 
                                                VALUES ( :id_usuario
                                                        ,:usuario
                                                        ,:senha
                                                        ,:nome
                                                        ,:email
                                                        ,:celular
                                                        ,:telefone
                                                        ,:ativo
                                                        ,:perfil)"
                                            );              
                $stmt->bindValue(":id_usuario", $_usuario->getId());
                $stmt->bindValue(":usuario", $_usuario->getUsuario());
                $stmt->bindValue(":senha", $_usuario->getSenha());
                $stmt->bindValue(":nome", $_usuario->getNome());
                $stmt->bindValue(":email", $_usuario->getEmail());
                $stmt->bindValue(":celular", $_usuario->getCelular());
                $stmt->bindValue(":telefone", $_usuario->getTelefone());
                $stmt->bindValue(":ativo", $_usuario->getAtivo());
                $stmt->bindValue(":perfil", $_usuario->getPerfil());        
                //executa
                $stmt->execute();   
                //commita
                $this->_conn->commit();                 
                //fecha conexão
                //$this->_conn->__destruct();

            }
            catch(PDOException $_e){
                $this->_conn->rollBack();
                echo "Erro: ".$_e->getMessage();
            }
        }

        //função para UPDATE dos dados da tabela ge_usuario
        public function alterar($_usuario){
            try{            
            $this->_conn->beginTransaction();
            $stmt = $this->_conn->prepare("UPDATE ge_usuario
                                           SET usuario = :usuario
                                              ,senha = :senha
                                              ,nome = :nome
                                              ,email = :email
                                              ,celular = :celular
                                              ,telefone = :telefone
                                              ,ativo = :ativo
                                              ,perfil = :perfil
                                           WHERE id_usuario = :id_usuario"
                                        );

                $stmt->bindValue(":usuario", $_usuario->getUsuario());
                $stmt->bindValue(":senha", $_usuario->getSenha());
                $stmt->bindValue(":nome", $_usuario->getNome());
                $stmt->bindValue(":email", $_usuario->getEmail());
                $stmt->bindValue(":celular", $_usuario->getCelular());
                $stmt->bindValue(":telefone", $_usuario->getTelefone());
                $stmt->bindValue(":ativo", $_usuario->getAtivo());
                $stmt->bindValue(":perfil", $_usuario->getPerfil());
                $stmt->bindValue(":id_usuario", $_usuario->getId());
                //executa
                $stmt->execute();   
                //commita
                $this->_conn->commit();
                //fecha conexão
                //$this->_conn->__destruct();             
            }
            catch(PDOException $_e){
                $this->_conn->rollback();
                echo "Erro: ".$_e->getMessage();
            }
        }

        //função para DELETE dos dados da tabela ge_usuario
        public function excluir($_id){
            try{
                $this->_conn->beginTransaction();
                $stmt = $this->_conn->prepare("DELETE FROM ge_usuario WHERE id_usuario = :id");
                $stmt->bindValue(":id", $_id);
                //executa
                $stmt->execute();
                //commita
                $this->_conn->commit();
                //fecha conexao
                //$this->_conn->__destruct();
            } catch(PDOException $_e){
                $this->_conn->rollback();
                echo "Erro: ".$_e->getMessage();
            }
        }

        //retorna o numero total de usuarios na tabela ge_usuario
        public function totalUsuarios(){
            $stmt = $this->_conn->query("SELECT count(*) CONT FROM ge_usuario");
            return $resultado = $stmt->fetch();
        }

        //retorna todos os usuários cadastrados na tabela ge_usuario
        public function consultarTodos($_ini, $_fin){
            $_vetor = array();          

            $stmt = $this->_conn->prepare("SELECT * FROM ge_usuario ORDER BY nome LIMIT :ini,:fin");    
            $stmt->bindValue(":ini", $_ini, PDO::PARAM_INT);
            $stmt->bindValue(":fin", $_fin, PDO::PARAM_INT);                

            $stmt->execute();
            //retornar para cada linha na tabela ge_usuario, um objeto usuario e insere em um array de usuarios                     
            $result = $stmt->fetchAll();
            foreach ($result as $key => $linha){
                $usuario = new Usuario($linha["id_usuario"]
                                      ,$linha["usuario"]
                                      ,$linha["senha"]
                                      ,$linha["nome"]
                                      ,$linha["email"] 
                                      ,$linha["celular"]
                                      ,$linha["telefone"]
                                      ,$linha["ativo"]
                                      ,$linha["id_ultimo_sinal"]
                                      ,$linha["perfil"]);
                $_vetor[$key] = $usuario;                               
            }
            //retorna um array de usuarios
            return $_vetor;
            //fecha conexão
            //$this->_conn->__destruct();
        }

        //retorna um usuario consultando po ID
        public function consultarId($_id){
            $stmt = $this->_conn->prepare("SELECT * FROM ge_usuario WHERE id_usuario = :id");
            $stmt->bindValue(":id", $_id);
            $stmt->execute();
            //retornar para cada usuario no banco, um usuario objeto
            while ($linha = $stmt->fetch()) {
                $usuario = new Usuario($linha["id_usuario"]
                                      ,$linha["usuario"]
                                      ,$linha["senha"]
                                      ,$linha["nome"]
                                      ,$linha["email"]
                                      ,$linha["celular"]
                                      ,$linha["telefone"]
                                      ,$linha["ativo"]
                                      ,$linha["id_ultimo_sinal"]
                                      ,$linha["perfil"]);
            }
            return $usuario;
            //fecha conexão
            //$this->_conn->__destruct();
        }

        //cria uma tag select com todos os usuarios cadastrados
        public function selecionar($id_usuario){
            $_vetor = array();
            $stmt = $this->_conn->prepare("SELECT * FROM ge_usuario WHERE ativo = 'S' ORDER BY nome");
            $stmt->execute();
            //retornar para cada linha na tabela ge_usuario, um objeto usuario e insere em um array de usuarios     
            $result = $stmt->fetchAll();
            foreach ($result as $key => $linha){            
                $usuario = new Usuario($linha["id_usuario"]
                                      ,$linha["usuario"]
                                      ,$linha["senha"]
                                      ,$linha["nome"]
                                      ,$linha["email"] 
                                      ,$linha["celular"]
                                      ,$linha["telefone"]
                                      ,$linha["ativo"]
                                      ,$linha["id_ultimo_sinal"]
                                      ,$linha["perfil"]);
            $_vetor[$key] = $usuario;                               
            }
            $html = "<option value=''>"."Selecione um usuário"."</option>\n";
            foreach ($_vetor as $usuario) {
              $id = $usuario->getId();
              $nome = $usuario->getNome();
              $html .= "<option value=".$id;
              if($id == $id_usuario){ 
                  $html .= " selected";
              }
              $html .= " >".$nome."</option>\n";
            }            
            return $html;
            //fecha conexão
            //$this->_conn->__destruct();
        }

        public function busca($busca, $_ini, $_fin){
            $_vetor = array();
            $stmt = $this->_conn->prepare("SELECT * 
                                           FROM ge_usuario 
                                           WHERE lower(nome) LIKE lower(:busca)
                                              OR lower(usuario) LIKE lower(:busca)
                                              OR lower(email) LIKE lower(:busca)
                                              OR lower(celular) LIKE lower(:busca)
                                              OR lower(telefone) LIKE lower(:busca)                                              
                                           LIMIT :ini,:fin");

            $stmt->bindValue(":busca", '%'.$busca.'%', PDO::PARAM_STR);
            $stmt->bindValue(":ini", $_ini, PDO::PARAM_INT);
            $stmt->bindValue(":fin", $_fin, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetchAll();
            foreach ($result as $key => $linha){
                $usuario = new Usuario($linha["id_usuario"]
                                      ,$linha["usuario"]
                                      ,$linha["senha"]
                                      ,$linha["nome"]
                                      ,$linha["email"] 
                                      ,$linha["celular"]
                                      ,$linha["telefone"]
                                      ,$linha["ativo"]
                                      ,$linha["id_ultimo_sinal"]
                                      ,$linha["perfil"]);
                $_vetor[$key] = $usuario;                               
            }
            //retorna um array de usuarios
            return $_vetor;
        }
    }
?>