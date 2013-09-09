<?php
    class Sinal {

        private $_id;
        private $_id_usuario;
        private $_id_equipamento;
        private $_data_sinal;
        private $_data_servidor;
        private $_latitude;
        private $_longitude;
        private $_velocidade;
        private $_logradouro;
        private $_numero;
        private $_bairro;
        private $_cidade;
        private $_estado;
        private $_pais;
        private $_cep;

        // construtor da classe
        public function __construct($_id             = null
                                   ,$_id_usuario     = null
                                   ,$_id_equipamento = null
                                   ,$_data_sinal     = null
                                   ,$_data_servidor  = null
                                   ,$_latitude       = null
                                   ,$_longitude      = null
                                   ,$_velocidade     = null
                                   ,$_logradouro     = null
                                   ,$_numero         = null
                                   ,$_bairro         = null
                                   ,$_cidade         = null
                                   ,$_estado         = null
                                   ,$_pais           = null
                                   ,$_cep            = null) {

            $this->_id             = $_id;
            $this->_id_usuario     = $_id_usuario;
            $this->_id_equipamento = $_id_equipamento;
            $this->_data_sinal     = $_data_sinal;
            $this->_data_servidor  = $_data_servidor;
            $this->_latitude       = $_latitude;
            $this->_longitude      = $_longitude;
            $this->_velocidade     = $_velocidade;
            $this->_logradouro     = $_logradouro;
            $this->_numero         = $_numero;
            $this->_bairro         = $_bairro;
            $this->_cidade         = $_cidade;
            $this->_estado         = $_estado;
            $this->_pais           = $_pais;
            $this->_cep            = $_cep;
        }

        // destrutor da classe
        public function __destruct() {
            $this->_id             = null;
            $this->_id_usuario     = null;
            $this->_id_equipamento = null;
            $this->_data_sinal     = null;
            $this->_data_servidor  = null;
            $this->_latitude       = null;
            $this->_longitude      = null;
            $this->_velocidade     = null;
            $this->_logradouro     = null;
            $this->_numero         = null;
            $this->_bairro         = null;
            $this->_cidade         = null;
            $this->_estado         = null;
            $this->_pais           = null;
            $this->_cep            = null;
        }

        public function setId($_id){
            $this->_id = $_id;
        }

        public function getId(){
            return $this->_id;
        }

        public function setIdUsuario($_id_usuario){
            $this->_id_usuario = $_id_usuario;
        }

        public function getIdUsuario(){
            return $this->_id_usuario;
        }

        public function setIdEquipamento($_id_equipamento){
            $this->_id_equipamento = $_id_equipamento;
        }

        public function getIdEquipamento(){
            return $this->_id_equipamento;
        }

        public function setDataSinal($_data_sinal){
            $this->_data_sinal = $_data_sinal;
        }

        public function getDataSinal(){
            return $this->_data_sinal;
        }

        public function setDataServidor($_data_servidor){
            $this->_data_servidor = $_data_servidor;
        }

        public function getDataServidor(){
            return $this->_data_servidor;
        }

        public function setLatitude($_latitude){
            $this->_latitude = $_latitude;
        }

        public function getLatitude(){
            return $this->_latitude;
        }

        public function setLongitude($_longitude){
            $this->_longitude = $_longitude;
        }

        public function getLongitude(){
            return $this->_longitude;
        }

        public function setVelocidade($_velocidade){
            $this->_velocidade = $_velocidade;
        }

        public function getVelocidade(){
            return $this->_velocidade;
        }

        public function setLogradouro($_logradouro){
            $this->_logradouro = $_logradouro;
        }

        public function getLogradouro(){
            return $this->_logradouro;
        }

        public function setNumero($_numero){
            $this->_numero = $_numero;
        }

        public function getNumero(){
            return $this->_numero;
        }

        public function setBairro($_bairro){
            $this->_bairro = $_bairro;
        }

        public function getBairro(){
            return $this->_bairro;
        }

        public function setCidade($_cidade){
            $this->_cidade = $_cidade;
        }

        public function getCidade(){
            return $this->_cidade;
        }

        public function setEstado($_estado){
            $this->_estado = $_iestado;
        }

        public function getEstado(){
            return $this->_estado;
        }

        public function setPais($_pais){
            $this->_pais = $_pais;
        }

        public function getPais(){
            return $this->_pais;
        }

        public function setCep($_cep){
            $this->_cep = $_cep;
        }

        public function getCep(){
            return $this->_cep;
        }

        public function getEndereco(){
          return $this->_logradouro . ", " 
               . $this->_numero . ", " 
               . $this->_cidade . " - " 
               . $this->_estado . ", " 
               . $this->_cep . ", " 
               . $this->_pais;
        }

    }
?>