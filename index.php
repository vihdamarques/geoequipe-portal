<?php 
    include_once 'class/Conexao.php';
    include_once 'class/Autenticacao.php';

    $conn = new Conexao();

    //Autenticação
    $auth = new Autenticacao($conn);
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
            }
        </style>
        <script src="http://maps.google.com/maps/api/js?v=3&sensor=false"></script>
        <script src="js/GeoequipeAPI.js"></script>
        <script>
            geoequipe.criaMapa({div:"map-canvas"});
            carregaMarkers();
            setInterval("carregaMarkers()", 60000);

            function carregaMarkers(){
              geoequipe.criaMarker({
                processo: {processo: 'monitoramento', usuario: 0}
               //,param: {}
               ,mapa: geoequipe.mapa(0)
               ,limpar: geoequipe.marker()
              });
            }
        </script>
    </body>
</html>