<?php
	class LocalDAO{
		private $_conn;

		//construtor
		public function __construct(){
			$this->_conn = new Conexao();			
		}

		//função para INSERT dos dados na tabela ge_usuario
		public function inserir($_local){
			try{				
				$this->_conn->beginTransaction();
				$stmt = $this->_conn->prepare("INSERT INTO GE_LOCAL(id_local		
																	,nome
																	,descricao
																	,ativo
																	,latitude
																	,longitude
																	,coordenada
																	,logradouro
																	,numero
																	,bairro
																	,cidade
																	,estado
																	,pais
																	,cep
																	,telefone_1
																	,telefone_2
																	,email) 
												VALUES (:id_local		
														,:nome
														,:descricao
														,:ativo
														,:latitude
														,:longitude
														,:coordenada
														,:logradouro
														,:numero
														,:bairro
														,:cidade
														,:estado
														,:pais
														,:cep
														,:telefone_1
														,:telefone_2
														,:email)"
											);				
				$stmt->bindValue(":id_local", $_local->getId());
				$stmt->bindValue(":nome", $_local->getNome());
				$stmt->bindValue(":descricao", $_local->getDescricao());
				$stmt->bindValue(":ativo", $_local->getAtivo());
				$stmt->bindValue(":latitude", $_local->getLatitude());
				$stmt->bindValue(":longitude", $_local->getLongitude());
				$stmt->bindValue(":coordenada", $_local->getCoordenada());
				$stmt->bindValue(":logradouro", $_local->getLogradouro());
				$stmt->bindValue(":numero", $_local->getNumero());		
				$stmt->bindValue(":bairro", $_local->getBairro());
				$stmt->bindValue(":cidade", $_local->getCidade());
				$stmt->bindValue(":estado", $_local->getEstado());
				$stmt->bindValue(":pais", $_local->getPais());
				$stmt->bindValue(":cep", $_local->getCep());
				$stmt->bindValue(":telefone_1", $_local->getTelefone_1());
				$stmt->bindValue(":telefone_2", $_local->getTelefone_2());
				$stmt->bindValue(":email", $_local->getEmail());				
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
		public function alterar($_local){
			try{			
			$this->_conn->beginTransaction();
			$stmt = $this->_conn->prepare("UPDATE GE_LOCAL
										      SET nome = :nome
												  ,descricao = :descricao
												  ,ativo = :ativo
												  ,latitude = :latitude
												  ,longitude = :longitude
												  ,coordenada = :coordenada
												  ,logradouro = :logradouro
												  ,numero = :numero
												  ,bairro = :bairro
												  ,cidade = :cidade
												  ,estado = :estado
												  ,pais = :pais
												  ,cep = :cep
												  ,telefone_1 = :telefone_1
												  ,telefone_2 = :telefone_2
												  ,email = :email
										    WHERE id_local = :id_local"
										);
				
				$stmt->bindValue(":id_local", $_local->getId());
				$stmt->bindValue(":nome", $_local->getNome());
				$stmt->bindValue(":descricao", $_local->getDescricao());
				$stmt->bindValue(":ativo", $_local->getAtivo());
				$stmt->bindValue(":latitude", $_local->getLatitude());
				$stmt->bindValue(":longitude", $_local->getLongitude());
				$stmt->bindValue(":coordenada", $_local->getCoordenada());
				$stmt->bindValue(":logradouro", $_local->getLogradouro());
				$stmt->bindValue(":numero", $_local->getNumero());		
				$stmt->bindValue(":bairro", $_local->getBairro());
				$stmt->bindValue(":cidade", $_local->getCidade());
				$stmt->bindValue(":estado", $_local->getEstado());
				$stmt->bindValue(":pais", $_local->getPais());
				$stmt->bindValue(":cep", $_local->getCep());
				$stmt->bindValue(":telefone_1", $_local->getTelefone_1());
				$stmt->bindValue(":telefone_2", $_local->getTelefone_2());
				$stmt->bindValue(":email", $_local->getEmail());				
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

		public function excluir($_id){
			try{
				$this->_conn->beginTransaction();
				$stmt = $this->_conn->prepare("DELETE FROM GE_LOCAL WHERE ID_LOCAL = :id");
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
		public function totalLocal(){
			$stmt = $this->_conn->query("SELECT COUNT(*) CONT FROM GE_LOCAL");
			return $resultado = $stmt->fetch();			
		}

		//retorna todos os usuários cadastrados na tabela ge_usuario
		public function consultarTodos($_ini, $_fin){
			$_vetor = array();
			$stmt = $this->_conn->prepare("SELECT * FROM GE_LOCAL ORDER BY NOME LIMIT :ini,:fin");
			$stmt->bindValue(":ini", $_ini, PDO::PARAM_INT);
			$stmt->bindValue(":fin", $_fin, PDO::PARAM_INT);
			$stmt->execute();
			//retornar para cada linha na tabela ge_usuario, um objeto usuario e insere em um array de usuarios						
			$result = $stmt->fetchAll();
			foreach ($result as $key => $linha){			
				$local = new Local($linha["id_local"]
				                  ,$linha["nome"]
				                  ,$linha["descricao"]
				                  ,$linha["ativo"]
				                  ,$linha["latitude"] 
				                  ,$linha["longitude"]
				                  ,$linha["coordenada"]
				                  ,$linha["logradouro"]
				                  ,$linha["numero"]
				                  ,$linha["bairro"]
				                  ,$linha["cidade"]
				                  ,$linha["estado"]
				                  ,$linha["pais"]
				                  ,$linha["cep"]
				                  ,$linha["telefone_1"]
				                  ,$linha["telefone_2"]
				                  ,$linha["email"]);
				$_vetor[$key] = $local;				
				//$count = $count + 1;				
			}
			//retorna um array de usuarios
			return $_vetor;
			//fecha conexão
			$this->_conn->__destruct();
		}

		public function consultarId($_id){			
		$stmt = $this->_conn->prepare("SELECT * FROM GE_LOCAL WHERE ID_LOCAL = :id");

		$stmt->bindValue(":id", $_id);

		$stmt->execute();
		//retornar para cada usuario no banco, um usuario objeto
		while ($linha = $stmt->fetch()) {
			$local = new Local($linha["id_local"]
			                  ,$linha["nome"]
			                  ,$linha["descricao"]
			                  ,$linha["ativo"]
			                  ,$linha["latitude"] 
			                  ,$linha["longitude"]
			                  ,$linha["coordenada"]
			                  ,$linha["logradouro"]
			                  ,$linha["numero"]
			                  ,$linha["bairro"]
			                  ,$linha["cidade"]
			                  ,$linha["estado"]
			                  ,$linha["pais"]
			                  ,$linha["cep"]
			                  ,$linha["telefone_1"]
			                  ,$linha["telefone_2"]
			                  ,$linha["email"]);
		}		
		return $local;
		//fecha conexão
		$this->_conn->__destruct();
		}
	}
?>