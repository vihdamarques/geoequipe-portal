<?php

    include_once 'class/Sinal.php';
    //include_once 'class/UsuarioDAO.php';
    //include_once 'class/EquipamentoDAO.php';

    class SinalDAO {
        private $_conn;

        //construtor
        public function __construct($_conn){
            $this->_conn = $_conn;
        }

        //retorna ultimo sinal do usuorio ou todos os usuarios caso passado zero como parametro
        public function consultarPorUsuario($_id_usuario){
            $_vetor = array();

            $stmt = $this->_conn->prepare("SELECT s.* \n"
                                        . "      ,date_format(s.data_sinal, '%d/%m/%Y %H:%i:%S') data_sinal_formatada \n"
                                        . "      ,date_format(s.data_servidor, '%d/%m/%Y %H:%i:%S') data_servidor_formatada \n"
                                        . "      ,u.usuario, u.nome, e.des_equipamento, e.imei, e.numero numero_telefone \n"
                                        . "FROM ge_sinal s, ge_usuario u, ge_equipamento e \n"
                                        . "WHERE s.id_sinal = u.id_ultimo_sinal \n"
                                        . "AND (u.id_usuario = :id_usuario OR :id_usuario = 0) \n"
                                        . "AND s.id_usuario = u.id_usuario \n"
                                        . "AND s.id_equipamento = e.id_equipamento \n"
                                        . "AND u.ativo = 'S'\n"                                               //erico 26/09/2013
                                        . "ORDER BY s.id_usuario");
            $stmt->bindValue(":id_usuario", $_id_usuario, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll();
            foreach ($result as $key => $linha) {
                $usuario = new Usuario($linha["id_usuario"]
                                      ,$linha["usuario"]
                                      ,null
                                      ,$linha["nome"]);

                $equipamento = new Equipamento($linha["id_equipamento"]
                                              ,null
                                              ,$linha["des_equipamento"]
                                              ,$linha["imei"]
                                              ,$linha["numero_telefone"]);

                $sinal = new Sinal($linha["id_sinal"]
                                  ,$usuario
                                  ,$equipamento
                                  ,$linha["data_sinal_formatada"]
                                  ,$linha["data_servidor_formatada"]
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
        }

        //retorna ultimo sinal pelo ID
        public function consultarPorId($_id_sinal){
            $_vetor = array();

            $stmt = $this->_conn->prepare("SELECT s.* \n"
                                        . "      ,date_format(s.data_sinal, '%d/%m/%Y %H:%i:%S') data_sinal_formatada \n"
                                        . "      ,date_format(s.data_servidor, '%d/%m/%Y %H:%i:%S') data_servidor_formatada \n"
                                        . "      ,u.usuario, u.nome, e.des_equipamento, e.imei, e.numero numero_telefone \n"
                                        . "FROM ge_sinal s, ge_usuario u, ge_equipamento e \n"
                                        . "WHERE s.id_sinal = :id_sinal \n"
                                        . "AND s.id_usuario = u.id_usuario \n"
                                        . "AND s.id_equipamento = e.id_equipamento \n"
                                        . "ORDER BY s.id_usuario");
            $stmt->bindValue(":id_sinal", $_id_sinal, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll();
            foreach ($result as $key => $linha) {
                $usuario = new Usuario($linha["id_usuario"]
                                      ,$linha["usuario"]
                                      ,null
                                      ,$linha["nome"]);

                $equipamento = new Equipamento($linha["id_equipamento"]
                                              ,null
                                              ,$linha["des_equipamento"]
                                              ,$linha["imei"]
                                              ,$linha["numero_telefone"]);

                $sinal = new Sinal($linha["id_sinal"]
                                  ,$usuario
                                  ,$equipamento
                                  ,$linha["data_sinal_formatada"]
                                  ,$linha["data_servidor_formatada"]
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
        }

        // retona um sinal consultando por periodo
        public function consultarPorPeriodo($_id_usuario, $_data_ini, $_data_fim){
            $_vetor = array();

            $stmt = $this->_conn->prepare("SELECT s.*, u.usuario, u.nome, e.des_equipamento, e.imei, e.numero numero_telefone \n"
                                        . "FROM ge_sinal s, ge_usuario u, ge_equipamento e \n"
                                        . "WHERE s.id_usuario = :id_usuario \n"
                                        . "  AND s.id_usuario = u.id_usuario \n"
                                        . "  AND s.id_equipamento = e.id_equipamento \n"
                                        . "AND s.data_servidor BETWEEN str_to_date(:data_ini,'%d/%m/%Y %H:%i') \n"
                                        . "                        AND str_to_date(:data_fim,'%d/%m/%Y %H:%i') \n"
                                        . "ORDER BY s.id_sinal \n"
                                        . "LIMIT 0, 99");

            $stmt->bindValue(":id_usuario", $_id_usuario, PDO::PARAM_INT);
            $stmt->bindValue(":data_ini", $_data_ini, PDO::PARAM_STR);
            $stmt->bindValue(":data_fim", $_data_fim, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll();

            foreach ($result as $key => $linha) {
                $usuario = new Usuario($linha["id_usuario"]
                                      ,$linha["usuario"]
                                      ,null
                                      ,$linha["nome"]);

                $equipamento = new Equipamento($linha["id_equipamento"]
                                              ,null
                                              ,$linha["des_equipamento"]
                                              ,$linha["imei"]
                                              ,$linha["numero_telefone"]);

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
        }

    }
?>