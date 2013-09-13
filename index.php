<?php 
    include_once 'class/Conexao.php';
    include_once 'class/Autenticacao.php';
<<<<<<< HEAD

    $conn = new Conexao();

    //Autenticação
    $auth = new Autenticacao($conn);
    $auth->autenticar();    
=======
    include_once 'class/UsuarioDAO.php';

    //Autenticação
    $auth = new Autenticacao();
    $auth->autenticar();
    $conn = new Conexao();
    $usuarioDAO = new UsuarioDAO($conn);

>>>>>>> 190ae2a6dc6288f1e9098fb5c7d34ea32a4077d5
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