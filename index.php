<?php 
    include_once 'class/Conexao.php';
    include_once 'class/Autenticacao.php';
    include_once 'class/UsuarioDAO.php';

    $conn = new Conexao();

    //Autenticação
    $auth = new Autenticacao($conn);
    $auth->autenticar();
    $usuarioDAO = new UsuarioDAO($conn);

    if (isset($_GET['sinal'])) $id_sinal = $_GET['sinal'];

    include_once 'header.php';
?>
        <div id="map-container" style="position: absolute;bottom: 0px;left: 0px;right: 0px;top: 41px"><div id="map-canvas"></div></div>
        <?php
        if (!isset($id_sinal)) {
        ?>
        <div id="controle" style="position:absolute; right:10px; top:80px; display:block; background-color:#FFF; padding:10px; text-align:right; border-radius:10px; opacity:0.8;">
            <select id="usuario">
                <option value="0" selected>- Todos os usuários -</option>
                <?php
                foreach ($usuarioDAO->consultarTodos(0, 1000) as $usuario)
                    echo "<option value=\"" . $usuario->getId() . "\">" . $usuario->getNome() . "</option>";

                $conn->__destruct();
                ?>
            </select>
            <br />
            <label class="checkbox">
                <input type="checkbox" id="mostraTarefas" /> Mostrar tarefas agendadas
            </label>
        </div>
        <?php
        }
        ?>
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

            <?php
            if (!isset($id_sinal)) {
            ?>

            $("#usuario").change(carregaMarkers);
            $("#mostraTarefas").change(carregaMarkers);
            carregaMarkers();
            setInterval("carregaMarkers()", 60000);

            function carregaMarkers(){
              geoequipe.criaMarker([
                {
                  processo: {processo: 'monitoramento', usuario: $("#usuario").val()}
                 ,mapa: geoequipe.mapa(0)
                 ,limpar: geoequipe.marker()
                 ,manterFoco: false
                }
               ,($("#mostraTarefas:checked").size() ? {
                  processo: {processo: 'tarefa', usuario: $("#usuario").val()}
                 ,mapa: geoequipe.mapa(0)
                } : null)
              ]);
            }

            <?php
            } else {
            ?>

            geoequipe.criaMarker({
              processo: {processo: 'sinal', sinal: <?php echo $id_sinal; ?>}
             ,mapa: geoequipe.mapa(0)
            });

            <?php
            }
            ?>
        </script>
    </body>
</html>