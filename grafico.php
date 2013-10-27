<?php
    include_once 'class/Conexao.php';
    include_once 'class/Autenticacao.php';
    include_once 'class/UsuarioDAO.php';

    $conn = new Conexao();

    //Autenticação
    $auth = new Autenticacao($conn);
    $auth->autenticar();
    $usuarioDAO = new UsuarioDAO($conn);

    include_once 'header.php';
?>

    <script type="text/javascript" src='https://www.google.com/jsapi?autoload={"modules":[{"name":"visualization","version":"1"}]}'>
    </script>
    <script type="text/javascript">
        google.setOnLoadCallback(drawVisualization);

        function carregaInfoGrafico(processo, callback){
          var box;

          $.ajax({type: "GET"
                 ,url: "ajax.php"
                 ,data: {"processo": processo}
                 ,async: true
                 ,success: callback
                 ,beforeSend: startLoading
                 ,complete: stopLoading
                 ,dataType: "json"
                 ,timeout: 30000
                 });

          function stopLoading(jqXHR, textStatus) {
            if (textStatus === "success")
              box.fadeOut("slow", function(){ $(this).remove() });
          }

          function startLoading() {
            box = $("<div></div>")
                  .attr("class","ajaxLoading")
                  .css("display","block")
                  .css("z-index","1050")
                  .css("position","absolute")
                  .css("top","0px")
                  .css("left","0px")
                  .css("width","100%")
                  .append($("<div></div>")
                          .css("margin","0 auto")
                          .css("padding","3px")
                          .css("background-color","#FEB")
                          .css("width","120px")
                          .css("text-align","center")
                          .css("line-height","25px")
                          .css("border","1px solid #EB7")
                          .append($("<span>Carregando...</span>")
                                  .css("font-weight","bold")
                                  .css("color","#444")
                                  .css("font-family","sans-serif")
                                  .css("font-size","14px")
                          )
                  );
            $("body").prepend(box);
        };
      }

      function drawVisualization() {
        carregaInfoGrafico("TMACliente", function(ret){
          var wrapper = new google.visualization.ChartWrapper({
            chartType: "BarChart"
           ,dataTable: ret
           ,options: {"title": "Tempo Médio de Atendimento x Locais"
                     ,"vAxis": {"title": "Local"}
                     ,"hAxis": {"title": "Dias"}}
           ,containerId: "TMACliente"
          });
          wrapper.draw();
          $("#carregando").remove();
        });

        carregaInfoGrafico("TAPUsuario", function(ret){
          var wrapper = new google.visualization.ChartWrapper({
            chartType: "ColumnChart"
           ,dataTable: ret
           ,options: {"title": "Quantidade de Tarefas Agendadas por usuário"
                     ,"vAxis": {"title": "Quantidade"}
                     ,"hAxis": {"title": "Usuário"}}
           ,containerId: "TAPUsuario"
          });
          wrapper.draw();
        });

        carregaInfoGrafico("TPLocal", function(ret){
          var wrapper = new google.visualization.ChartWrapper({
            chartType: "PieChart"
           ,dataTable: ret
           ,options: {"title": "% Tarefas Criadas Por Local"}
           ,containerId: "TPLocal"
          });
          wrapper.draw();
        });

        carregaInfoGrafico("TPLocalAdiado", function(ret){
          var wrapper = new google.visualization.ChartWrapper({
            chartType: "PieChart"
           ,dataTable: ret
           ,options: {"title": "% Tarefas Adiadas Por Local"}
           ,containerId: "TPLocalAdiado"
          });
          wrapper.draw();
        });
      }
    </script>
    <div id="carregando" style="width: 100%; display: block; text-align: center;">CARREGANDO GRÁFICOS</div>
    <div id="TMACliente" style="width: 500px; height: 300px; float: left"></div>
    <div id="TAPUsuario" style="width: 500px; height: 300px; float: left"></div>
    <div style="clear:both"></div>
    <div id="TPLocal" style="width: 500px; height: 300px; float: left"></div>
    <div id="TPLocalAdiado" style="width: 500px; height: 300px; float: left"></div>
    </body>
</html>