<?php
	$operacao = isset($_GET["operacao"]) ? $_GET["operacao"] : "";
	
	switch ($operacao) {
		case "G":
			echo "agendar";
			break;
		case "C":
			echo "cancelar";
			break;
		case "F":
			echo "concluir";
			break;
		case "A":
			echo "adiar";
			break;		
		default:
			echo "";
			break;
	}
?>
