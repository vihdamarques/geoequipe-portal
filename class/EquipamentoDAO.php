<?php
	class EquipamentoDAO{
		private $_conn;

		//construtor
		public function __construct(){
			$this->_conn = new Conexao();			
		}

		//função para INSERT dos dados na tabela ge_equipamento
		public function inserir($_equipamento){
			try{				
				$this->_conn->beginTransaction();
				$stmt = $this->_conn->prepare("INSERT INTO GE_EQUIPAMENTO (  id_equipamento
							                								,id_ultimo_sinal
																			,des_equipamento
																			,imei
																			,numero
																			,ativo)														

												VALUES ( :id_equipamento
														,:id_ultimo_sinal
														,:des_equipamento
														,:imei
														,:numero
														,:ativo
														)"
											);
				$stmt->bindValue(":id_equipamento", $_equipamento->getId());
				$stmt->bindValue(":id_ultimo_sinal", $_equipamento->getUltimoSinal());
				$stmt->bindValue(":des_equipamento", $_equipamento->getDescricao());
				$stmt->bindValue(":imei", $_equipamento->getImei());
				$stmt->bindValue(":numero", $_equipamento->getNumero());
				$stmt->bindValue(":ativo", $_equipamento->getAtivo());				
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

		//função para UPDATE dos dados da tabela ge_equipamento
		public function alterar($_equipamento){
			try{			
			$this->_conn->beginTransaction();
			$stmt = $this->_conn->prepare("UPDATE GE_EQUIPAMENTO
										   	  SET des_equipamento = :des_equipamento
												  ,imei = :imei
												  ,numero = :numero
												  ,ativo = :ativo
										    WHERE id_equipamento = :id_equipamento"
										);
				$stmt->bindValue(":id_equipamento", $_equipamento->getId());
				$stmt->bindValue(":des_equipamento", $_equipamento->getDescricao());
				$stmt->bindValue(":imei", $_equipamento->getImei());
				$stmt->bindValue(":numero", $_equipamento->getNumero());
				$stmt->bindValue(":ativo", $_equipamento->getAtivo());				
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
		//função para DELETE dos dados da tabela ge_equipamento
		public function excluir($_id){
			try{
				$this->_conn->beginTransaction();
				$stmt = $this->_conn->prepare("DELETE FROM GE_EQUIPAMENTO WHERE ID_EQUIPAMENTO = :id");
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

		//retorna o numero total de usuarios na tabela ge_equipamento
		public function totalEquipamentos(){
			$stmt = $this->_conn->query("SELECT COUNT(*) CONT FROM GE_EQUIPAMENTO");
			return $resultado = $stmt->fetch();			
		}

		//retorna todos os usuários cadastrados na tabela ge_equipamento
		public function consultarTodos($_ini, $_fin){
			$_vetor = array();
			$stmt = $this->_conn->prepare("SELECT * FROM GE_EQUIPAMENTO ORDER BY NUMERO LIMIT :ini,:fin");
			$stmt->bindValue(":ini", $_ini, PDO::PARAM_INT);
			$stmt->bindValue(":fin", $_fin, PDO::PARAM_INT);
			$stmt->execute();
			//retornar para cada linha na tabela ge_equipamento, um objeto equipamento e insere em um array de equipamento	
			$result = $stmt->fetchAll();
			foreach ($result as $key => $linha){			
				$equipamento = new Equipamento($linha["id_equipamento"]
						                  ,$linha["id_ultimo_sinal"]
						                  ,$linha["des_equipamento"]
						                  ,$linha["imei"]
						                  ,$linha["numero"] 
						                  ,$linha["ativo"]
						                  );
				$_vetor[$key] = $equipamento;				
			}
			//array de equipamentos
			return $_vetor;
			//fecha conexão
			$this->_conn->__destruct();
		}

		//retorna o equipamento consultando por ID
		public function consultarId($_id){			
		$stmt = $this->_conn->prepare("SELECT * FROM GE_EQUIPAMENTO WHERE ID_EQUIPAMENTO = :id");
		$stmt->bindValue(":id", $_id);		
		$stmt->execute();
		//retornar para cada equipamento no banco, um objeto equipamento
		while ($linha = $stmt->fetch()) {
			$equipamento = new Equipamento($linha["id_equipamento"]
										  ,$linha["id_ultimo_sinal"]
										  ,$linha["des_equipamento"]
										  ,$linha["imei"]
										  ,$linha["numero"]
										  ,$linha["ativo"]);									 									
		}			
		return $equipamento;
		//fecha conexão
		$this->_conn->__destruct();
		}

		//cria uma tag select com todos os equipamentos cadastrados
		public function selecionar(){
				$_vetor = array();			
				$stmt = $this->_conn->prepare("SELECT * FROM GE_EQUIPAMENTO ORDER BY NUMERO");
				$stmt->execute();
				//retornar para cada linha na tabela ge_equipamento, um objeto equipamento e insere em um array de equipamentos
				$result = $stmt->fetchAll();
				foreach ($result as $key => $linha){			
				$equipamento = new Equipamento($linha["id_equipamento"]
							                  ,$linha["id_ultimo_sinal"]
							                  ,$linha["des_equipamento"]
							                  ,$linha["imei"]
							                  ,$linha["numero"] 
							                  ,$linha["ativo"]
							                  );
				$_vetor[$key] = $equipamento;		
				}
				$html = "<select name='equipamento' id='equipamento'>\n";
				foreach ($_vetor as $equipamento) {				
					$id = $equipamento->getId();
					$numero = $equipamento->getNumero();
					$html .= "<option value=".$id.">".$numero."</option>\n";
				}
				$html .= "</select>\n";	
				return $html;
				//fecha conexão
				$this->_conn->__destruct();
				}
	}
?>