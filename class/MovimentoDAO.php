<?php
	class MovimentoDAO{
		private $_conn;

		//construtor
		public function __construct(){
			$this->_conn = new Conexao();			
		}

		//função para INSERT dos dados na tabela ge_tarefa_movto
		public function inserir($_movimento){
			try{				
				$this->_conn->beginTransaction();
				$stmt = $this->_conn->prepare("INSERT INTO ge_tarefa_movto ( id_tarefa
																			,id_usuario
																			,data																		
																			,apontamento
																			,status
																			,ordem)														

												VALUES ( :id_tarefa
														,:id_usuario
														,now()														
														,:apontamento
														,:status
														,:ordem	)"
											);
				
				$stmt->bindValue(":id_tarefa", $_movimento->getTarefa());
				$stmt->bindValue(":id_usuario", $_movimento->getUsuario());
				//$stmt->bindValue(":data", "now()"/*$_movimento->getData()*/);
				$stmt->bindValue(":apontamento", $_movimento->getApontamento());
				$stmt->bindValue(":status", $_movimento->getStatus());
				$stmt->bindValue(":ordem", $_movimento->getOrdem());
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

		//função para UPDATE dos dados da tabela ge_tarefa_movto
		/*public function alterar($_movimento){
			try{			
			$this->_conn->beginTransaction();
			$stmt = $this->_conn->prepare("UPDATE ge_tarefa_movto
										   	  SET id_usuario = :id_usuario
												  ,data = :data
												  ,apontamento = :apontamento
												  ,status = :status
												  ,ordem = :ordem
										    WHERE id_tarefa = :id_tarefa"
										);
				$stmt->bindValue(":id_tarefa", $_movimento->getTarefa());
				$stmt->bindValue(":id_usuario", $_movimento->getUsuario());
				$stmt->bindValue(":data", $_movimento->getData());
				$stmt->bindValue(":apontamento", $_movimento->getApontamento());
				$stmt->bindValue(":status", $_movimento->getStatus());
				$stmt->bindValue(":ordem", $_movimento->getOrdem());
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

		//função para DELETE dos dados da tabela ge_tarefa_movto
		public function excluir($_id){
			try{
				$this->_conn->beginTransaction();
				$stmt = $this->_conn->prepare("DELETE FROM ge_tarefa_movto WHERE id_tarefa_movto = :id");
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
		}*/
		
		public function consultarTodos($id_tarefa){
			$_vetor = array();
			$stmt = $this->_conn->prepare("SELECT * FROM ge_tarefa_movto WHERE id_tarefa = :id_tarefa ORDER BY id_tarefa_movto");		
			$stmt->bindValue(":id_tarefa", $id_tarefa, PDO::PARAM_INT);
			$stmt->execute();
		
			$result = $stmt->fetchAll();
			foreach ($result as $key => $linha){			
				$_movimento = new Movimento ($linha["id_tarefa_movto"]
						                    ,$linha["id_tarefa"]
						                    ,$linha["id_usuario"]
						                    ,$linha["data"]
						                    ,$linha["apontamento"] 					                  
						                    ,$linha["status"] 	
  						                    ,$linha["ordem"] 	
 					                       );
				$_vetor[$key] = $_movimento;
			}		
			return $_vetor;
			//fecha conexão
			$this->_conn->__destruct();
		}
		
		public function consultarUltimoStatus($id_tarefa){			
		$stmt = $this->_conn->prepare("SELECT * FROM ge_tarefa_movto WHERE id_tarefa_movto = (SELECT MAX(id_tarefa_movto) FROM ge_tarefa_movto where id_tarefa = :id_tarefa)");
		$stmt->bindValue(":id_tarefa", $id_tarefa);
		$stmt->execute();
		//retornar para cada tarefa no banco, um objeto tarefa
		while ($linha = $stmt->fetch()) {
				$_movimento = new Movimento ($linha["id_tarefa_movto"]
						                    ,$linha["id_tarefa"]
						                    ,$linha["id_usuario"]
						                    ,$linha["data"]
						                    ,$linha["apontamento"] 					                  
						                    ,$linha["status"] 	
  						                    ,$linha["ordem"] 	
 					                       );
		}			
		return $_movimento;
		//fecha conexão
		$this->_conn->__destruct();
		}
	}
?>