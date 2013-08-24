<?php
	class Movimento{
		private $_id;
		private $_tarefa;
		private $_usuario;
		private $_data;
		private $_apontamento;
		private $_status;
		private $_ordem;
		
		//construtor da classe
		public function __construct( $_id = null
									,$_tarefa = null
									,$_usuario = null
									,$_data = null
									,$_apontamento = null
									,$_status = null
									,$_ordem = null
			                       	){
			$this->_id = $_id;
			$this->_tarefa = $_tarefa;
			$this->_usuario = $_usuario;
			$this->_data = $_data;
			$this->_apontamento = $_apontamento;
			$this->_status = $_status;
			$this->_ordem = $_ordem;
		}				

		//destrutor da classe
		public function __destruct(){
			$this->_id = null;
			$this->_tarefa = null;
			$this->_usuario = null;
			$this->_data = null;
			$this->_apontamento = null;
			$this->_status = null;
			$this->_ordem = null;
		}

		//geters e seters
		public function setId($_id){
			$this->_id = $_id;
		}

		public function getId(){
			return $this->_id;
		}

		public function setTarefa($_tarefa){
			$this->_tarefa = $_tarefa;
		}

		public function getTarefa(){
			return $this->_tarefa;
		}

		public function setUsuario($_usuario){
			$this->_usuario = $_usuario;
		}

		public function getUsuario(){
			return $this->_usuario;
		}

		public function setData($_data_criacao){
			$this->_data = $_data_criacao;
		}

		public function getData(){
			return $this->_data;
		}

		public function setApontamento($_apontamento){
			$this->_apontamento = $_apontamento;
		}

		public function getApontamento(){
			return $this->_apontamento;
		}

		public function setStatus($_status){
			$this->_status = $_status;
		}

		public function getStatus(){
			return $this->_status;
		}

		public function setOrdem($_ordem){
			$this->_ordem = $_ordem;
		}

		public function getOrdem(){
			return $this->_ordem;
		}
	}
?>