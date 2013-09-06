<?php
    include_once 'class/Usuario.php';
    include_once 'class/Equipamento.php';
    include_once 'class/Conexao.php';
    include_once 'class/UsuarioDAO.php';
    include_once 'class/Autenticacao.php';
    include_once 'class/Movimento.php';
    include_once 'class/MovimentoDAO.php';
    

//$_usuario = new Usuario(null,"samanta.buenoa", "123456", "samanta bueno", "samanta@email.com", "912345678", "12345678", "S", "1", "G");
//$_usuario = new Usuario();

//$_dao = new UsuarioDAO();
//$r = $_dao->totalUsuarios();
//echo $r["CONT"];


//$_eqp = new Equipamento();
//$_eqp->setNumero("2");
//echo $_eqp->getNumero();

//echo "<br>".sha1("oi");
//echo "<br>";
//echo base64_decode("OTgzNDU5ODM0NTk4MzQ1MDk4MzQ1Mg==");
//$movimento = new Movimento();
//$dao = new MovimentoDAO();
//$movimento->setTarefa("27");
//$movimento->setUsuario("1");
//$movimento->setStatus("A");
//$dao->inserir($movimento);

//echo date('Y-m-d H:i:s',mktime(23,31,00,23,08,2013));

    echo $data = implode("-",array_reverse(explode("/",("23/06/2013"))));


//$_dao->altera($_usuario);

//$_result = $_dao->listarTudo();

//$_dao->inserir($_usuario);
//$_dao->consultarId(1);
//$vetor = $_dao->consultarTodos(0,4);

/*foreach ($vetor as $usuario) {
	echo $usuario->getNome();
}
$a = new Autenticacao();
$r = $a->login("ericodantas","123");*/
//echo $r;
/*
foreach ($_result as $key => $value) {
	echo "USUARIO ".$key."<br>".
			"ID: ".$value["id"]."<br>".
			"NOME: ".$value["nome"]."<br>".	
			"EMAIL: " .$value["email"]."<br>";
}*/

?>