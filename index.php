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

            #map-canvas img {
                max-width: none;
                width: auto;
                display:inline;
            }
        </style>
        <script src="http://maps.google.com/maps/api/js?v=3&sensor=false"></script>
        <script src="js/GeoequipeAPI.js"></script>
        <script>
            geoequipe.criaMapa({div:"map-canvas"});
        </script>
    </body>
</html>