<?php	
	class Autenticacao{
		private $_conn;
		//construtor
		public function __construct(){
			$this->_conn = new Conexao();						
		}

		public function consultarLogin($usuario, $senha){
			$stmt = $this->_conn->prepare("SELECT * FROM GEOEQUIPE.GE_USUARIO WHERE USUARIO = :usuario AND SENHA = :senha");
			$stmt->bindValue(":usuario", $usuario);
			$stmt->bindValue(":senha", $senha);
			$stmt->execute();
			$resultado = $stmt->fetchAll();
			return $resultado;
		}

		public function consultarId($id){
			$stmt = $this->_conn->prepare("SELECT * FROM GEOEQUIPE.GE_USUARIO WHERE ID_USUARIO = :id");
			$stmt->bindValue(":id", $id);		
			$stmt->execute();
			$resultado = $stmt->fetchAll();
			return $resultado;
		}

		public function login ($usuario, $senha){
			$valida = $this->consultarLogin($usuario, $senha);
			if (count($valida) == 1){
				foreach ($valida as $value) {
					session_start();
					$_SESSION["usuarioID"] = isset($value["id_usuario"]) ? $value["id_usuario"] : "";
        			$_SESSION["usuarioNome"] = isset($value["usuario"]) ? $value["usuario"] : "";	
        			return true;				
				}
				
				} else {
					return false;
				}
			}

		public function autenticar(){
			session_start();
			$usuario_session = $_SESSION["usuarioID"];
			$valida = $this->consultarId($usuario_session);;
			if (count($valida) == 0){
				header("Location: login.php");				
			}
		}

		public function logout(){
			session_start();
			session_unset();
			session_destroy();
		}

		}		
?>