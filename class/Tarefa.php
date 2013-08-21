<?php
	class Tarefa{
		private $_id;
		private $_local;
		private $_usuario;
		private $_descricao;
		private $_data_criacao;

		//construtor da classe
		public function __construct($_id = null
			                       ,$_local = null
			                       ,$_usuario = null
			                       ,$_descricao = null
			                       ,$_data_criacao = null		                       
			                       	){
			$this->_id = $_id;
			$this->_local = $_local;
			$this->_usuario = $_usuario;
			$this->_descricao = $_descricao;			
			$this->_data_criacao = $_data_criacao;
		}		

		//destrutos da classe
		public function __destruct(){
			$this->_id = null;
			$this->_local = null;
			$this->_usuario = null;
			$this->_descricao = null;
			$this->_data_criacao = null;
		}

		//geters e seters
		public function setId($_id){
			$this->_id = $_id;
		}

		public function getId(){
			return $this->_id;
		}

		public function setLocal($_local){
			$this->_local = $_local;
		}

		public function getLocal(){
			return $this->_local;
		}

		public function setUsuario($_usuario){
			$this->_usuario = $_usuario;
		}

		public function getUsuario(){
			return $this->_usuario;
		}

		public function setDescricao($_descricao){
			$this->_descricao = $_descricao;
		}

		public function getDescricao(){
			return $this->_descricao;
		}

		public function setData($_data_criacao){
			$this->_data_criacao = $_data_criacao;
		}

		public function getData(){
			return $this->_data_criacao;
		}
	}
?>