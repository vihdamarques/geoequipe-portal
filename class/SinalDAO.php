<?php

    include_once 'class/Conexao.php';
    include_once 'class/Sinal.php';
    include_once 'class/UsuarioDAO.php';
    include_once 'class/EquipamentoDAO.php';

    class SinalDAO {
        private $_conn;

        //construtor
        public function __construct(){
            $this->_conn = new Conexao();           
        }

        //retorna ultimo sinal do usuorio ou todos os usuarios caso passado zero como parametro
        public function consultarPorUsuario($_id_usuario){
            $_vetor = array();

            $stmt = $this->_conn->prepare("SELECT s.* FROM ge_sinal s, ge_usuario u "
                                        . "WHERE s.id_sinal = u.id_ultimo_sinal "
                                        . "AND (u.id_usuario = :id_usuario OR :id_usuario = 0) "
                                        . "ORDER BY s.id_usuario");
            $stmt->bindValue(":id_usuario", $_id_usuario, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll();
            foreach ($result as $key => $linha) {
                $usuarioDAO = new UsuarioDAO();
                $usuario = $usuarioDAO->consultarId($linha["id_usuario"]);
                $equipamentoDAO = new EquipamentoDAO();
                $equipamento = $equipamentoDAO->consultarId($linha["id_equipamento"]);

                $sinal = new Sinal($linha["id_sinal"]
                                  ,$usuario
                                  ,$equipamento
                                  ,$linha["data_sinal"]
                                  ,$linha["data_servidor"]
                                  ,$linha["latitude"]
                                  ,$linha["longitude"]
                                  ,$linha["velocidade"]
                                  ,$linha["logradouro"]
                                  ,$linha["numero"]
                                  ,$linha["bairro"]
                                  ,$linha["cidade"]
                                  ,$linha["estado"]
                                  ,$linha["pais"]
                                  ,$linha["cep"]
                                  );
                $_vetor[$key] = $sinal;                            
            }

            //retorna um array de sinais
            return $_vetor;

            //fecha conexão
            $this->_conn->__destruct();
        }

        // retona um sinal consultando por periodo
        public function consultarPorPeriodo($_id_usuario, $_data_ini, $_data_fim){
            $_vetor = array();

            $stmt = $this->_conn->prepare("SELECT s.* FROM ge_sinal s"
                                        . "WHERE s.id_usuario = :id_usuario "
                                        . "AND s.data_servidor BETWEEN str_to_date(:data_ini,'%d/%m/%Y') AND str_to_date(:data_fim,'%d/%m/%Y') "
                                        . "ORDER BY s.id_sinal");

            $stmt->bindValue(":id_usuario", $_id_usuario, PDO::PARAM_INT);
            $stmt->bindValue(":data_ini", $_id_usuario, PDO::PARAM_STR);
            $stmt->bindValue(":data_fim", $_id_usuario, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll();

            foreach ($result as $key => $linha) {
                $usuarioDAO = new UsuarioDAO();
                $usuario = $usuarioDAO->consultarId($linha["id_usuario"]);
                $equipamentoDAO = new EquipamentoDAO();
                $equipamento = $equipamentoDAO->consultarId($linha["id_equipamento"]);

                $sinal = new Sinal($linha["id_sinal"]
                                  ,$usuario
                                  ,$equipamento
                                  ,$linha["data_sinal"]
                                  ,$linha["data_servidor"]
                                  ,$linha["latitude"]
                                  ,$linha["longitude"]
                                  ,$linha["velocidade"]
                                  ,$linha["logradouro"]
                                  ,$linha["numero"]
                                  ,$linha["bairro"]
                                  ,$linha["cidade"]
                                  ,$linha["estado"]
                                  ,$linha["pais"]
                                  ,$linha["cep"]
                                  );
                $_vetor[$key] = $sinal;                            
            }

            //retorna um array de sinais
            return $_vetor;

            //fecha conexão
            $this->_conn->__destruct();
        }

    }
?>