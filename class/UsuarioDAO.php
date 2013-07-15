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
				$stmt = $this->_conn->prepare("INSERT INTO usuario ( id
					                								,login
																	,senha
																	,nome
																	,email
																	,celular
																	,telefone
																	,ativo
																	,perfil) 
												VALUES ( :id
														,:login
														,:senha
														,:nome
														,:email
														,:celular
														,:telefone
														,:ativo
														,:perfil)"
											);				
				$stmt->bindValue(":id", $_usuario->getId());
				$stmt->bindValue(":login", $_usuario->getLogin());
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
			}
			catch(PDOException $_e){
				$this->_conn->rollback();
				echo "Erro: ".$_e->getMessage();
			}
		}

		public function listarTudo(){
			$stmt = $this->_conn->query("SELECT * FROM GEOEQUIPE.USUARIO WHERE ID = 6");
			//retornar para cada usuario no banco, um usuario objeto
			foreach ($stmt as $k => $v) {
				$usuario = new Usuario($v["id"], $v["login"], $v["senha"], $v["nome"], $v["email"], $v["celular"], $v["telefone"], $v["ativo"], $v["perfil"], $v["ultimoSinal"]);
				return $usuario;
			}
			return $stmt;
			//fecha conexão
			$this->_conn->__destruct();
		}
	}
?>