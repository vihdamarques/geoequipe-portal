<?php

include_once "class/SinalDAO.php";
include_once "class/UsuarioDAO.php";
include_once "class/EquipamentoDAO.php";
include_once "class/TarefaDAO.php";
include_once "class/Conexao.php";

if (isset($_GET['processo'])) $processo = $_GET['processo'];

$usuario  = null;
$data_ini = null;
$data_fim = null;
$id_sinal = null;

$MIME_JSON = 'application/json';
$MIME_JS   = 'application/x-javascript';

$marker_pessoa = "img/marker/pessoa.png";
$marker_tarefa = "img/marker/tarefa.png";

function marker_numerico($n) {
  return "img/marker/number_" . $n . ".png";
}

switch ($processo) {
  case "getLatitude":
    echo '-23.546678';
    break;
  case "getLongitude":
    echo '-46.635246';
    break;
  case "monitoramento":
    if (isset($_GET['usuario'])) $usuario = $_GET['usuario'];
    jsonMonitoramento($usuario);
    break;
  case "rastro":
    if (isset($_GET['usuario'])) $usuario = $_GET['usuario'];
    if (isset($_GET['data_ini'])) $data_ini = $_GET['data_ini'];
    if (isset($_GET['data_fim'])) $data_fim = $_GET['data_fim'];
    jsonRastro($usuario, $data_ini, $data_fim);
    break;
  case "tarefa":
    if (isset($_GET['usuario'])) $usuario = $_GET['usuario'];
    jsonTarefa($usuario);
    break;
  case "sinal":
    if (isset($_GET['sinal'])) $id_sinal = $_GET['sinal'];
    jsonSinal($id_sinal);
    break;
  default:
    break;
}

function jsonMonitoramento($usuario) {
  global $MIME_JSON, $marker_pessoa;
  $conn           = new conexao();
  $sinaldao       = new SinalDAO($conn);
  $possuiDados    = false;

  $json = array();

  foreach ($sinaldao->consultarPorUsuario($usuario) as $sinal) {
    if (!$possuiDados) $possuiDados = true;

    array_push($json,
      array(
        "tipo"  => "marker"
       ,"nome"  => $sinal->getUsuario()->getNome()
       ,"icone" => $marker_pessoa
       ,"msg"   => '<strong>Nome:</strong> ' . $sinal->getUsuario()->getNome() . '<br />'.
                   '<strong>Número:</strong> ' . $sinal->getEquipamento()->getNumero() . '<br />' .
                   '<strong>Data:</strong> ' . $sinal->getDataServidor() . '<br />' .
                   '<strong>Endereço:</strong> ' . $sinal->getEndereco() . '<br />' .
                   '<strong>Velocidade:</strong> ' . $sinal->getVelocidade()
       ,"coord" => array("lat" => $sinal->getLatitude()
                        ,"lng" => $sinal->getLongitude())
      )
    );
  }

  $conn->__destruct();

  if ($possuiDados)
    httpPrint(json_encode($json), $MIME_JSON, false);
  else
    noDataFound();
}

function jsonSinal($id_sinal) {
  global $MIME_JSON, $marker_pessoa;
  $conn           = new conexao();
  $sinaldao       = new SinalDAO($conn);
  $possuiDados    = false;

  $json = array();

  foreach ($sinaldao->consultarPorId($id_sinal) as $sinal) {
    if (!$possuiDados) $possuiDados = true;

    array_push($json,
      array(
        "tipo"  => "marker"
       ,"nome"  => $sinal->getUsuario()->getNome()
       ,"icone" => $marker_pessoa
       ,"msg"   => '<strong>Nome:</strong> ' . $sinal->getUsuario()->getNome() . '<br />'.
                   '<strong>Número:</strong> ' . $sinal->getEquipamento()->getNumero() . '<br />' .
                   '<strong>Data:</strong> ' . $sinal->getDataServidor() . '<br />' .
                   '<strong>Endereço:</strong> ' . $sinal->getEndereco() . '<br />' .
                   '<strong>Velocidade:</strong> ' . $sinal->getVelocidade()
       ,"coord" => array("lat" => $sinal->getLatitude()
                        ,"lng" => $sinal->getLongitude())
      )
    );
  }

  $conn->__destruct();

  if ($possuiDados)
    httpPrint(json_encode($json), $MIME_JSON, false);
  else
    noDataFound();
}

