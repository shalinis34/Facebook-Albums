<?php require_once 'config.php';?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Facebook  Albums </title>
<!--   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>-->
   <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL ;?>/assets/css/custom.css">
 <link rel="stylesheet" href="<?php echo BASE_URL ;?>/assets/css/animations.css">
<!--  <link rel="stylesheet" href="https://raw.githubusercontent.com/daneden/animate.css/master/animate.css">-->
 
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!--       <script src="<?php echo BASE_URL ;?>/assets/js/css3-animate-it.js"></script>-->
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script>
        function animationHover(element, animation){
    element = $(element);
    element.focus(
           function() {
            element.addClass('animated ' + animation);
        },
        function(){
            //wait for animation to finish before removing classes
            window.setTimeout( function(){
                element.removeClass('animated ' + animation);
            }, 2000);
        });
   }
   $(document).ready(function(){
    $('.section-heading').focus(function() {
        animationHover(this, 'bounceInDown');
    });
});
   
    </script>
  </head>
    <div id="cover">
                        <div id="progress"><div class="progress-label">Loading...</div></div>
   </div>
  <body>
 <header>
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo BASE_URL ;?>">Facebook Album </a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="<?php echo BASE_URL ;?>/work.php">How it work</a>
                    </li>
                    <li>
                        <a href="<?php echo BASE_URL ;?>/member.php">Album Section</a>
                    </li>
                     <?php
                        if (isset($_SESSION['fb_access_token'])) {
                        ?>
                    <li>
                        <a href="<?php echo BASE_URL ;?>/logout.php">Logout</a>
                    </li>
                    <?php } ?>

                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
  </header>