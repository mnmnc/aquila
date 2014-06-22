
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
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">tools<b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="../medved/medved.php">mèdved</a></li>
                <li><a href="../aquila/">aquila</a></li>
              </ul>
            </li>
            <li class="active"><a href="archive.php" >archive</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
    <div class="container visible-xs" style='height:1em'></div>
    <div class="container visible-sm visible-md visible-lg" >
      <div class="page-header">
        <h1><img src="../img/aquila3.png" alt="medved-logo">aquila <small> archive</small></h1>
      </div>
    </div>

    <!-- ARCHIVE CONTENT -->
    <div class='container archive table-responsive hidden-xs'>
      <table class="table table-condensed table-hover archive_table" id="archive_table" >
        <tr>
          <th>#</th>
          <th>ip</th>
          <th>hostname</th>
          <th style='text-align:center'>reached</th>
          <th>date</th>
          <th style='text-align:center'>download</th>
        </tr>
      </table>
    </div>
    <div class='container archive table-responsive visible-xs'>
      <table class="table table-condensed table-hover archive_table" id="archive_table_small" style='font-size: 0.8em'>
        <tr>
          <th>#</th>
          <th>ip</th>
          <th>host</th>
          <th style='text-align:center'><span class=' glyphicon glyphicon-flash'></span></th>
          <th>date</th>
          <th style='text-align:center'><span class='glyphicon glyphicon-cloud-download'></span></th>
        </tr>
      </table>
    </div>
    <!-- ARCHIVE END -->
    
    <div id='footer' style='min-height:30px'>    </div>
    <script src="../js/jquery.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src='../js/shortcut.js'></script>
    
    
    <script>
    $(document).ready( function (){
        $.getJSON( "aquila_ajax.php?archive<?php if ( isset( $_GET['domain'] ) ) { $domain = $_GET['domain']; echo '='.$domain; } ?>", function( data ) {
          console.log(data);
          var table = data.table;
          for (var i = 0; i < table.length; i++){
              var anchor = "<a href='"+ table[i].filename +"'>" + "<span class='glyphicon glyphicon-cloud-download'></span>" + "</a>";
              if (table[i].reached != 0){
                $('.archive_table').append("<tr><td>" + (i+1) + "</td><td>" + table[i].ip + "</td><td><a href='archive.php?domain=" + table[i].name + "'>" + table[i].name + "</a></td><td style='text-align:center'><span class=' glyphicon glyphicon-flash' style='color:#DAA520'></span></td><td>" + table[i].date + " " + table[i].time + "</td><td style='text-align: center'>" + anchor +"</td></tr>");
              }
              else {
                $('.archive_table').append("<tr><td>" + (i+1) + "</td><td>" + table[i].ip + "</td><td><a href='archive.php?domain=" + table[i].name + "'>" + table[i].name + "</td><td></td><td>" + table[i].date + " " + table[i].time + "</td><td style='text-align: center'>" + anchor +"</td></tr>");
              }
          }
        });
    });
    

    </script>


  
  </body>
</html>


