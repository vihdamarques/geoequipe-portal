<?php
	class TarefaDAO{
		private $_conn;

		//construtor
		public function __construct(){
			$this->_conn = new Conexao();			
		}

		//função para INSERT dos dados na tabela ge_usuario
		public function inserir($_tarefa){
			try{				
				$this->_conn->beginTransaction();
				$stmt = $this->_conn->prepare("INSERT INTO GE_TAREFA (  id_tarefa
						                								,id_local
																		,id_usuario
																		,data_criacao																		
																		,descricao)														

												VALUES ( :id_tarefa
														,:id_local
														,:id_usuario
														,:data_cricao
														,:descricao														
														)"
											);
				$stmt->bindValue(":id_tarefa", $_tarefa->getId());
				$stmt->bindValue(":id_local", $_tarefa->getLocal());
				$stmt->bindValue(":id_usuario", $_tarefa->getUsuario());
				$stmt->bindValue(":data_cricao", $_tarefa->getData());
				$stmt->bindValue(":descricao", $_tarefa->getDescricao());
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
		public function alterar($_tarefa){
			try{			
			$this->_conn->beginTransaction();
			$stmt = $this->_conn->prepare("UPDATE GE_TAREFA
										   	  SET id_local = :id_local
												  ,id_usuario = :id_usuario
												  ,data_cricao = :data_cricao
												  ,ddescricao = :descricao
										    WHERE id_tarefa = :id_tarefa"
										);
				$stmt->bindValue(":id_tarefa", $_tarefa->getId());
				$stmt->bindValue(":id_local", $_tarefa->getLocal());
				$stmt->bindValue(":id_usuario", $_tarefa->getUsuario());
				$stmt->bindValue(":data_cricao", $_tarefa->getData());
				$stmt->bindValue(":descricao", $_tarefa->getDescricao());
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
				$stmt = $this->_conn->prepare("DELETE FROM GE_TAREFA WHERE id_tarefa = :id");
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
		public function totalTarefas(){
			$stmt = $this->_conn->query("SELECT COUNT(*) CONT FROM GE_TAREFA");
			return $resultado = $stmt->fetch();			
		}

		//retorna todos os usuários cadastrados na tabela ge_tarefa
		public function consultarTodos($_ini, $_fin){
			$_vetor = array();
			$stmt = $this->_conn->prepare("SELECT * FROM GE_TAREFA ORDER BY id_tarefa LIMIT :ini,:fin");
			$stmt->bindValue(":ini", $_ini, PDO::PARAM_INT);
			$stmt->bindValue(":fin", $_fin, PDO::PARAM_INT);
			$stmt->execute();
			//retornar para cada linha na tabela ge_tarefa, um objeto tarefa e insere em um array de tarefa	
			$result = $stmt->fetchAll();
			foreach ($result as $key => $linha){			
				$tarefa = new Tarefa ($linha["id_tarefa"]
					                  ,$linha["id_local"]
					                  ,$linha["id_usuario"]
					                  ,$linha["data_cricao"]
					                  ,$linha["descricao"] 					                  
					                  );
				$_vetor[$key] = $tarefa;		
				//$count = $count + 1;				
			}
			//retorna um array de tarefas
			return $_vetor;
			//fecha conexão
			$this->_conn->__destruct();
		}

		public function consultarId($_id){			
		$stmt = $this->_conn->prepare("SELECT * FROM GE_TAREFA WHERE id_tarefa = :id");

		$stmt->bindValue(":id", $_id);

		$stmt->execute();

		//retornar para cada tarefa no banco, uma tarefa objeto
		while ($linha = $stmt->fetch()) {
			$tarefa = new Tarefa ($linha["id_tarefa"]
				                  ,$linha["id_local"]
				                  ,$linha["id_usuario"]
				                  ,$linha["data_cricao"]
				                  ,$linha["descricao"] 					                  
				                  );
		}			
		return $tarefa;
		//fecha conexão
		$this->_conn->__destruct();
		}
	}
?>