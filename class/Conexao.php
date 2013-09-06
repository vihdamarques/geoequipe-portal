<?php
	class Conexao extends PDO{
		//private $_dsn = "mysql:host=localhost;port=3306;dbname=geoequipe;";
		private $_dsn = "mysql:host=geoequipe.com.br;port=3306;dbname=blurb372_geoequipe;";
		//private $_user = "root";
		private $_user = "blurb372_ge";
		//private $_password = "";
		private $_password = "geoequipe";
		private $_options = array( PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
		private $_conn = null;

		//construtor - conectar
		public function __construct(){
			try{
					$this->_conn = parent::__construct($this->_dsn, $this->_user, $this->_password, $this->_options);					
					return $this->_conn;
			}
			catch(PDOException $_e){
				echo "Erro: ".$_e->getMessage();
			}
		}

		//destrutor - desconectar
		public function __destruct(){
			$this->_conn = null;			
		}

	}
?>