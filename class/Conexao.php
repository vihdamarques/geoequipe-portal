<?php
	class Conexao extends PDO{
		private $_dsn = "mysql:host=localhost;port=3306;dbname=geoequipe";
		private $_user = "root";
		private $_password = "";
		private $_conn = null;

		//construtor - conectar
		public function __construct(){
			try{
					$this->_conn = parent::__construct($this->_dsn, $this->_user, $this->_password);					
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