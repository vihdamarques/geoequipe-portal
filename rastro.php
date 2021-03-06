<?php 
    include_once 'class/Conexao.php';
    include_once 'class/Autenticacao.php';
    include_once 'class/UsuarioDAO.php';

    //Autenticação
    $conn = new Conexao();
    $auth = new Autenticacao($conn);
    $auth->autenticar();
    $usuarioDAO = new UsuarioDAO($conn);

    include_once 'header.php';
?>
        <div id="map-container" style="position: absolute;bottom: 0px;left: 0px;right: 0px;top: 41px"><div id="map-canvas"></div></div>
        <div id="controle" style="position:absolute; right:10px; top:80px; display:block; background-color:#FFF; padding:10px; text-align:right; border-radius:10px; opacity:0.8;">
            Usuário:
            <select id="usuario">
                <option value="0" selected>- Selecione o Usuário -</option>
                <?php
                foreach ($usuarioDAO->consultarTodos(0, 1000) as $usuario)
                    echo "<option value=\"" . $usuario->getId() . "\">" . $usuario->getNome() . "</option>";

                $conn->__destruct();
                ?>
            </select>
            <br />

            Data inicial:
            <div id="data_ini_container" class="input-append date">
              <input data-format="dd/MM/yyyy hh:mm" type="text" class="input-medium" id="data_ini" value="<?php echo date("d/m/Y H:i", strtotime("-2 hours")); ?>"></input>
              <span class="add-on">
                <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
              </span>
            </div>
            <br />
            Data final:
            <div id="data_fim_container" class="input-append date">
              <input data-format="dd/MM/yyyy hh:mm" type="text" class="input-medium" id="data_fim" value="<?php echo date("d/m/Y H:i"); ?>"></input>
              <span class="add-on">
                <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
              </span>
            </div>
            <br />
            <button type="button" id="visualizar" class="btn">Visualizar</button>
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
            $("#visualizar").click(carregaRastro);

            function carregaRastro(){
              geoequipe.criaMarker({
                processo: {processo: 'rastro', usuario: $("#usuario").val(), data_ini: $("#data_ini").val(), data_fim: $("#data_fim").val()}
               ,mapa: geoequipe.mapa(0)
               ,limpar: geoequipe.sobreposicao()
              });
            }

            $('#data_ini_container, #data_fim_container').datetimepicker({
              language: 'pt-BR'
             ,pickSeconds: false
            });

        </script>
    </body>
</html>