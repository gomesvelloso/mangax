<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
    <link rel="canonical" href="https://getbootstrap.com/docs/3.3/examples/offcanvas/">

    <title>MANGAX</title>
    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url("assets/css/bootstrap.min.css")?>"  rel="stylesheet">
    
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="<?php echo base_url("assets/css/ie10-viewport-bug-workaround.css")?>" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php echo base_url("assets/css/offcanvas.css")?>" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="<?php echo base_url("assets/js/ie-emulation-modes-warning.js")?>"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body  style="background-color: #f5f5f5;"> 
    <nav class="navbar navbar-fixed-top navbar-inverse">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo base_url()?>">MANGAX</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
        
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#about">Meus Pedidos</a></li>
            <li><a href="#contact">Minha Conta</a></li>
            <li><a href="#contact">Contato</a></li>
            
          </ul>
          <form class="navbar-form navbar-right">
            <div class="form-group">
              <select class="form-control"><?php echo $optionCategorias?></select>
            </div>
            <div class="form-group">
              <input type="text" placeholder="Pesquisar" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Pesquisar</button>
          </form>
         
        </div><!-- /.nav-collapse -->
      </div><!-- /.container -->
    </nav><!-- /.navbar -->

    <div class="container">

      <div class="row row-offcanvas row-offcanvas-right">

        <div class="col-xs-12 col-sm-9">
          <p class="pull-right visible-xs" style="margin-top: 3px;">
            <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Categorias</button>
          </p>  
          <div class="jumbotron" style="display: <?php echo $display?>">
            <h1><?php echo $jumbotron?></h1>
          </div>
          <div class="row"style="margin-top: 35px; margin-left:-25px;">
            <?php echo $objetos?>
            <!--/.col-xs-6.col-lg-4-->
          </div><!--/row-->
        </div><!--/.col-xs-12.col-sm-9-->

        <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar">
          <div class="list-group">
            <?php echo $linkCategorias?>
          </div>
        </div><!--/.sidebar-offcanvas-->
      </div><!--/row-->