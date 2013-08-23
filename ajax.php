<?php

	$processo = $_GET['processo'];

	switch ($processo) {
		case "getLatitude": echo '-23.546678';break;
		case "getLongitude": echo '-46.635246';break;
		default: break;
	}

?>
