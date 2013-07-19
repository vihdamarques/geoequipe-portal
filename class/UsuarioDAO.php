<?php
	class UsuarioDAO{
		private $_conn;

		//construtor
		public function __construct(){
			$this->_conn = new Conexao();			
		}

		//função para INSERT dos dados na tabela usuario
		public function insere($_usuario){
			try{
				$this->_conn->beginTransaction();
				$stmt = $this->_conn->prepare("INSERT INTO GE_USUARIO (  id_usuario
						                								,usuario
																		,senha
																		,nome
																		,email
																		,celular
																		,telefone
																		,ativo
																		,perfil) 
												VALUES ( :id_usuario
														,:usuario
														,:senha
														,:nome
														,:email
														,:celular
														,:telefone
														,:ativo
														,:perfil)"
											);				
				$stmt->bindValue(":id_usuario", $_usuario->getId());
				$stmt->bindValue(":usuario", $_usuario->getLogin());
				$stmt->bindValue(":senha", $_usuario->getSenha());
				$stmt->bindValue(":nome", $_usuario->getNome());
				$stmt->bindValue(":email", $_usuario->getEmail());
				$stmt->bindValue(":celular", $_usuario->getCelular());
				$stmt->bindValue(":telefone", $_usuario->getTelefone());
				$stmt->bindValue(":ativo", $_usuario->getAtivo());
				$stmt->bindValue(":perfil", $_usuario->getPerfil());		
				//executa
				$stmt->execute();	
				//commita
				$this->_conn->commit();
				//fecha conexão
				$this->_conn->__destruct();

				return $_conn::lastInsertId();
			}
			catch(PDOException $_e){
				$this->_conn->rollback();
				echo "Erro: ".$_e->getMessage();
			}
		}

		//função para UPDATE dos dados da tabela usuario
		public function altera($_usuario){
			$this->_conn->beginTransaction();
			$stmt = $this->_conn->prepare("UPDATE GE_USUARIO
										   SET usuario = :usuario
										      ,senha = :senha
										      ,nome = :nome
										      ,email = :email
										      ,celular = :celular
										      ,telefone = :telefone
										      ,ativo = :ativo
										      ,perfil = :perfil
										   WHERE id_usuario = :id_usuario"
										);

				$stmt->bindValue(":usuario", $_usuario->getUsuario());
				$stmt->bindValue(":senha", $_usuario->getSenha());
				$stmt->bindValue(":nome", $_usuario->getNome());
				$stmt->bindValue(":email", $_usuario->getEmail());
				$stmt->bindValue(":celular", $_usuario->getCelular());
				$stmt->bindValue(":telefone", $_usuario->getTelefone());
				$stmt->bindValue(":ativo", $_usuario->getAtivo());
				$stmt->bindValue(":perfil", $_usuario->getPerfil());
				$stmt->bindValue(":id_usuario", $_usuario->getId());
				//executa
				$stmt->execute();	
				//commita
				$this->_conn->commit();
				//fecha conexão
				$this->_conn->__destruct();				
		}

		public function consultaTodos(){
			$stmt = $this->_conn->query("SELECT * FROM GEOEQUIPE.GE_USUARIO");
			//retornar para cada usuario no banco, um usuario objeto
			foreach ($stmt as $k => $v) {
				$usuario = new Usuario($v["id_usuario"], $v["usuario"], $v["senha"], $v["nome"], $v["email"], $v["celular"], $v["telefone"], $v["ativo"], $v["id_ultimo_sinal"], $v["perfil"]);
				$result[$k] = $usuario;
			}
			return $result;
			//fecha conexão
			$this->_conn->__destruct();
		}

		public function consultaId($_id){
		$stmt = $this->_conn->prepare("SELECT * FROM GEOEQUIPE.GE_USUARIO WHERE ID = :id");

		$stmt->bindValue(":id", $_id);

		$stmt->execute();

		//retornar para cada usuario no banco, um usuario objeto
		foreach ($stmt as $k => $v) {
			$usuario = new Usuario($v["id"], $v["usuario"], $v["senha"], $v["nome"], $v["email"], $v["celular"], $v["telefone"], $v["ativo"], $v["perfil"], $v["ultimoSinal"]);
			return $usuario;
		}
		return $stmt;
		//fecha conexão
		$this->_conn->__destruct();
		}
	}
?>