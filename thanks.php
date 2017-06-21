<?php
  session_start();

  // echo('<pre>');
  // var_dump($_SESSION['signup']['country']);
  // var_dump($_SESSION['signup']['style']);
  // echo('</pre>');

  // unset($_SESSION['signup']);


  //ユーザーIDをDBから取ってきて、mypageへ繋ぐ処理
  //DBへ接続
  require('dbconnect.php');

  //セッションにデータがなかったらsignup.phpへ遷移（ok）
  if (!isset($_SESSION['signup'])) {
    header("Location: signup.php");
  }


  $email=htmlspecialchars($_SESSION['signup']['email'], ENT_QUOTES, 'UTF-8');

  // var_dump($email);

  if (!empty($_SESSION)) {
  $sql = sprintf('SELECT `user_id` FROM `users` WHERE `email` = "%s"',
      mysqli_real_escape_string($db,$email)
      );
      //SQL文の実行と変数への代入
      $select_user_ids = mysqli_query($db,$sql) or die(mysqli_error($db));
      $select_user_id = mysqli_fetch_assoc($select_user_ids);
  }

  // var_dump($select_user_id);

  unset($_SESSION['signup']);

  // var_dump($select_user_id['user_id']);

  $_SESSION['login_user_id'] = $select_user_id['user_id'];


?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>FLY HIGH</title>
<meta name="description" content="">
<meta name="author" content="">

<!-- Bootstrap -->
<link rel="stylesheet" type="text/css"  href="css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="fonts/font-awesome/css/font-awesome.css">

<!-- Stylesheet
    ================================================== -->
<link rel="stylesheet" type="text/css"  href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/prettyPhoto.css">
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800,600,300' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css"  href="css/signup.css">
<link rel="stylesheet" type="text/css"  href="css/thanks.css">
<script type="text/javascript" src="js/modernizr.custom.js"></script>

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
<div id="preloader">
  <div id="status"> <img src="img/preloader.gif" height="64" width="64" alt=""> </div>
</div>
<!-- Navigation -->
<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse"> <i class="fa fa-bars"></i> </button>
      <a class="navbar-brand page-scroll" href="#page-top"> <img class="header-logo" src="img/flyhigh_logo_white.png" width="27px" height="27px"> Fly High</a> </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
      <ul class="nav navbar-nav">
        <!-- Hidden li included to remove active class from about link when scrolled up past about section -->
        <li class="hidden"> <a href=""></a> </li>
        <li> <a class="page-scroll" href="#style">Style</a> </li>
        <li> <a class="page-scroll" href="#country">Country</a> </li>
      </ul>
    </div>
    <!-- /.navbar-collapse -->
  </div>
  <!-- /.container -->
</nav>

<!-- Header -->
<div id="intro">
  <div class="intro-body bg">
    <div class="container box">
      <h1>Thanks</h1>
                <p class="lead">ご登録ありがとうございます</p>
                <br><br><br>
        <div class="row">
            <div class="col-sm-offset-4 col-sm-4">
              <div class="text-center">
                <!-- <button href="signup.php" type="submit" class="btn btn-default"> -->
                <a href="mypage.php" type="button" class="btn btn-default">my pageへ<span class="angle">&nbsp;&raquo;</span></a>
                <!-- </button> -->
              </div>
            </div>
        </div>
    </div>
  </div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script type="text/javascript" src="js/jquery.1.11.1.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script type="text/javascript" src="js/bootstrap.js"></script>
<script type="text/javascript" src="js/SmoothScroll.js"></script>
<script type="text/javascript" src="js/jquery.prettyPhoto.js"></script>
<script type="text/javascript" src="js/jquery.isotope.js"></script>
<script type="text/javascript" src="js/jquery.parallax.js"></script>
<script type="text/javascript" src="js/jqBootstrapValidation.js"></script>
<script type="text/javascript" src="js/contact_me.js"></script>
<script type="text/javascript" src="js/signup.js"></script>

<!-- Javascripts
    ================================================== -->
<script type="text/javascript" src="js/main.js"></script>
</body>
</html>