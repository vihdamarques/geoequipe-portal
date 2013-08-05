<?php	
	include_once('class/Usuario.php');
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

					$usuario = new Usuario($value["id_usuario"]
								  ,$value["usuario"]
								  ,$value["senha"]
								  ,$value["nome"]
								  ,$value["email"]
								  ,$value["celular"]
								  ,$value["telefone"]
								  ,$value["ativo"]
								  ,$value["id_ultimo_sinal"]
								  ,$value["perfil"]);
					
					$string = serialize($usuario); //serializa objeto em uma string					
					session_start();
					$_SESSION["usuario"] = $string; //salva a string na sessão
					//$_SESSION["usuarioID"] = isset($value["id_usuario"]) ? $value["id_usuario"] : "";
        			//$_SESSION["usuarioNome"] = isset($value["usuario"]) ? $value["usuario"] : "";	
        			return true;				
				}
				
			} else {
				return false;
			}
			}

		public function autenticar(){
			session_start();
			$string = isset($_SESSION["usuario"]) ? $_SESSION["usuario"]: "" ;
			if ($string == null){
				header("Location: login.php");
			} else {
				$usuario = new Usuario();
				$usuario = unserialize($string);
				$usuario_session_id = $usuario->getId();
				$valida = $this->consultarId($usuario_session_id);;
				if (count($valida) == 0){
					header("Location: login.php");
				}	
			}
			
		}

		public function autenticarCadUsua(){
			//session_start();
			$string = isset($_SESSION["usuario"]) ? $_SESSION["usuario"]: "" ;
			$usuario = new Usuario();
			$usuario = unserialize($string);
			$perfil = $usuario->getPerfil();
			return $perfil;
		}

		public function hashSenha($string){
			$hash = sha1("wnhg9".$string."fwj98");
			return $hash;
		}

		public function encriptaId($string){
			$cod = base64_encode($string);
			return $cod;
		}

		public function decriptaId($string){
			$cod = base64_decode($string);
			//$cod = str_replace("abcde","",$cod);
			return $cod;
		}

		public function logout(){
			session_start();
			session_unset(); //libera as variáveis da sessão
			session_destroy(); //destroí a sessão
		}

		}		
?>