function jsonTarefa($usuario) {
  global $MIME_JSON, $marker_tarefa;
  $conn        = new conexao();
  $tarefadao   = new TarefaDAO($conn);
  $possuiDados = false;

  $json = array();

  foreach ($tarefadao->consultarJson($usuario,1) as $tarefa) {
    if (!$possuiDados) $possuiDados = true;

    array_push($json,
      array(
        "tipo"  => "marker"
       ,"nome"  => $tarefa["local"]->getNome()
       ,"icone" => $marker_tarefa
       ,"msg"   => '<strong>Local:</strong> ' . $tarefa["local"]->getNome() . '<br />'.
                   '<strong>Tarefa:</strong> ' . $tarefa["tarefa"]->getDescricao() . '<br />' .
                   '<strong>Data:</strong> ' . $tarefa["movimento"]->getData() . '<br />' .
                   '<strong>Endereço:</strong> ' . $tarefa["local"]->getEndereco() . '<br />' .
                   '<strong>Apontamento:</strong> ' . $tarefa["movimento"]->getApontamento()
       ,"coord" => array("lat" => $tarefa["local"]->getLatitude()
                        ,"lng" => $tarefa["local"]->getLongitude())
      )
    );
  }

  $conn->__destruct();

  if ($possuiDados)
    httpPrint(json_encode($json), $MIME_JSON, false);
  else
    noDataFound("Nenhuma tarefa agendada para hoje");
}

function jsonRastro($usuario, $data_ini, $data_fim) {
  global $MIME_JSON;

  $conn           = new conexao();
  $sinaldao       = new SinalDAO($conn);
  $possuiDados    = false;
  $n              = 0;
  $trajeto        = array();

  $json = array();

  foreach ($sinaldao->consultarPorPeriodo($usuario, $data_ini, $data_fim) as $sinal) {
    if (!$possuiDados) $possuiDados = true;

    array_push($json,
      array(
        "tipo"  => "marker"
       ,"nome"  => $sinal->getUsuario()->getNome()
       ,"icone" => marker_numerico(++$n)
       ,"msg"   => '<strong>Nome:</strong> ' . $sinal->getUsuario()->getNome() . '<br />'.
                   '<strong>Número:</strong> ' . $sinal->getEquipamento()->getNumero() . '<br />' .
                   '<strong>Data:</strong> ' . $sinal->getDataServidor() . '<br />' .
                   '<strong>Endereço:</strong> ' . $sinal->getEndereco() . '<br />' .
                   '<strong>Velocidade:</strong> ' . $sinal->getVelocidade()
       ,"coord" => array("lat" => $sinal->getLatitude()
                        ,"lng" => $sinal->getLongitude())
      )
    );

    array_push($trajeto, array("lat" => $sinal->getLatitude()
                              ,"lng" => $sinal->getLongitude()));
  }

  $conn->__destruct();

  if ($possuiDados) {
    $json = array_merge($json, tracarTrajeto($trajeto));
    httpPrint(json_encode($json), $MIME_JSON, false);
  } else
    noDataFound("Nenhum sinal encontrado no período");
}

function tracarTrajeto($coords) {
  $cor       = '#77F';
  $opacidade = '0.6';
  $espessura = '4';
  $trajeto   = array();

  for ($n = 1; $n < sizeof($coords); $n++) {
    array_push($trajeto,
      array(
        "tipo"      => "linha"
       ,"nome"      => "Trecho " . $n . " a " . ($n+1)
       ,"cor"       => "$cor"
       ,"opacidade" => "$opacidade"
       ,"espessura" => "$espessura"
       ,"msg"       => "<strong>Distância:</strong> " . calculaDistancia($coords[$n-1]["lat"]
                                                                         ,$coords[$n-1]["lng"]
                                                                         ,$coords[$n]["lat"]
                                                                         ,$coords[$n]["lng"]) . " metros"
       ,"coord"     => array(array("lat" => $coords[$n-1]["lat"], "lng" => $coords[$n-1]["lng"])
                            ,array("lat" => $coords[$n]["lat"], "lng" => $coords[$n]["lng"]))
      )
    );
  }

  return $trajeto;
}

function calculaDistancia($lat1, $lng1, $lat2, $lng2) {
  $raio_terra = 6378136.245; // em Metros
  $rad        = 180 / pi();
  $arco_ab    = 90 - $lat1;
  $arco_ac    = 90 - $lat2;
  $arco_abc   = $lng2 - $lng1;
  $arco_cos;

  $arco_cos = (cos($arco_ac/$rad) * cos($arco_ab/$rad)) + (sin($arco_ac/$rad) * sin($arco_ab/$rad) * cos($arco_abc/$rad));
  $arco_cos = (acos($arco_cos) * 180) / pi();

  return round((2 * pi() * $raio_terra * $arco_cos) / 360, 2);
}

function noDataFound($msg = null) {
  global $MIME_JS;
  if ($msg == null) $msg = "Dados não encontrados !";
  httpPrint('geoequipe.msgAjaxFalha("' . $msg . '")', $MIME_JS, false);
}

function httpPrint($content, $mime = 'text/html', $cache = false) {
  if (!$cache) {
    header('Cache-Control: no-cache, must-revalidate');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header('Pragma: no-cache');
  }
  header('Content-type: ' . $mime . '; charset=utf-8');
  echo $content;
}

?>