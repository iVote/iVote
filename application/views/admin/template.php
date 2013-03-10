<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title> <?php  echo isset($title) ? $title : 'iVote'; ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

    <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/bootstrap-responsive.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/main.css">

    <script src="<?php echo base_url(); ?>public/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
  </head>

  <body>
  <!--[if lt IE 7]>
  <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
  <![endif]-->

    <div class="container-fluid"> 

      <header>
        <?php $this->load->view('admin/_includes/nav.php'); ?>  
        <?php $this->load->view('admin/_includes/header.php'); ?>  
      </header> 
      
      <?php isset($main_content) ? $this->load->view('admin/pages/' . $main_content) : ""; ?>

    </div>

    <?php $this->load->view('admin/_includes/footer.php'); ?>


    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="<?php echo base_url(); ?>public/js/vendor/jquery-1.9.0.min.js"><\/script>')</script>
    <script src="<?php echo base_url(); ?>public/js/vendor/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>public/js/plugins.js"></script>
    <script src="<?php echo base_url(); ?>public/js/main.js"></script>

  </body>
</html>
