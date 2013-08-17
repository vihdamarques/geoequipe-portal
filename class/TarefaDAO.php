<?php
	class TarefaDAO{
		private $_conn;

		//construtor
		public function __construct(){
			$this->_conn = new Conexao();			
		}

		//função para INSERT dos dados na tabela ge_tarefa
		public function inserir($_tarefa){
			try{				
				$this->_conn->beginTransaction();
				$stmt = $this->_conn->prepare("INSERT INTO ge_tarefa (  id_tarefa
						                								,id_local
																		,id_usuario
																		,data_criacao																		
																		,descricao)														

												VALUES ( :id_tarefa
														,:id_local
														,:id_usuario
														,now()
														,:descricao														
														)"
											);
				$stmt->bindValue(":id_tarefa", $_tarefa->getId());
				$stmt->bindValue(":id_local", $_tarefa->getLocal());
				$stmt->bindValue(":id_usuario", $_tarefa->getUsuario());
				//$stmt->bindValue(":data_criacao", "now()"/*$_tarefa->getData()*/);
				$stmt->bindValue(":descricao", $_tarefa->getDescricao());
				//executa
				$stmt->execute();	
				//pega o id inserido
				$lastId = $this->_conn->lastInsertId();		
				//commita
				$this->_conn->commit();
				//retorna id inserido
				return $lastId;
				//fecha conexão				
				$this->_conn->__destruct();							
			}
			catch(PDOException $_e){
				$this->_conn->rollBack();
				echo "Erro: ".$_e->getMessage();
			}
		}

		//função para UPDATE dos dados da tabela ge_tarefa
		public function alterar($_tarefa){
			try{			
			$this->_conn->beginTransaction();
			$stmt = $this->_conn->prepare("UPDATE ge_tarefa
										   	  SET id_local = :id_local
												  ,id_usuario = :id_usuario
												  ,data_criacao = :data_criacao
												  ,descricao = :descricao
										    WHERE id_tarefa = :id_tarefa"
										);
			$stmt->bindValue(":id_tarefa", $_tarefa->getId());
			$stmt->bindValue(":id_local", $_tarefa->getLocal());
			$stmt->bindValue(":id_usuario", $_tarefa->getUsuario());
			$stmt->bindValue(":data_criacao", $_tarefa->getData());
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

		//função para DELETE dos dados da tabela ge_tarefa
		public function excluir($_id){
			try{
				$this->_conn->beginTransaction();
				$stmt = $this->_conn->prepare("DELETE FROM ge_tarefa WHERE id_tarefa = :id");
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

		//retorna o numero total de tarefas na tabela ge_tarefa
		public function totalTarefas(){
			$stmt = $this->_conn->query("SELECT count(*) CONT FROM ge_tarefa");
			return $resultado = $stmt->fetch();			
		}

		//retorna todos as tarefas cadastrados na tabela ge_tarefa
		public function consultarTodos($_ini, $_fin){
			$_vetor = array();
			$stmt = $this->_conn->prepare("SELECT * FROM ge_tarefa ORDER BY id_tarefa LIMIT :ini,:fin");
			$stmt->bindValue(":ini", $_ini, PDO::PARAM_INT);
			$stmt->bindValue(":fin", $_fin, PDO::PARAM_INT);
			$stmt->execute();
			//retornar para cada linha na tabela ge_tarefa, um objeto tarefa e insere em um array de tarefa	
			$result = $stmt->fetchAll();
			foreach ($result as $key => $linha){			
				$tarefa = new Tarefa ( $linha["id_tarefa"]
					                  ,$linha["id_local"]
					                  ,$linha["id_usuario"]
					                  ,$linha["descricao"]
					                  ,$linha["data_criacao"]
					                  );
				$_vetor[$key] = $tarefa;							
			}
			//retorna um array de tarefas
			return $_vetor;
			//fecha conexão
			$this->_conn->__destruct();
		}

		//retona uma tarefa consultando po ID
		public function consultarId($_id){
		$stmt = $this->_conn->prepare("SELECT * FROM ge_tarefa WHERE id_tarefa = :id");
		$stmt->bindValue(":id", $_id);
		$stmt->execute();
		//retornar para cada tarefa no banco, um objeto tarefa
		while ($linha = $stmt->fetch()) {
			$tarefa = new Tarefa ( $linha["id_tarefa"]
				                  ,$linha["id_local"]
				                  ,$linha["id_usuario"]
				                  ,$linha["descricao"]
				                  ,$linha["data_criacao"] 					                  
				                  );
		}			
		return $tarefa;
		//fecha conexão
		$this->_conn->__destruct();
		}


	}
?>