<?php
	include_once 'class/Conexao.php';
	include_once 'class/Autenticacao.php';

	$auth = new Autenticacao();
	$auth->logout();
	header("Location: login.php");	
?>