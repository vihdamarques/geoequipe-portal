<?php 
    include_once 'class/Conexao.php';
    include_once 'class/Autenticacao.php';
    //Autenticação
    $auth = new Autenticacao();
    $auth->autenticar();    
    include_once 'header.php';
?>
        <div id="map-canvas"></div>
        <style>
            html, body, #map-canvas {
                margin: 0;
                padding: 0;
                height: 100%;
            }

            body {
                padding-top: 0px !important;
            }

            #map-canvas {
                margin-top: 41px !important;
            }

            #map-canvas img {
                max-width: none;
            }
        </style>
        <script src="http://maps.google.com/maps/api/js?v=3&sensor=false"></script>
        <script src="js/GeoequipeAPI.js"></script>
        <script>
            geoequipe.criaMapa({div:"map-canvas"});
        </script>
    </body>
</html>