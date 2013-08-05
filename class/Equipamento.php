<?php
	class Equipamento{
		private $_id;
		private $_ultimoSinal;
		private $_descricao;
		private $_imei;
		private $_numero;		
		private $_ativo;		

		//construtor da classe
		public function __construct($_id = null
			                       ,$_ultimoSinal = null
			                       ,$_descricao = null
			                       ,$_imei = null
			                       ,$_numero = null
			                       ,$_ativo = null
			                       	){
			$this->_id = $_id;
			$this->_ultimoSinal = $_ultimoSinal;
			$this->_descricao = $_descricao;
			$this->_imei = $_imei;
			$this->_numero = $_numero;
			$this->_ativo = $_ativo; 			
		}		

		//geters e seters
		public function setId($_id){
			$this->_id = $_id;
		}

		public function getId(){
			return $this->_id;
		}

		public function setUltimoSinal($_ultimoSinal){
			$this->_ultimoSinal = $_ultimoSinal;
		}

		public function getUltimoSinal(){
			return $this->_ultimoSinal;
		}

		public function setDescricao($_descricao){
			$this->_descricao = $_descricao;
		}

		public function getDescricao(){
			return $this->_descricao;
		}

		public function setImei($_imei){
			$this->_imei = $_imei;
		}

		public function getImei(){
			return $this->_imei;
		}

		public function setNumero($_numero){
			$this->_numero = $_numero;
		}

		public function getNumero(){
			return $this->_numero;
		}		

		public function setAtivo($_ativo){
			$this->_ativo = $_ativo;
		}

		public function getAtivo(){
			return $this->_ativo;
		}		
	}
?>