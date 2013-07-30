<?php
	class Usuario{
		private $_id;
		private $_usuario;
		private $_senha;
		private $_nome;
		private $_email;
		private $_celular;
		private $_telefone;
		private $_ativo;
		private $_ultimoSinal;
		private $_perfil;

		//construtor da classe
		public function __construct($_id = null
			                       ,$_usuario = null
			                       ,$_senha = null
			                       ,$_nome = null
			                       ,$_email = null
			                       ,$_celular = null
			                       ,$_telefone = null
			                       ,$_ativo = null
			                       ,$_ultimoSinal = null
			                       ,$_perfil = null){
			$this->_id = $_id;
			$this->_usuario = $_usuario;
			$this->_senha = $_senha;
			$this->_nome = $_nome;
			$this->_email = $_email;
			$this->_celular = $_celular; 
			$this->_telefone = $_telefone;
			$this->_ativo = $_ativo;
			$this->_ultimoSinal = $_ultimoSinal; 
			$this->_perfil = $_perfil;
		}
		//destrutor da classe
		/*(public function __destruct(){
			unset($this->_id);
			unset($this->_usuario);
			unset($this->_senha);
			unset($this->_nome);
			unset($this->_email);
			unset($this->_celular);
			unset($this->_telefone);
			unset($this->_ativo);
			unset($this->_ultimoSinal);
			unset($this->_perfil);
		}*/

		//geters e seters
		public function setId($_id){
			$this->_id = $_id;
		}

		public function getId(){
			return $this->_id;
		}

		public function setUsuario($_usuario){
			$this->_usuario = $_usuario;
		}

		public function getUsuario(){
			return $this->_usuario;
		}

		public function setSenha($_senha){
			$this->_senha = $_senha;
		}

		public function getSenha(){
			return $this->_senha;
		}

		public function setNome($_nome){
			$this->_nome = $_nome;
		}

		public function getNome(){
			return $this->_nome;
		}

		public function setEmail($_email){
			$this->_email = $_email;
		}

		public function getEmail(){
			return $this->_email;
		}		

		public function setCelular($_celular){
			$this->_celular = $_celular;
		}

		public function getCelular(){
			return $this->_celular;
		}		

		public function setTelefone($_telefone){
			$this->_telefone = $_telefone;
		}

		public function getTelefone(){
			return $this->_telefone;
		}		

		public function setAtivo($_ativo){
			$this->_ativo = $_ativo;
		}

		public function getAtivo(){
			return $this->_ativo;
		}

		public function setUltimoSinal($_ultimoSinal){
			$this->_ultimoSinal = $_ultimoSinal;
		}

		public function getUltimoSinal(){
			return $this->_ultimoSinal;
		}					

		public function setPerfil($_perfil){
			$this->_perfil = $_perfil;
		}

		public function getPerfil(){
			return $this->_perfil;
		}		
	}
?>