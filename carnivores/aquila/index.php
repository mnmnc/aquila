
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="">

    <title>aquila @ carnivores</title>

    <!-- Bootstrap core CSS -->
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/modify.css" rel="stylesheet">
    <style type="text/css">
        #map-canvas { height: 500px; }
    </style>


    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../bootstrap/js/ie8-responsive-file-warning.js"></script><![endif]-->

  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="../aquila/index.php">carnivores / aquila</a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class=""><a href="../index.php"><span class="glyphicon glyphicon-home"></span></a></li>
            <li class="dropdown active">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">tools<b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="../medved/medved.php">mèdved</a></li>
                <li><a href="../aquila/">aquila</a></li>
              </ul>
            </li>
            <li class=""><a href="archive.php" >archive</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
    <div class="container visible-xs" style='height:1em'></div>
    <div class="container visible-sm visible-md visible-lg" >
      <div class="page-header">
        <h1><img src="../img/aquila3.png" alt="medved-logo">aquila <small> visual traceroute</small></h1>
      </div>
    </div>

    <div class="container">
      <form role="form" action="">
        <div class="form-group">
          <div class='input-group'>
            <input type="text" class="form-control" id="ip_address" placeholder="Enter IP address or domain"/>
            <span class="input-group-btn">
              <button class="btn btn-primary" type="button" onclick="javascript:trace();"><span class='glyphicon glyphicon-globe'></span> Trace route</button>
              <a class="btn btn-default log_toggle" role="button" id="log_button" style='display:none'><span class='glyphicon glyphicon-list'></span>&nbsp;Show log</a>
            </span>
          </div>
        </div>
      </form>
      <div class="container visible-xs" style='height:1em'></div>
    </div>

    <!-- NOTIFICATIONS -->
    <div class='container'>
    <div class="alert alert-info" id="tracing_progress" style='display:none'><span class='glyphicon glyphicon-tasks'></span> <b>Tracing in progress.</b> <span class='pull-right' id='tracing_status'>Please wait.</span></div>
      <div class="alert alert-success" id="geolocation_progress" style='display:none'><span class='glyphicon glyphicon-globe'></span> <b>Geolocation in progress.</b> <span class='pull-right' id='geolocation_status'>Please wait.</span></div>
    </div>
    <!-- NOTIFICATIONS END -->

    <!-- TRACE TABLE -->
    <div class="container" id="trace_container" style='display:none' >
      <div class="panel panel-default">
        <div class="panel-heading" style='padding-top:4px; padding-bottom: 0px'>
          <h4><span id='trace_head'> </span> <small><span class='pull-right glyphicon glyphicon-eye-close' id='trace_collapse_close'></span><span class='pull-right glyphicon glyphicon-eye-open' id='trace_collapse_open' style='display:none'></span></small></h4>
        </div>
        <div class="panel-body" style='padding-bottom:0px'>
          <div id="trace_data" class='container trace_data table-responsive' style='display: table-cell'>
            <table class="table table-condensed table-hover trace_data_table" >
              <tr>
                <th>#</th>
                <th>ip</th>
                <th>hostname</th>
                <th>as</th>
                <th>city</th>
                <th>country</th>
                <th>delay</th> 
                <th>lat</th>
                <th>lng</th>
              </tr>
            </table>
          </div>
        </div>
    </div>
    </div>
    <!-- TRACE TABLE END -->

    <!-- MAP BEGIN -->
    <div class="container" style='display:none' id="map">
      <div class="panel panel-default">
        <div class="panel-heading" style='padding-top:4px; padding-bottom: 0px'>
          <h4><span id='geolocation_head'>Geolocation results:</span><small><span class='pull-right glyphicon glyphicon-eye-close' id='geolocation_collapse_close'></span><span class='pull-right glyphicon glyphicon-eye-open' id='geolocation_collapse_open' style='display:none'></span></small></h4>
        </div>
        <div class="panel-body" style='padding-bottom:0px'>
          <div id="map-canvas"> </div>
        </div>
      </div>
    </div>
    <!-- MAP END -->

    <!-- LOG -->
    <div class='container' id='log_container' style='display: none'>
      <div class="panel panel-default">
        <div class="panel-heading" style='padding-top:4px; padding-bottom: 0px'>
          <h4><span id='log_head'>Raw traceroute log:</span><small><span class='pull-right glyphicon glyphicon-eye-close' id='log_collapse_close'></span><span class='pull-right glyphicon glyphicon-eye-open' id='log_collapse_open' style='display:none'></span></small></h4>
        </div>
        <div class="panel-body" style='padding-bottom:0px'>
          <pre id='log'></pre>
        </div>
      </div>
    </div>
    <!-- LOG END -->
    <div id='footer' style='min-height:30px'>    </div>
    <script src="../js/jquery.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src='../js/shortcut.js'></script>
    <script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAFlzic_WhgOK2Bn9fVxdnT_Ql3m2pqm3k&sensor=false">
    </script>
    <script>
    // GLOBAL VARIABLES
    var ADDRESSES = new Array();
    var TRACE_FINISHED = 0;
    var GEODATA_COLLECTED = 0;
    var LOADING_GEO_DATA_FINISHED = 0;
    var GEO_DATA = new Array();
    var ALL_DATA = new Array();
    var map;
    var bounds = new google.maps.LatLngBounds();


    // FUNCTIONS
    
    function get_ip(){
      return $('input#ip_address').val();
    }

    $('#log_button').click( function(){
      $('#log_container').toggle(500);
      $(this).toggleClass("btn-default").toggleClass("btn-info");
    });

    $('#trace_collapse_close').click( function(){
        $('#trace_data').toggle(300);
        $('#trace_head').css('color', "#777").css('font-size', "0.8em");
        $('#trace_collapse_close').hide(100);
        $('#trace_collapse_open').show(100);
    });

    $('#trace_collapse_open').click( function(){
        $('#trace_data').toggle(300);
        $('#trace_head').css('color', "").css('font-size', "");
        $('#trace_collapse_open').hide(100);
        $('#trace_collapse_close').show(100);
        
    });

    $('#log_collapse_close').click( function(){
        $('#log').toggle(300);
        $('#log_head').css('color', "#777").css('font-size', "0.8em");
        $('#log_collapse_close').hide(100);
        $('#log_collapse_open').show(100);
    });

    $('#log_collapse_open').click( function(){
        $('#log').toggle(300);
        $('#log_head').css('color', "").css('font-size', "");
        $('#log_collapse_open').hide(100);
        $('#log_collapse_close').show(100);
    });

    $('#geolocation_collapse_close').click( function(){
        $('#map-canvas').hide(300);
        $('#geolocation_head').css('color', "#777").css('font-size', "0.8em");
        $('#geolocation_collapse_close').hide(100);
        $('#geolocation_collapse_open').show(100);
    });

    $('#geolocation_collapse_open').click(function(){
        $('#map-canvas').show();
        $('#geolocation_head').css('color', "").css('font-size', "");
        $('#geolocation_collapse_open').hide(100);
        $('#geolocation_collapse_close').show(100);
        show_map_trace();
        map.fitBounds(bounds);
    });

    $(document).ready(function(){
        $('input#ip_address').focus();
    });
    shortcut.add("enter",function() {
        trace();
    });


    // EXECUTED TRACEROUTE WITH AJAX REQUEST
    function trace(){
      // VARIABLES
      var IP_ADDRESS = get_ip();
      $('#tracing_progress').show(100);
      
      if ( IP_ADDRESS != null){
          $.getJSON( "aquila_ajax.php?q="+IP_ADDRESS, function( trace_data ) {

              // PARSE RETURNED DATA
              var trace = trace_data.trace_results;
              var log = trace_data.log;
              var log_parsed = log.replace(/\^/g, "\n");
              $('#log').append(log_parsed);

              for (var i = 0; i < trace.length ; i++ ){
                  if (trace[i].ip != null ){
                      if (trace[i].id == 999 ){
                          console.log(trace[i]);
                          var element = new Object();
                          element.destination = trace[i].ip + " " + trace[i].as ;
                          element.log = log_parsed;
                          ALL_DATA.push(element);
                          // SET TITLE
                          $('#trace_head').html("Trace results to: " + trace[i].ip + " " + trace[i].as + " " + trace[i].delay );
                      }
                      else {

                          // APPENDING ROW
                          var ip_for_id = ((trace[i].ip).trim()).replace(/\./g, "_");
                          var table_row = "<tr><td>"+ (trace[i].id).trim()+"</td><td class='ip_address_cell' id='ip_" + (trace[i].ip).trim() + "'>"+ (trace[i].ip).trim() + "</td><td id='hostname_"+ ip_for_id +"'>"+ '-' +"</td><td>"+ (trace[i].as).trim() +"</td><td id='city_"+ip_for_id+"'>"+ '-' +"</td><td id='country_"+ip_for_id+"'>" + '-' +"</td><td>" + (trace[i].delay).trim() +"</td><td id='lat_"+ip_for_id+"'>" + '-' +"</td><td id='lng_"+ip_for_id+"'>"+ '-'+"</td></tr>";
                          $('.trace_data_table').append(table_row);

                          // ADDING IP TO GLOBAL VARIABLE
                          var hop = { 'ip': (trace[i].ip).trim(), 'hop': (trace[i].id).trim() };
                          ADDRESSES.push( hop );

                          var element = new Object();
                          element.ip = (trace[i].ip).trim(); 
                          element.id = (trace[i].id).trim();
                          element.as = (trace[i].as).trim();
                          element.delay = (trace[i].delay).trim();
                          ALL_DATA.push(element);
                      }
                  }
              }
              TRACE_FINISHED = 1;
              $('#trace_container').show(100);
              $('#log_button').show();
              
              $('#tracing_status').html("<span class='glyphicon glyphicon-ok'></span> Done.");
              $('#tracing_progress').hide(100);
          });
      }
    }

    function geolocate(){
      $('#geolocation_progress').show(100);
      // REQUESTING GEOLOCATION OF ADDRESSES
      var query = "";
      for (var i = 0; i < ADDRESSES.length; i++ ){
          if ( i < (ADDRESSES.length -1) ){
            query += ADDRESSES[i].hop + ":" + ADDRESSES[i].ip + ",";
          }
          else {
            query += ADDRESSES[i].hop + ":" + ADDRESSES[i].ip;
          }
      }

      var COORDS = new Array();

        $.getJSON( "aquila_geo.php?q="+query, function( geolocation_data ) {
            for (var i = 0; i < geolocation_data.length; i++){
              var ip_data = new Object();
              ip_data.id = i + 2;
              ip_data.hostname = geolocation_data[i].hostname;
              ip_data.ip = geolocation_data[i].ip;
              ip_data.city = geolocation_data[i].city;
              ip_data.country = geolocation_data[i].country;

              if ( COORDS.length > 0){
                  for (var j = 0; j < COORDS.length; j++){
                    if ( COORDS[j] == geolocation_data[i].lat || COORDS[j] == geolocation_data[i].lng ){
                       geolocation_data[i].lat = (parseFloat(geolocation_data[i].lat) + 0.01).toFixed(4);
                       geolocation_data[i].lng = (parseFloat(geolocation_data[i].lng) + 0.01).toFixed(4);
                    }
                  }
                  COORDS.push(geolocation_data[i].lat);
                  COORDS.push(geolocation_data[i].lng);
                  ip_data.lat = geolocation_data[i].lat;
                  ip_data.lng = geolocation_data[i].lng;
              }
              else {
                  COORDS.push(geolocation_data[i].lat);
                  COORDS.push(geolocation_data[i].lng);
                  ip_data.lat = geolocation_data[i].lat;
                  ip_data.lng = geolocation_data[i].lng;
              }

              ip_data.lat = geolocation_data[i].lat;
              ip_data.lng = geolocation_data[i].lng;
              if ( ip_data.lat != null){
                GEO_DATA.push(ip_data);
                for (var k = 0; k < ALL_DATA.length; k++){
                  if (ALL_DATA[k].ip == geolocation_data[i].ip){
                    ALL_DATA[k].hostname = ip_data.hostname;
                    ALL_DATA[k].city = ip_data.city;
                    ALL_DATA[k].country = ip_data.country;
                    ALL_DATA[k].lat = ip_data.lat;
                    ALL_DATA[k].lng = ip_data.lng;
                    ALL_DATA[k].id = ip_data.id;
                    break;
                  }
                }

              }
            }
            GEODATA_COLLECTED = 1;
            $('#geolocation_status').html("<span class='glyphicon glyphicon-ok'></span> Done.");
        });
    }

    function load_geo_data(){
      for (var i =0; i < GEO_DATA.length; i++){
        var ip_modified = (GEO_DATA[i].ip).replace(/\./g, "_");
        $('#hostname_'+ ip_modified).text(GEO_DATA[i].hostname);
        $('#city_'+ ip_modified).text(GEO_DATA[i].city);
        $('#country_'+ ip_modified).text(GEO_DATA[i].country);
        $('#lat_'+ ip_modified).text(GEO_DATA[i].lat);
        $('#lng_'+ ip_modified).text(GEO_DATA[i].lng);
      }
      LOADING_GEO_DATA_FINISHED = 1;
    }

    function show_map_trace(){

          var flightPlanCoordinates = new Array();
          
          $('#map').show();
          initialize();

          for (var i = 0; i < GEO_DATA.length; i++){
              if ( GEO_DATA[i].lat != null && GEO_DATA[i].lat != "" && GEO_DATA[i].lng != null && GEO_DATA[i].lng != "" ){
                flightPlanCoordinates.push( new google.maps.LatLng( parseFloat(GEO_DATA[i].lat), parseFloat(GEO_DATA[i].lng) ) );
                bounds.extend( new google.maps.LatLng( parseFloat(GEO_DATA[i].lat), parseFloat(GEO_DATA[i].lng) ) );
              }
              
              
              var marker = new google.maps.Marker({ 
                position: new google.maps.LatLng( parseFloat(GEO_DATA[i].lat), parseFloat(GEO_DATA[i].lng) ),
                animation: google.maps.Animation.DROP, 
                map: map, 
                title: GEO_DATA[i].ip
              }); 

              marker['infowindow'] = new google.maps.InfoWindow({
                content: "<div style='width:400px'>IP: <b>" + GEO_DATA[i].ip + "</b><br>Hostname: " + GEO_DATA[i].hostname + "<br>Country: " + GEO_DATA[i].country + "<br>City: " + GEO_DATA[i].city +"</div>"
              });

              google.maps.event.addListener(marker, 'click', function() {
                  this['infowindow'].open(map, this);
              });

          }

          var flightPath = new google.maps.Polyline({
            path: flightPlanCoordinates,
            geodesic: true,
            strokeColor: '#000',
            strokeOpacity: 0.7,
            strokeWeight: 1.5
          });

          flightPath.setMap(map); 
          $('#geolocation_progress').hide(100);
          
    }

    function save_to_file(){
      var results = "";
      for ( var i = 0; i < ALL_DATA.length; i++ ){
        if ( i == 0 ){
            console.log("desc");

            // FIX ALL_DATA[i].log
            results += "destination=" + ALL_DATA[i].destination  + "|log=" + ALL_DATA[i].log;

        }
        else {
          console.log("data");
            var id = "id=" + ALL_DATA[i].id;
            var ip = "|ip=" +ALL_DATA[i].ip;
            var hostname = "|hostname="+ ALL_DATA[i].hostname;
            var delay = "|delay="+ ALL_DATA[i].delay;
            var as = "|as=" +ALL_DATA[i].as;
            var city = "|city=" +ALL_DATA[i].city;
            var country = "|country="+ ALL_DATA[i].country;
            var lat = "|lat=" +ALL_DATA[i].lat;
            var lng = "|lng="+ ALL_DATA[i].lng;
            results += "^" + id + ip + hostname + delay + as + city + country + lat + lng;
        }
      }
    console.log("results" + " " + results);
      $.post( "aquila_ajax.php", { r: results })
        .done(function( data ) {
          var none = 0;
      });
    }


    // REGULAR CHECKS
    window.setInterval(function(){
        if ( TRACE_FINISHED == 1){
            TRACE_FINISHED = 0;
            geolocate();
        }
        if ( GEODATA_COLLECTED == 1){
          GEODATA_COLLECTED = 0;
          load_geo_data();
          
        }
        if (LOADING_GEO_DATA_FINISHED == 1){
          LOADING_GEO_DATA_FINISHED = 0;
          show_map_trace();
          map.fitBounds(bounds);
          console.log(ALL_DATA);
          save_to_file();
        }
    }, 500);

    </script>


  <!-- 
    =================================================================================

      MAP INIT SCRIPT
  -->
    <script type="text/javascript">
      
      var brooklyn = new google.maps.LatLng(50.0, 21.9455);

      var MY_MAPTYPE_ID = 'custom_style';

      function initialize() {

        var featureOpts = [
          {
            stylers: [
              { hue: '#208920' },
              { visibility: 'simplified' },
              { gamma: 0.5 },
              { weight: 0.5 }
            ]
          },
          {
            elementType: 'labels',
            stylers: [
              { visibility: 'on' }
            ]
          },
          {
            featureType: 'water',
            stylers: [
              { color: '#208920' }
            ]
          }
        ];

        var mapOptions = {
          zoom: 9,
          center: brooklyn,
          mapTypeControlOptions: {
            mapTypeIds: [google.maps.MapTypeId.ROADMAP, MY_MAPTYPE_ID]
          },
          mapTypeId: MY_MAPTYPE_ID
        };

        map = new google.maps.Map(document.getElementById('map-canvas'),
            mapOptions);

        var styledMapOptions = {
          name: 'Custom Style'
        };

        var customMapType = new google.maps.StyledMapType(featureOpts, styledMapOptions);

        map.mapTypes.set(MY_MAPTYPE_ID, customMapType);

          /*var flightPlanCoordinates = [
            new google.maps.LatLng(50.25, 19.0255),
            new google.maps.LatLng(52.25, 21),
            new google.maps.LatLng(48.86, 2.35)
          ];
          var flightPath = new google.maps.Polyline({
            path: flightPlanCoordinates,
            geodesic: true,
            strokeColor: '#EE4040',
            strokeOpacity: 0.7,
            strokeWeight: 1.5
          });

          flightPath.setMap(map);*/
      }

      google.maps.event.addDomListener(window, 'load', initialize);

    </script>
  <!-- MAP INIT SCRIPT END -->
  </body>
</html>


