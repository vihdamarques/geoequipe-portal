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
                <option value="0" selected>- Selecione o Usuário -</option>
                <?php
                foreach ($usuarioDAO->consultarTodos(0, 1000) as $usuario)
                    echo "<option value=\"" . $usuario->getId() . "\">" . $usuario->getNome() . "</option>";

                $conn->__destruct();
                ?>
            </select>
            <br />
            Data inicial: <input type="text" id="data_ini" class="input-small datepicker" placeholder="dd/mm/yyyy" value="11/09/2013">
            <br />
            Data final: <input type="text" id="data_fim" class="input-small datepicker" placeholder="dd/mm/yyyy" value="12/09/2013">
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

            $(".datepicker").datepicker({
                language: "pt-BR",
                orientation: "top",
                format: "dd/mm/yyyy",
                autoclose: true                
            });
        </script>
    </body>
</html>