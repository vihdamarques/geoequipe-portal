<?php
    class Local{
        private $_id;       
        private $_nome;
        private $_descricao;
        private $_ativo;
        private $_latitude;
        private $_longitude;
        private $_coordenada;
        private $_logradouro;
        private $_numero;
        private $_bairro;
        private $_cidade;
        private $_estado;
        private $_pais;
        private $_cep;
        private $_telefone_1;
        private $_telefone_2;
        private $_email;

        //construtor da classe
        public function __construct($_id = null     
                                    ,$_nome = null
                                    ,$_descricao = null
                                    ,$_ativo = null
                                    ,$_latitude = null
                                    ,$_longitude = null
                                    ,$_coordenada = null
                                    ,$_logradouro = null
                                    ,$_numero = null
                                    ,$_bairro = null
                                    ,$_cidade = null
                                    ,$_estado = null
                                    ,$_pais = null
                                    ,$_cep = null
                                    ,$_telefone_1 = null
                                    ,$_telefone_2 = null
                                    ,$_email = null){
            $this->_id = $_id;      
            $this->_nome = $_nome;
            $this->_descricao = $_descricao;
            $this->_ativo = $_ativo;
            $this->_latitude = $_latitude;
            $this->_longitude = $_longitude;
            $this->_coordenada = $_coordenada;
            $this->_logradouro = $_logradouro;
            $this->_numero = $_numero;
            $this->_bairro = $_bairro;
            $this->_cidade = $_cidade;
            $this->_estado = $_estado;
            $this->_pais = $_pais;
            $this->_cep = $_cep;
            $this->_telefone_1 = $_telefone_1;
            $this->_telefone_2 = $_telefone_2;
            $this->_email = $_email;
        }

        //destrutor da classe
        function __destruct(){
            $this->_id = null;
            $this->_nome = null;
            $this->_descricao = null;
            $this->_ativo = null;
            $this->_latitude = null;
            $this->_longitude = null;
            $this->_coordenada = null;
            $this->_logradouro = null;
            $this->_numero = null;
            $this->_bairro = null;
            $this->_cidade = null;
            $this->_estado = null;
            $this->_pais = null;
            $this->_cep = null;
            $this->_telefone_1 = null;
            $this->_telefone_2 = null;
            $this->_email = null;
        }

        //geters e seters
        public function setId($_id){
            $this->_id = $_id;
        }

        public function getId(){
            return $this->_id;
        }

        public function setNome($_nome){
            $this->_nome = $_nome;
        }

        public function getNome(){
            return $this->_nome;
        }

        public function setDescricao($_descricao){
            $this->_descricao = $_descricao;
        }

        public function getDescricao(){
            return $this->_descricao;
        }

        public function setAtivo($_ativo){
            $this->_ativo = $_ativo;
        }

        public function getAtivo(){
            return $this->_ativo;
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

        public function setCoordenada($_coordenada){
            $this->_coordenada = $_coordenada;
        }

        public function getCoordenada(){
            return $this->_coordenada;
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
            $this->_estado = $_estado;
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
        public function setTelefone_1($_telefone_1){
            $this->_telefone_1 = $_telefone_1;
        }

        public function getTelefone_1(){
            return $this->_telefone_1;
        }       
        public function setTelefone_2($_telefone_2){
            $this->_telefone_2 = $_telefone_2;
        }

        public function getTelefone_2(){
            return $this->_telefone_2;
        }       
        public function setEmail($_email){
            $this->_email = $_email;
        }

        public function getEmail(){
            return $this->_email;
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