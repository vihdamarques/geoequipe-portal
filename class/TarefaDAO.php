<?php

    include_once 'class/Tarefa.php';
    include_once 'class/Local.php';
    include_once 'class/Usuario.php';
    include_once 'class/Movimento.php';

    class TarefaDAO{
        private $_conn;

        //construtor
        public function __construct($_conn){
            $this->_conn = $_conn;          
        }

        //função para INSERT dos dados na tabela ge_tarefa
        public function inserir($_tarefa){
            try{                
                $this->_conn->beginTransaction();
                $stmt = $this->_conn->prepare("INSERT INTO ge_tarefa ( id_tarefa
                                                                        ,id_local
                                                                        ,id_usuario
                                                                        ,data_criacao                                                                       
                                                                        ,descricao)                                                     

                                                VALUES ( :id_tarefa
                                                        ,:id_local
                                                        ,:id_usuario
                                                        ,now()
                                                        ,:descricao                                                     
                                                        )"
                                            );
                $stmt->bindValue(":id_tarefa", $_tarefa->getId());
                $stmt->bindValue(":id_local", $_tarefa->getLocal());
                $stmt->bindValue(":id_usuario", $_tarefa->getUsuario());                
                $stmt->bindValue(":descricao", $_tarefa->getDescricao());
                //executa
                $stmt->execute();   
                //pega o id inserido
                $lastId = $this->_conn->lastInsertId();     
                //commita
                $this->_conn->commit();
                //retorna id inserido
                return $lastId;
                //fecha conexão             
                //$this->_conn->__destruct();                           
            }
            catch(PDOException $_e){
                $this->_conn->rollBack();
                echo "Erro: ".$_e->getMessage();
            }
        }

        //função para UPDATE dos dados da tabela ge_tarefa
        public function alterar($_tarefa){
            try{            
            $this->_conn->beginTransaction();
            $stmt = $this->_conn->prepare("UPDATE ge_tarefa
                                              SET id_local = :id_local                                                
                                                  ,descricao = :descricao
                                            WHERE id_tarefa = :id_tarefa"
                                        );
            $stmt->bindValue(":id_tarefa", $_tarefa->getId());
            $stmt->bindValue(":id_local", $_tarefa->getLocal());            
            $stmt->bindValue(":descricao", $_tarefa->getDescricao());
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

        //função para DELETE dos dados da tabela ge_tarefa
        public function excluir($_id){
            try{
                $this->_conn->beginTransaction();
                $stmt = $this->_conn->prepare("DELETE FROM ge_tarefa WHERE id_tarefa = :id");
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

        //retorna o numero total de tarefas na tabela ge_tarefa
        public function totalTarefas(){
            $stmt = $this->_conn->query("SELECT count(*) CONT FROM ge_tarefa");
            return $resultado = $stmt->fetch();         
        }

        //retorna todos as tarefas cadastrados na tabela ge_tarefa
        public function consultarTodos($_ini, $_fin, $_status, $_local, $_usuario, $_descricao, $_data_criacao){
            $_vetor = array();
            //$stmt = $this->_conn->prepare("SELECT * FROM ge_tarefa ORDER BY id_tarefa LIMIT :ini,:fin");
            $stmt = $this->_conn->prepare("SELECT t.*                                                 
                                            FROM ge_tarefa       t
                                                ,ge_tarefa_movto m
                                            WHERE t.id_tarefa = m.id_tarefa
                                              AND m.id_tarefa_movto = (SELECT max(id_tarefa_movto) 
                                                                       FROM ge_tarefa_movto 
                                                                       WHERE id_tarefa = t.id_tarefa)
                                              AND ((:status !='' AND m.status = :status) OR :status ='')
                                              AND ((:local !='' AND t.id_local = :local) OR :local ='')
                                              AND ((:usuario !='' AND t.id_usuario = :usuario) OR :usuario ='')
                                              AND ((:descricao !='' AND lower(t.descricao) like lower(:descricao)) OR :descricao ='')
                                              AND ((:usuario !='' AND t.id_usuario = :usuario) OR :usuario ='')
                                              AND ((:data !='' AND date_format(t.data_criacao, '%d/%m/%Y') = :data) OR :data ='')
                                            ORDER BY t.id_tarefa
                                            LIMIT :ini,:fin");

            $stmt->bindValue(":ini", $_ini, PDO::PARAM_INT);
            $stmt->bindValue(":fin", $_fin, PDO::PARAM_INT);
            $stmt->bindValue(":status", $_status, PDO::PARAM_STR);
            $stmt->bindValue(":local", $_local, PDO::PARAM_INT);
            $stmt->bindValue(":usuario", $_usuario, PDO::PARAM_INT);
            $stmt->bindValue(":descricao", '%'.$_descricao.'%', PDO::PARAM_STR);
            $stmt->bindValue(":data", $_data_criacao, PDO::PARAM_STR);
            $stmt->execute();
            //retornar para cada linha na tabela ge_tarefa, um objeto tarefa e insere em um array de tarefa 
            $result = $stmt->fetchAll();
            foreach ($result as $key => $linha){            
                $tarefa = new Tarefa ( $linha["id_tarefa"]
                                      ,$linha["id_local"]
                                      ,$linha["id_usuario"]
                                      ,$linha["descricao"]
                                      ,$linha["data_criacao"]
                                      );
                $_vetor[$key] = $tarefa;                            
            }
            //retorna um array de tarefas
            return $_vetor;
            //fecha conexão
            //$this->_conn->__destruct();
        }

        //retona uma tarefa consultando po ID
        public function consultarId($_id){
        $stmt = $this->_conn->prepare("SELECT * FROM ge_tarefa WHERE id_tarefa = :id");
        $stmt->bindValue(":id", $_id);
        $stmt->execute();
        //retornar para cada tarefa no banco, um objeto tarefa
        while ($linha = $stmt->fetch()) {
            $tarefa = new Tarefa ( $linha["id_tarefa"]
                                  ,$linha["id_local"]
                                  ,$linha["id_usuario"]
                                  ,$linha["descricao"]
                                  ,$linha["data_criacao"]                                     
                                  );
        }           
        return $tarefa;
        //fecha conexão
        //$this->_conn->__destruct();
        }

        //retorna as tarefas para tela de monitoramento
        public function consultarJson($_usuario, $_mostra_conc){
            $_vetor = array();

            $stmt = $this->_conn->prepare("select t.*, l.latitude, l.longitude, l.nome as local "
                                        . ",l.id_local id_local, l.nome nome_local, l.latitude "
                                        . ",l.longitude, l.logradouro, l.numero, l.bairro, l.cidade "
                                        . ",l.estado, l.pais, l.cep, l.telefone_1, l.telefone_2, l.email "
                                        . ",u.nome nome_usuario, u.usuario, m.id_tarefa_movto, date_format(m.data, '%d/%m/%Y') data_movto "
                                        . ",m.apontamento, m.status, m.ordem "
                                        . "from ge_tarefa t, ge_local l, ge_tarefa_movto m, ge_usuario u "
                                        . "where t.id_local  = l.id_local "
                                        . "and t.id_tarefa = m.id_tarefa "
                                        . "and u.id_usuario = t.id_usuario "
                                        . "and m.status = 'G' "
                                        . "and m.data = curdate() "
                                        . "and (:usuario = 0 or m.id_usuario = :usuario) "
                                        . "and (:mostra_conc = 0 or not exists (select 1 from ge_tarefa_movto where id_tarefa = m.id_tarefa and status = 'T')) "
                                        . "and m.id_tarefa_movto = (select max(mm.id_tarefa_movto) from ge_tarefa_movto mm where mm.id_tarefa = m.id_tarefa) "
                                        . "order by m.ordem ");

            $stmt->bindValue(":usuario", $_usuario, PDO::PARAM_INT);
            $stmt->bindValue(":mostra_conc", $_mostra_conc, PDO::PARAM_INT);
            $stmt->execute();
            //retornar para cada linha na tabela ge_tarefa, um objeto tarefa e insere em um array de tarefa
            $result = $stmt->fetchAll();
            foreach ($result as $key => $linha){  
                $tarefa = new Tarefa ( $linha["id_tarefa"]
                                      ,$linha["id_local"]
                                      ,$linha["id_usuario"]
                                      ,$linha["descricao"]
                                      ,$linha["data_criacao"]
                                      );

                $local = new Local($linha["id_local"]
                                  ,$linha["nome_local"]
                                  ,null
                                  ,null
                                  ,$linha["latitude"]
                                  ,$linha["longitude"]
                                  ,null
                                  ,$linha["logradouro"]
                                  ,$linha["numero"]
                                  ,$linha["bairro"]
                                  ,$linha["cidade"]
                                  ,$linha["estado"]
                                  ,$linha["pais"]
                                  ,$linha["cep"]
                                  ,$linha["telefone_1"]
                                  ,$linha["telefone_2"]
                                  ,$linha["email"]);

                $usuario = new Usuario($linha["id_usuario"]
                                      ,$linha["usuario"]
                                      ,null
                                      ,$linha["nome_usuario"]);

                $movimento = new Movimento($linha["id_tarefa_movto"]
                                          ,$linha["id_tarefa"]
                                          ,$linha["id_usuario"]
                                          ,$linha["data_movto"]
                                          ,$linha["apontamento"]
                                          ,$linha["status"]
                                          ,$linha["ordem"]);

                $_vetor[$key] = array("tarefa"    => $tarefa
                                     ,"local"     => $local
                                     ,"usuario"   => $usuario
                                     ,"movimento" => $movimento);
            }
            //retorna um array de tarefas
            return $_vetor;
            //fecha conexão
            //$this->_conn->__destruct();
        }

    }
?>