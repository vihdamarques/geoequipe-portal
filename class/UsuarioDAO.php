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

		//função para DELETE dos dados da tabela ge_usuario
		public function excluir($_id){
			try{
				$this->_conn->beginTransaction();
				$stmt = $this->_conn->prepare("DELETE FROM GE_USUARIO WHERE ID_USUARIO = :id");
				$stmt->bindValue(":id", $_id);
				//executa
				$stmt->execute();
				//commita
				$this->_conn->commit();
				//fecha conexao
				$this->_conn->__destruct();
			} catch(PDOException $_e){
				$this->_conn->rollback();
				echo "Erro: ".$_e->getMessage();
			}
		}

		//retorna o numero total de usuarios na tabela ge_usuario
		public function totalUsuarios(){
			$stmt = $this->_conn->query("SELECT COUNT(*) CONT FROM GE_USUARIO");
			return $resultado = $stmt->fetch();			
		}

		//retorna todos os usuários cadastrados na tabela ge_usuario
		public function consultarTodos($_ini, $_fin, $_busca){
			$_vetor = array();			
			if($_busca == null){
				$stmt = $this->_conn->prepare("SELECT * FROM GE_USUARIO ORDER BY NOME LIMIT :ini,:fin");	
				$stmt->bindValue(":ini", $_ini, PDO::PARAM_INT);
				$stmt->bindValue(":fin", $_fin, PDO::PARAM_INT);				
			} else {
				$stmt = $this->_conn->prepare("SELECT * FROM GE_USUARIO WHERE UPPER(NOME) LIKE UPPER(:busca) ORDER BY NOME LIMIT :ini,:fin");	
				$stmt->bindValue(":ini", $_ini, PDO::PARAM_INT);
				$stmt->bindValue(":fin", $_fin, PDO::PARAM_INT);
				$stmt->bindValue(":busca", "%".addslashes($_busca)."%");			
			}
			$stmt->execute();
			//retornar para cada linha na tabela ge_usuario, um objeto usuario e insere em um array de usuarios						
			$result = $stmt->fetchAll();
			foreach ($result as $key => $linha){
				$usuario = new Usuario($linha["id_usuario"]
					                  ,$linha["usuario"]
					                  ,$linha["senha"]
					                  ,$linha["nome"]
					                  ,$linha["email"] 
					                  ,$linha["celular"]
					                  ,$linha["telefone"]
					                  ,$linha["ativo"]
					                  ,$linha["id_ultimo_sinal"]
					                  ,$linha["perfil"]);
				$_vetor[$key] = $usuario;								
			}
			//retorna um array de usuarios
			return $_vetor;
			//fecha conexão
			$this->_conn->__destruct();
		}

		//retorna um usuario consultando po ID
		public function consultarId($_id){
			$stmt = $this->_conn->prepare("SELECT * FROM GE_USUARIO WHERE ID_USUARIO = :id");
			$stmt->bindValue(":id", $_id);
			$stmt->execute();
			//retornar para cada usuario no banco, um usuario objeto
			while ($linha = $stmt->fetch()) {
				$usuario = new Usuario($linha["id_usuario"]
									  ,$linha["usuario"]
									  ,$linha["senha"]
									  ,$linha["nome"]
									  ,$linha["email"]
									  ,$linha["celular"]
									  ,$linha["telefone"]
									  ,$linha["ativo"]
									  ,$linha["id_ultimo_sinal"]
									  ,$linha["perfil"]);
			}
			return $usuario;
			//fecha conexão
			$this->_conn->__destruct();
		}

		//cria uma tag select com todos os usuarios cadastrados
		public function selecionar(){
			$_vetor = array();			
			$stmt = $this->_conn->prepare("SELECT * FROM GE_USUARIO ORDER BY NOME");
			$stmt->execute();
			//retornar para cada linha na tabela ge_usuario, um objeto usuario e insere em um array de usuarios		
			$result = $stmt->fetchAll();
			foreach ($result as $key => $linha){			
				$usuario = new Usuario($linha["id_usuario"]
				                  ,$linha["usuario"]
				                  ,$linha["senha"]
				                  ,$linha["nome"]
				                  ,$linha["email"] 
				                  ,$linha["celular"]
				                  ,$linha["telefone"]
				                  ,$linha["ativo"]
				                  ,$linha["id_ultimo_sinal"]
				                  ,$linha["perfil"]);
			$_vetor[$key] = $usuario;								
			}
			$html = "<select name='usuario' id='usuario'>\n";
			foreach ($_vetor as $usuario) {				
				$id = $usuario->getId();
				$nome = $usuario->getNome();
				$html .= "<option value=".$id.">".$nome."</option>\n";
			}
			$html .= "</select>\n";	
			return $html;
			//fecha conexão
			$this->_conn->__destruct();
		}

		/*public function busca($nome){
			$stmt = $this->_conn->prepare("SELECT * FROM GE_USUARIO WHERE NOME LIKE '%:nome%'");

			$stmt->bindValue(":nome", $nome);

			$stmt->execute();

			//retornar para cada usuario no banco, um usuario objeto
			while ($linha = $stmt->fetch()) {
				$usuario = new Usuario($linha["id_usuario"]
									  ,$linha["usuario"]
									  ,$linha["senha"]
									  ,$linha["nome"]
									  ,$linha["email"]
									  ,$linha["celular"]
									  ,$linha["telefone"]
									  ,$linha["ativo"]
									  ,$linha["id_ultimo_sinal"]
									  ,$linha["perfil"]);
			}	

			if(count($usuario) > 0){
				return $usuario;
			} else{
				return "Dados não encontrados"
			}
				
			//fecha conexão
			$this->_conn->__destruct();
		}*/

	}
?>