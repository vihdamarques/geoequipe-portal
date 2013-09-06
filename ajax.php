<?php

$processo = $_GET['processo'];
$usuario, $data_ini, $data_fim;

switch ($processo) {
  case "getLatitude":
    echo '-23.546678';
    break;
  case "getLongitude":
    echo '-46.635246';
    break;
  case "monitoramento":
    if (isset($_GET['usuario']))  $usuario = $_GET['usuario'];
    echo jsonMonitoramento($usuario);
    break;
  case "rastro":
    if (isset($_GET['usuario'])) $usuario = $_GET['usuario'];
    if (isset($_GET['data_ini'])) $data_ini = $_GET['data_ini'];
    if (isset($_GET['data_fim'])) $data_fim = $_GET['data_fim'];
    echo jsonRastro($usuario, $data_ini, $data_fim);
    break;
  default:
    break;
}

function jsonMonitoramento($usuario) {

  $sinaldao = new SinalDAO();
  ;
  foreach ($sinaldao->consultaUsuario($usuario) as $sinal) {
    $json = array(
              array("tipo" => "marker"
                   ,"nome" => $sinal->usuario)
            );
  }

  return json_encode($json);
}

?>


[{"tipo":"marker","nome":"GCM 1305","icone":"http:\/\/www.sistracks.com.br\/i\/apex_tracker\/images\/marker_carro_azul.png","msg":"<strong>Identificação:<\/strong> GCM 1305<br><strong>Status:<\/strong> Em Movimento<br><strong>SV:<\/strong> 9<br><strong>Placa:<\/strong> FGY-6295<br><strong>Velocidade:<\/strong> 18<br><strong>Data:<\/strong> 30\/08\/2013 20:10<br><input type=\"hidden\" name=\"f01\" value=\"18458\" \/><span class=\"sincronizar\" style=\"font-weight:bold; display:none;\">Tempo de sincronização: <\/span><select class=\"sincronizar\" style=\"display:none\" name=\"f02\"><option value=\"300\" >5 minutos<\/option><option value=\"120\" >2 minutos<\/option><option value=\"60\" >1 minutos<\/option><option value=\"30\" selected>30 segundos<\/option><\/select>&nbsp;&nbsp;&nbsp;<input class=\"sincronizar\" style=\"display:none\" type=\"button\" value=\"Salvar\" onClick=\"AlterarVlrs()\" \/><br class=\"sincronizar\"\/>","coord":{"lat":-23.60626,"lng":-46.92621},"equipamento":"<input type=\"hidden\" value=\"18458\" name=\"f01\" \/>"}]