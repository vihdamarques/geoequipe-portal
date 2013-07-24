<?php
	class UsuarioDAO{
		private $_conn;

		//construtor
		public function __construct(){
			$this->_conn = new Conexao();			
		}

		//função para INSERT dos dados na tabela ge_usuario
		public function inserir($_usuario){
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
				$stmt->bindValue(":usuario", $_usuario->getUsuario());
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
				//return $this->_conn->lastInsertId();
				//fecha conexão
				$this->_conn->__destruct();

			}
			catch(PDOException $_e){
				$this->_conn->rollBack();
				echo "Erro: ".$_e->getMessage();
			}
		}

		//função para UPDATE dos dados da tabela ge_usuario
		public function alterar($_usuario){
			try{			
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
			catch(PDOException $_e){
				$this->_conn->rollback();
				echo "Erro: ".$_e->getMessage();
			}
		}

		//retorna todos os usuários cadastrados na tabela ge_usuario
		public function consultarTodos(){
			$stmt = $this->_conn->query("SELECT * FROM GEOEQUIPE.GE_USUARIO");
			//retornar para cada linha na tabela ge_usuario, um objeto usuario e insere em um array de usuarios
			foreach ($stmt as $key => $value) {
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
				$usuario_array[$key] = $usuario;
			}
			//retorna um array de usuarios
			return $usuario_array;
			//fecha conexão
			$this->_conn->__destruct();
		}

		public function consultarId($_id){
		$stmt = $this->_conn->prepare("SELECT * FROM GEOEQUIPE.GE_USUARIO WHERE ID_USUARIO = :id");

		$stmt->bindValue(":id", $_id);

		$stmt->execute();

		//retornar para cada usuario no banco, um usuario objeto
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$usuario = new Usuario($row["id_usuario"]
								  ,$row["usuario"]
								  ,$row["senha"]
								  ,$row["nome"]
								  ,$row["email"]
								  ,$row["celular"]
								  ,$row["telefone"]
								  ,$row["ativo"]
								  ,$row["id_ultimo_sinal"]
								  ,$row["perfil"]);
			return $usuario;
		}		
		//fecha conexão
		$this->_conn->__destruct();
		}
	}
?>