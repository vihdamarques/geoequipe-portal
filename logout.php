<?php
	include_once 'class/Conexao.php';
	include_once 'class/Autenticacao.php';

	//Conexão
    $conn = new Conexao();

	$auth = new Autenticacao($conn);
	$auth->logout();
	header("Location: login.php");	

	//destruir conexão
    $conn->__destruct(); 
?>