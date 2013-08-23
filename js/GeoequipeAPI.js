    /**
     * @author      Vinicius Damarques
     * @version     1
     * @since       19/08/2013 20:42
     * @lastUpdate  19/08/2013 23:42
     * @requires    Google Maps API v3
     * @requires    jQuery v1.6+
     * @description Biblioteca JavaScript para facilitar e padronizar desenvolvimento com a Google Maps API v3.
     * @prefixHelp  g - global / d - default / v - variavel / p - parametro
     */

    /**
     * @name $
     * @class Objeto jQuery
     */

    /**
     * @name google
     * @class O objeto usado pelo Google APIs
     */

    /**
     * @name google.maps
     * @class O objeto usado pelo Google Maps V3 API 
     */

    /*
     * jQuery AjaxQ - AJAX request queueing for jQuery
     *
     * Version: 0.0.1
     * Date: July 22, 2008
     *
     * Copyright (c) 2008 Oleg Podolsky (oleg.podolsky@gmail.com)
     * Licensed under the MIT (MIT-LICENSE.txt) license.
     *
     * http://plugins.jquery.com/project/ajaxq
     * http://code.google.com/p/jquery-ajaxq/
     */

    $.ajaxq = function(queue, options) {
      // Initialize storage for request queues if it is not initialized yet
      if (typeof document.ajaxq == "undefined") document.ajaxq = {q:{}, r:null};
      // Initialize current queue if it is not initialized yet
      if (typeof document.ajaxq.q[queue] == "undefined") document.ajaxq.q[queue] = [];
      if (typeof options != "undefined") { // Request settings are given, enqueue the new request
        // Copy the original options, because options.complete is going to be overridden
        var optionsCopy = {};
        for (var o in options) optionsCopy[o] = options[o];
        options = optionsCopy;
        // Override the original callback
        var originalCompleteCallback = options.complete;
        options.complete = function(request, status) {
          // Dequeue the current request
          document.ajaxq.q[queue].shift();
          document.ajaxq.r = null;
          // Run the original callback
          if (originalCompleteCallback) originalCompleteCallback(request, status);
          // Run the next request from the queue
          if (document.ajaxq.q[queue].length > 0) document.ajaxq.r = jQuery.ajax (document.ajaxq.q[queue][0]);
        };
        // Enqueue the request
        document.ajaxq.q[queue].push(options);
        // Also, if no request is currently running, start it
        if (document.ajaxq.q[queue].length == 1) document.ajaxq.r = jQuery.ajax(options);
      } else { // No request settings are given, stop current request and clear the queue
        if (document.ajaxq.r) {
          document.ajaxq.r.abort();
          document.ajaxq.r = null;
        }
        document.ajaxq.q[queue] = [];
      }
    }

    /**
     * @constructor
     */

    function Geoequipe(){

     /**
     * @description permite acessar os tipos de mapa externamente
     */
      this.tipo = {
        mapa:     google.maps.MapTypeId.ROADMAP
       ,satelite: google.maps.MapTypeId.SATELLITE
       ,hibrido:  google.maps.MapTypeId.HYBRID
       ,terreno:  google.maps.MapTypeId.TERRAIN
      };

      /**
      * @description retorna o latitude e longitude no formato google
      * @param {String} pLat Latitude
      * @param {String} pLng Longitude
      * @return {google.maps.LatLng}
      */
      this.latLng = function (pLat, pLng){
        return new google.maps.LatLng( parseFloat(pLat), parseFloat(pLng) );
      };

      // Variaveis globais
      var gThis      = this
         ,gMapa      = []
         ,gMarker    = []
         ,gLinha     = []
         ,gPoligono  = []
         ,gRetangulo = []
         ,gCirculo   = []
         ,gRota      = []
         ,gKml       = []
         ,gPoi       = []
         ,gCriando   = false
         ,gProtocolo = window.location.protocol+"//"
         ,gHost      = window.location.hostname
         ,gPath      = window.location.pathname.substr(0,window.location.pathname.substr(1).indexOf("/")+1)+"/"
         ,gUrl       = gProtocolo + gHost + gPath
         ,gProcJSON  = gUrl+"ajax.php"
         ,gProcesso  = gProcJSON;

      this.depurar     = true;
      this.console_log = [];

      /**
      * @description Retorna o mapa desejado. Retorna o array caso nao seja passado indice.
      * @param {Number} [pN] indice
      * @return {google.maps.Map}
      */
      this.mapa = function(n){
        return n || n == 0 ? gMapa[n] : gMapa;
      };

      /**
      * @description Retorna o marker desejado. Retorna o array caso nao seja passado indice.
      * @param {Number} [pN] indice
      * @return {google.maps.Marker}
      */
      this.marker = function(n){
        return n || n == 0 ? gMarker[n] : gMarker;
      };

      /**
      * @description Retorna o poi desejado. Retorna o array caso nao seja passado indice.
      * @param {Number} [pN] indice
      * @return {google.maps.Marker}
      */
      this.poi = function(n){
        return n || n == 0 ? gPoi[n] : gPoi;
      };

      /**
      * @description Retorna um array com todas as camadas de sobreposição ao mapa, com exceção dos markers.
      * @return {google.maps.[Polyline,Polygon,Rectangle,Circle,Marker,DirectionsRenderer,KmlLayer]}
      */
      this.camada = function(n){
        var camadas = [].concat(gLinha, gPoligono, gRetangulo, gCirculo, gPoi, gRota, gKml);
        return camadas;
      };

      /**
      * @description Retorna um array com todas as camadas de sobreposição ao mapa
      * @return {google.maps.[Polyline,Polygon,Rectangle,Circle,Marker,DirectionsRenderer,KmlLayer]}
      */
      this.sobreposicao = function(n){
        return [].concat(gMarker, gLinha, gPoligono, gRetangulo, gCirculo, gPoi, gRota, gKml);
      };

      /**
      * @description Retorna a URL atual
      * @return {String}
      */
      this.url = function(){
        return gUrl;
      };

      /**
      * @description Retorna a URL do processo
      * @return {String}
      */
      this.processo = function(){
        return gProcesso;
      };

      this.isEmpty = function(obj) {
        if (obj instanceof Array && !obj.length)
          return true;
        else if (typeof obj === "string" && !obj.length)
          return true;
        else if ($.isEmptyObject(obj) && typeof obj !== "string")
          return true;
        else
          return false;
      };

      /**
      * @description Faz chamada Ajax via jQuery, compativel com APEX
      * @param {Object} [p]
      * @param {String} [p.processo] processo de aplicação a ser executado
      * @param {String} [p.url="url padrao de processo de aplicação"] destino da solicitação
      * @param {String|Object{parametro:"valor"}} [p.param] parametros a serem enviados.
      * @param {String} [p.clob] parametro para ser enviado como clob para o apex
      * @param {Boolean} [p.cache=false] quando false, adiciona um _=[TIMESTAMP] no final da url
      * @param {Function} [p.retorno="função que retorna o output da solicitação"] função para tratar o retorno.
      */
      this.ajaxSql = function(p) {
        var vReturn
           ,vParam       = {}
           ,fReturn      = function(ret){vReturn = ret}
           ,vCrossDomain = false
           ,box;

        p             = p          || {};
        p.processo    = p.processo || "";
        p.url         = p.url      || "";
        p.param       = p.param    || {};
        p.cache       = p.cache    || false;
        p.retorno     = p.retorno  || fReturn;

        if (typeof p.param === "object")
            vParam = p.param;
        else
          if (typeof p.param === "string"){
            var params1 = p.param.split("&"),params2;
            for (var s1 = 0; s1 < params1.length; s1++){
              params2 = params1[s1].split("=");
              for (var s2 = 2; s2 < params2.length; s2++)
                params2[1] += "="+params2[s2];
              eval("vParam." + params2[0] + "=\"" + params2[1] + "\"");
            }
          }

        if (gThis.isEmpty(p.url)) {
          p.url           = "ajax.php";
          vParam.processo = p.processo;
        }

        if (p.url && (p.url.match(/http|https/gi) && !p.url.match(new RegExp(gHost,"gi"))))
          vCrossDomain = true;

        log(currentDateTime() + " => " + p.url + (!gThis.isEmpty(p.param) ? "?" + explainObject(vParam) : ""));
        $.ajaxq("filaAjax",{type: "GET"
                           ,url: p.url
                           ,data: vParam
                           ,async: p.retorno === fReturn ? false : true
                           ,success: p.retorno
                           ,cache: p.cache
                           ,beforeSend: startLoading
                           ,complete: stopLoading
                           ,error: function(jqXHR, textStatus, errorThrown){ log(textStatus); errorLoading(textStatus); }
                           ,jsonp: false
                           ,jsonpCallback: "JSONPReturn"
                           ,dataType: (vCrossDomain ? "jsonp" : null)
                           ,crossDomain: vCrossDomain
                           ,timeout: 30000
                           });

        if (vReturn) {
          gCriando = false;
          return vReturn;
        }

        function errorLoading(msg) {
          gThis.msgAjaxFalha("Erro ao carregar!");
          gCriando = false;
        }

        function stopLoading(jqXHR, textStatus) {
          if (textStatus === "success")
            box.fadeOut("slow", function(){ $(this).remove() });
        }

        function startLoading() {
          $("#msgAjaxFalha").remove();
          box = $("<div></div>")
                .attr("class","ajaxLoading")
                .css("display","block")
                .css("z-index","200")
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
        }
      }

      // Variaveis defaults
      var dZoom         = 13
         ,dTipoMapa     = gThis.tipo.mapa
         ,dMostraPOI    = false
         ,dLatitude     = gThis.ajaxSql({processo:"getLatitude"})
         ,dLongitude    = gThis.ajaxSql({processo:"getLongitude"})
         ,dCentroMapa   = gThis.latLng(dLatitude, dLongitude)
         ,dDivMapa      = "map-canvas"
         ,dManterFoco   = false
         ,dPermiteBalao = true
         ,dDivInfo      = "divInfo";

      /**
      * @description Mostra uma caixa com erro
      * @param {String} [msg] Define se a linha é clicável
      */
      this.msgAjaxFalha = function(msg) {
        $(".ajaxLoading,#msgAjaxFalha").remove();
        $("body").prepend(
          $("<div></div>")
          .attr("id","msgAjaxFalha")
          .css("display","block")
          .css("z-index","201")
          .css("position","absolute")
          .css("top","0px")
          .css("left","0px")
          .css("width","100%")
          .append($("<div></div>")
                  .css("margin","0 auto")
                  .css("padding","3px")
                  .css("background-color","#FCC")
                  .css("width","200px")
                  .css("text-align","center")
                  .css("line-height","25px")
                  .css("border","1px solid #E9C")
                  .append($("<span>"+(msg||"")+"</span>")
                          .css("font-weight","bold")
                          .css("color","#444")
                          .css("font-family","sans-serif")
                          .css("font-size","14px")
                  )
          )
        );
        setTimeout("$(\"#msgAjaxFalha\").fadeOut(\"slow\",function(){$(this).remove()})",6000);
      }

      /**
      * @description Constroi uma linha
      * @param {Object} [p]
      * @param {google.maps.LatLng[]} p.path Define os pontos que a linha ligará
      * @param {String} [p.cor="#F00"] Define a cor da linha
      * @param {Number} [p.opacidade="1"] Define a opacidade da linha
      * @param {Number} [p.espessura="2"] Define a espessura da linha
      * @param {google.maps.Map} [p.mapa] Define o mapa em que a linha será criada
      * @param {Number} [p.zIndex] Define o zIndex da linha em relação a outros poligonos
      * @param {Boolean} [p.clicavel="true"] Define se a linha é clicável
      * @returns {google.maps.Poyline} Linha criada
      */
      this.criaLinha = function(p) {
        p           = p           || {};
        p.path      = p.path      || null;
        p.cor       = p.cor       || "#F00";
        p.opacidade = p.opacidade || 1;
        p.espessura = p.espessura || 2;
        p.mapa      = p.mapa      || null;
        p.zIndex    = p.zIndex    || 5;
        p.clicavel  = p.clicavel  || true;
        return p.path && p.path.length ? new google.maps.Polyline({clickable: p.clicavel
                                                                  ,map: p.mapa
                                                                  ,path: p.path
                                                                  ,strokeColor: p.cor
                                                                  ,strokeOpacity: p.opacidade
                                                                  ,strokeWeight: p.espessura
                                                                  ,zIndex: p.zIndex}) : null;
      }

      /**
      * @description Constroi um polígono
      * @param {Object} [p]
      * @param {google.maps.LatLng[]} p.path Define os pontos que o polígono ligará
      * @param {String} [p.cor="#F00"] Define a cor do preenchimento
      * @param {Number} [p.opacidade="0.5"] Define a opacidade do preenchimento
      * @param {String} [p.corLinha="#F00"] Define a cor da linha
      * @param {Number} [p.opacidadeLinha="1"] Define a opacidade da linha
      * @param {Number} [p.espessuraLinha="2"] Define a espessura da linha
      * @param {google.maps.Map} [p.mapa] Define o mapa em que o polígono será criada
      * @param {Number} [p.zIndex] Define o zIndex do polígono em relação a outros poligonos
      * @param {Boolean} [p.clicavel="true"] Define se o polígono é clicável
      * @returns {google.maps.Poylgon} Polígono criado
      */
      this.criaPoligono = function(p) {
        p                = p           || {};
        p.path           = p.path      || null;
        p.cor            = p.cor       || "#F00";
        p.opacidade      = p.opacidade || 0.5;
        p.corLinha       = p.cor       || "#F00";
        p.opacidadeLinha = p.opacidade || 1;
        p.espessuraLinha = p.espessura || 2;
        p.mapa           = p.mapa      || null;
        p.zIndex         = p.zIndex    || 1;
        p.clicavel       = p.clicavel  || true;
        return p.path && p.path.length ? new google.maps.Polygon({clickable: p.clicavel
                                                                 ,map: p.mapa
                                                                 ,path: p.path
                                                                 ,fillColor: p.cor
                                                                 ,fillOpacity: p.opacidade
                                                                 ,strokeColor: p.corLinha
                                                                 ,strokeOpacity: p.opacidadeLinha
                                                                 ,strokeWeight: p.espessuraLinha
                                                                 ,zIndex: p.zIndex}) : null;
      }

      /**
      * @description Constroi um mapa
      * @param {Object} [p]
      * @param {String|DOMObject} [p.div="dDivMapa"] div para alocar o mapa
      * @param {Number} [p.zoom="dZoom"] nivel de zoom
      * @param {google.maps.LatLng} [p.centro="dCentroMapa()"] coordenadas para centralizar o mapa
      * @param {String} [p.tipo="dTipoMapa"] tipo de mapa
      * @param {Boolean} [p.mostraPOI="dMostraPOI"] mostrar ou não os POIs no mapa
      * @returns {google.maps.Map} mapa criado
      */
      this.criaMapa = function (p){
        p             = p           || {};
        p.zoom        = p.zoom      || dZoom;
        p.tipo        = p.tipo      || dTipoMapa;
        p.centro      = p.centro    || dCentroMapa;
        p.mostraPOI   = p.mostraPOI || dMostraPOI;
        var vElemento = typeof p.div !== "string" && p.div ? p.div : document.getElementById( (p.div ? p.div : dDivMapa) );
        var vOpcoes   = {
          zoom: p.zoom
         ,center: p.centro
         ,mapTypeId: p.tipo
        };
        var vN = gMapa.push(new google.maps.Map(vElemento,vOpcoes));
        if (p.mostraPOI)
          mostraPOI(vN - 1);
        return this.mapa(vN-1);
      };

      /**
      * @description Constroi Marker JSON
      * @param {Object|Object[]} [p]
      * @param {String} [p.url] Define a url para carregar o arquivo JSON
      * @param {String[]|Object{nome:valor}} [p.processo] Define os parametros do processo default para carregar o arquivo JSON.
      * @param {google.maps.Map} [p.mapa] Informe se desejar plotar o marker na sua criação.
      * @param {Boolean} [p.manterFoco="false"] Não ajusta/movimenta a tela na criação do marker.
      * @param {Boolean} [p.limpar=*] Limpa os markers da tela antes de construir outro(s).
      * @param {String} [p.infoWindowAppend=""] Adiciona o texto no final da infoWindow
      * @param {Function} [p.retorno] função de retorno para tratamento da função.
      */
      this.criaMarker = function(p){
        if (!gCriando) {
          gCriando       = true;
          var infowindow = null
             ,bound      = new google.maps.LatLngBounds();
          p = (gThis.isEmpty(p) && [{}]) || (p instanceof Array && p) || [p];

          function createMarker(dados, container){
            var pos, marker;
            marker     = new google.maps.Marker({position:  gThis.latLng(dados.coord.lat, dados.coord.lng)
                                                ,title:     dados.nome
                                                ,clickable: true
                                                ,icon:      dados.icone 
                                                ,zIndex:    10});
            pos        = container.push(marker);
            google.maps.event.addListener(container[pos-1], "click", function(){
                                                                     if (infowindow) infowindow.close();
                                                                     infowindow = new google.maps.InfoWindow({content: dados.msg + dados.infoWindowAppend});
                                                                     infowindow.open(container[pos-1].getMap(), container[pos-1]); 
                                                                   });
            return marker;
          }

          function createLine(dados){
            var pos, line, path = [], msg = (dados.nome ? "<strong>" + dados.nome + "</strong><br /><br />" : "") + dados.msg;
            for (var i = 0; i < dados.coord.length; i++)
              path.push(gThis.latLng(dados.coord[i].lat, dados.coord[i].lng));
            line = gThis.criaLinha({path:      path
                                   ,cor:       dados.cor
                                   ,opacidade: dados.opacidade
                                   ,espessura: dados.espessura});
            pos        = gLinha.push(line);
            google.maps.event.addListener(gLinha[pos-1], "click", function(event){
                                                                    if (infowindow) infowindow.close();
                                                                    infowindow = new google.maps.InfoWindow();
                                                                    infowindow.setContent(msg || "");
                                                                    infowindow.setPosition(event.latLng);
                                                                    infowindow.open(gLinha[pos-1].getMap()); 
                                                                  });
            return line;
          }

          function createPolygon(dados){
            var pos, poly, path = [], msg = (dados.nome ? "<strong>" + dados.nome + "</strong><br /><br />" : "") + dados.msg;
            for (var i = 0; i < dados.coord.length; i++)
              path.push(gThis.latLng(dados.coord[i].lat, dados.coord[i].lng));
            poly = gThis.criaPoligono({path:           path
                                      ,cor:            dados.cor
                                      ,opacidade:      dados.opacidade
                                      ,opacidadeLinha: 1
                                      ,espessura:      dados.espessura});
            pos  = gPoligono.push(poly);
            google.maps.event.addListener(gPoligono[pos-1], "click", function(event){
                                                                      if (infowindow) infowindow.close();
                                                                      infowindow = new google.maps.InfoWindow();
                                                                      infowindow.setContent(msg || "");
                                                                      infowindow.setPosition(event.latLng);
                                                                      infowindow.open(gPoligono[pos-1].getMap()); 
                                                                    });
            return poly;
          }

          function processar(p) {
            return function(data) {
              var novoObj, objArr = [];
              if (!gThis.isEmpty(p.limpar))
                gThis.limpaObj(p.limpar, p.limparContainer);
              if (data instanceof Array && data.length) {
                for (var i = 0; i < data.length; i++){
                  switch(data[i].tipo.toLowerCase()){
                    case "marker":
                      data[i].infoWindowAppend = p.infoWindowAppend;
                      novoObj = createMarker(data[i], gMarker);
                      !p.manterFoco && bound.extend(novoObj.getPosition());
                      break;
                    case "poi":
                      data[i].infoWindowAppend = p.infoWindowAppend;
                      novoObj = createMarker(data[i], gPoi);
                      !p.manterFoco && bound.extend(novoObj.getPosition());
                      break;
                    case "linha":
                      novoObj = createLine(data[i]);
                      !p.manterFoco && novoObj.getPath().forEach(function(element,index){ bound.extend(element) });
                      break;
                    case "poligono":
                      novoObj = createPolygon(data[i]);
                      !p.manterFoco && novoObj.getPaths().forEach(function(element,index){element.forEach(function(elm,idx){bound.extend(elm)})});
                      break;
                    default:
                      break;
                  }
                  p.mapa && novoObj.setMap(p.mapa);
                  objArr.push(novoObj);
                }
                (!p.manterFoco && p.mapa) && p.mapa.fitBounds(bound);
              }
              gCriando = false;
              p.retorno(objArr);
            }
          }

          for (var n = 0; n < p.length; n++)
            if (p[n] && (p[n].url || p[n].processo)) {
              p[n].url              = p[n].url              || gProcesso;
              p[n].limpar           = p[n].limpar           || [];
              p[n].limparContainer  = p[n].limparContainer  || undefined;
              p[n].infoWindowAppend = p[n].infoWindowAppend || "";
              p[n].retorno          = p[n].retorno          || function() {};
              p[n].manterFoco       = p[n].manterFoco !== false && !p[n].manterFoco ? (gThis.isEmpty(p[n].limpar) ? false : true) : p[n].manterFoco;

              gThis.ajaxSql({
                url:     p[n].url
               ,param:   p[n].processo
               ,retorno: processar(p[n])
              });
            }
        }
      };

      /**
      * @description Limpa um ou mais obj (todos caso nao seja passado nenhum parametro)
      * @param {google.maps.*|google.maps.*[]} pQual qual(ais) objeto(s) será(ão) limpo(s)
      */
      this.limpaObj = function(pQual, pContainer) {
        if (pQual) // se foi passado algum parametro
          if (pQual instanceof Array){ // é um array ?
            var vQual = copyArray(pQual);
            while (vQual.length > 0) { // executa loop até que o vetor esteja vazio (desenfileira sempre a base)
              deleta(vQual[0], pContainer || getOverlayContainer(vQual[0]));
              vQual.shift();
            }
          } else // é um objeto
            deleta(pQual, pContainer || getOverlayContainer(vQual));
        else { // se não foi passado nenhum parametro, todos serão apagados
          var array = copyArray(gThis.sobreposicao());
          while (array.length > 0) { // executa loop até que o vetor esteja vazio
            deleta(array[0], pContainer || getOverlayContainer(array[0]));
            array.shift();
          }
        }

        function deleta(obj, container) {
          if (isGoogleMapsObj(obj)) // É um objeto Google Maps ?
            if (obj.getMap())   // Esta no mapa ?
              obj.setMap(null); // Limpa do mapa
          if (container instanceof Array) // Foi passado container e é um array?
            if (!!~$.inArray(obj,container)) // Objeto está no array ?
              container.splice($.inArray(obj,container),1); // Remove do Array
        }
      };

      function getGoogleMapsInstance(obj){
        return obj instanceof google.maps.Marker             ? "Marker" :
               obj instanceof google.maps.Polyline           ? "Polyline" :
               obj instanceof google.maps.Polygon            ? "Polygon" :
               obj instanceof google.maps.Rectangle          ? "Rectangle" :
               obj instanceof google.maps.Circle             ? "Circle" :
               obj instanceof google.maps.KmlLayer           ? "KmlLayer" :
               obj instanceof google.maps.DirectionsRenderer ? "DirectionsRenderer" : 
               null;
      }

      function getOverlayContainer(obj){
        switch (getGoogleMapsInstance(obj)) {
          case "Marker":
            return gMarker; break;
          case "Polyline":
            return gLinha; break;
          case "Polygon":
            return gPoligono; break;
          case "Rectangle":
            return gRetangulo; break;
          case "Circle":
            return gCirculo; break;
          case "KmlLayer":
            return gKml; break;
          case "DirectionsRenderer":
            return gRota; break;
          default:
            return false; break;
        }
      }

      function isGoogleMapsObj(obj) {
        return getGoogleMapsInstance(obj) ? true : false;
      }

    // Alterna a visibilidade do marker
      this.toggleMarker = function(pMarker,pMapa) {
        function toggle(mkr,map){
          if (mkr.getMap())
            mkr.setMap(null);
          else
            mkr.setMap(map);
        }
        if (!pMarker)
          toggle(pMarker,pMapa);
        else
          for (var i in gMarker)
            toggle(gMarker[i],pMapa);
      };

      // Calcula a melhor rota entre dois locais
      // - Parâmetros
      //   - origem (*string ou google.maps.LatLng): Local de origem
      //   - destino (*string ou google.maps.LatLng): Local de destino
      //   - permiteAlterar (boolean\true): Permite que a rota seja alterada manualmente.
      //   - mapa (google.maps.Map\this.mapa): Informe se desejar plotar a rota na sua criação.
      //   - info (string ou objeto\null): Informe se desejar exibir a informação da rota na sua criação.
      this.calcularRota = function(p){
        p                = p                || {};
        p.origem         = p.origem         || dCentroMapa;
        p.destino        = p.destino        || dCentroMapa;
        p.permiteAlterar = p.permiteAlterar || true;
        p.mapa           = p.mapa           || gThis.mapa();
        p.info           = typeof p.info !== "string" && p.info ? p.info : document.getElementById( (p.info ? p.info : dDivInfo) );
        var vSolicitacao = {
            origin: p.origem
           ,destination: p.destino
           ,travelMode: google.maps.DirectionsTravelMode.DRIVING
          };
        if (gRota.length && gRota[0]) {
          gRota[0].setMap(null); 
          gRota[0].setPanel(null);
        }
        gRota[0]     = new google.maps.DirectionsRenderer( {draggable: p.permiteAlterar} );
        var vServico = new google.maps.DirectionsService();
        vServico.route(vSolicitacao, function(response, status) {
                                       if (status == google.maps.DirectionsStatus.OK) {
                                         gRota[0].setPanel(p.info);
                                         gRota[0].setMap(p.mapa);
                                         gRota[0].setDirections(response);
                                       }
                                     });
        return gRota[0];
      };

      // Retorna as coordenadas de um endereço
      // - pEndereco (*string\null): Endereço a ser pesquisado
      // - pRetorno (*function\null): função de retorno
      this.localizarEndereco = function(pEndereco, pRetorno){
        pRetorno = pRetorno || function(p){};
        var vResultado
           ,vGeocoder = new google.maps.Geocoder();
        vGeocoder.geocode( { "address": pEndereco}, function(results, status) {
                                                      if (status == google.maps.GeocoderStatus.OK) {
                                                        vResultado = results[0].geometry.location;
                                                        pRetorno(vResultado);
                                                      } else
                                                        alert("Não foi possível localizar o endereço fornecido! erro: " + status);
                                                    });
        return vResultado;
      };

      // Retorna o endereço de uma coordenada
      // - pLatLng (google.maps.LatLng): Coordenada a ser pesquisada
      // - pRetorno (*function\null): função de retorno
      this.localizarCoordenada = function(pLatLng, pRetorno){
        pRetorno = pRetorno || function(p){};
        var vResultado
           ,vRetorno  = {numero:"", rua:"", bairro:"", cidade:"", estado:"", pais:"", cep:"", completo:""}
           ,vGeocoder = new google.maps.Geocoder();
        if (pLatLng instanceof google.maps.LatLng)
          vGeocoder.geocode({"latLng": pLatLng}, function(results, status) {
                                                   if (status == google.maps.GeocoderStatus.OK) {
                                                     vRetorno.completo = results[0].formatted_address;
                                                     vResultado = results[0].address_components;
                                                     for (var i=0; i < vResultado.length; i++)
                                                       switch (vResultado[i].types[0]) {
                                                         case "street_number": 
                                                           vRetorno.numero = vResultado[i].long_name; break;
                                                         case "route": 
                                                           vRetorno.rua = vResultado[i].long_name; break;
                                                         case "sublocality": 
                                                           vRetorno.bairro = vResultado[i].long_name; break;
                                                         case "locality": 
                                                           vRetorno.cidade = vResultado[i].long_name; break;
                                                         case "administrative_area_level_1": 
                                                           vRetorno.estado = vResultado[i].long_name; break;
                                                         case "country": 
                                                           vRetorno.pais = vResultado[i].long_name; break;
                                                         case "postal_code": 
                                                           vRetorno.cep = vResultado[i].long_name; break;
                                                         default: break;
                                                       }
                                                     pRetorno(vRetorno);
                                                   } else
                                                     alert("Não foi possível localizar o endereço fornecido! erro: " + status);
                                                 });
        //return vRetorno;
      };

      function getArrayPosition(arrayObj,arrayItemObj){
        for (var i=0; i < arrayObj.length; i++)
          if (arrayObj[i] === arrayItemObj)
            return i;
      }

      function lpad(pString,pLength,pChar) {
        var vString = (isNaN(pString))?pString:pString.toString();
        var vLength = pLength-vString.length;
        if (vLength <= 0)
          return pString;
        var vChar   = (isNaN(pChar))?pChar:pChar.toString();
        if (vChar.length == 1)
          for (i=0;i < vLength;i++)
            vString = vChar+vString;
        return vString;
      }

      function currentDateTime(){
        var data = new Date();
        return lpad(data.getDate(),2,"0")+"/"
              +lpad(data.getMonth()+1,2,"0")+"/"
              +     data.getFullYear()+" "
              +lpad(data.getHours(),2,"0")+":"
              +lpad(data.getMinutes(),2,"0")+":"
              +lpad(data.getSeconds(),2,"0");
      }

      function explainObject(obj){
        var vObj = "";
        for (var n in obj)
          if(obj.hasOwnProperty(n))
            vObj += n + "=" + obj[n] + "&";
        return vObj ? vObj.substr(0,vObj.length-1) : "";
      }

      function copyArray(arr){
        return arr.slice();
      }

      function log(a) {
        if (gThis.depurar){
          var console = console || window.console || null;
          console && console.log(a);
        }
        gThis.console_log.push(a);
      }

    }
    window.geoequipe = new Geoequipe();