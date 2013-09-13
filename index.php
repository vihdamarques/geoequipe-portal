<?php 
    include_once 'class/Conexao.php';
    include_once 'class/Autenticacao.php';
    include_once 'class/UsuarioDAO.php';

    //Autenticação
    $auth = new Autenticacao();
    $auth->autenticar();
    $conn = new Conexao();
    $usuarioDAO = new UsuarioDAO($conn);

    include_once 'header.php';
?>
        <div id="map-canvas"></div>
        <div id="controle" style="position:absolute; right:10px; top:50px; display:block; background-color:#FFF; padding:10px; text-align:right; border-radius:10px; opacity:0.8;">
            <select id="usuario">
                <option value="0" selected>- Todos os usuários -</option>
                <?php
                foreach ($usuarioDAO->consultarTodos(0, 1000) as $usuario)
                    echo "<option value=\"" . $usuario->getId() . "\">" . $usuario->getNome() . "</option>";

                $conn->__destruct();
                ?>
            </select>
        </div>
        <style>
            html, body, #map-canvas {
                margin: 0;
                padding: 0;
                height: 100%;
            }

            #map-canvas img {
                max-width: none;
            }
        </style>
        <script src="http://maps.google.com/maps/api/js?v=3&sensor=false"></script>
        <script src="js/GeoequipeAPI.js"></script>
        <script>
            geoequipe.criaMapa({div:"map-canvas"});
            $("#usuario").change(carregaMarkers);
            carregaMarkers();
            setInterval("carregaMarkers()", 60000);

            function carregaMarkers(){
              geoequipe.criaMarker({
                processo: {processo: 'monitoramento', usuario: $("#usuario").val()}
               ,mapa: geoequipe.mapa(0)
               ,limpar: geoequipe.marker()
              });
            }
        </script>
    </body>
</html>