<?php
//セッションスタート
session_start();

//DBへ接続
require('dbconnect.php');

//入力されたメールアドレスを使って、ユーザーを特定し、ハッシュ化された文字列をテーブルへUPDATEする
  //メールアドレスの入力でスタート
  if(isset($_POST['validate-email']) && $_POST['validate-email']){
    $hash_text = uniqid(rand());

    $sql = sprintf('UPDATE `users` SET `hash` = "%s" WHERE `email` = "%s" ',
    mysqli_real_escape_string($db,$hash_text),
    mysqli_real_escape_string($db,$_POST['validate-email'])
    );
    mysqli_query($db,$sql) or die(mysqli_error($db));
    //sqlでUPDATEが実行できたら、次の処理に進む（未実装）
    $_SESSION['email'] = $_POST['validate-email'];
    var_dump($_SESSION['email']);

    //作成したハッシュを元にURLを作成して、変数に代入する
    $_SESSION['hashurl'] = 'http://localhost/flyhigh/new_pass.php?hash='.$hash_text;
    var_dump($_SESSION['hashurl']);

    header("location: sendmail_pass.php");
    exit();

  // }else{
  //   var_dump("失敗");
  //   $error['pass_forgot'] = 'faild';
  }


?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>FLYHIGH</title>
<meta name="description" content="">
<meta name="author" content="">

<!-- Bootstrap -->
<link rel="stylesheet" type="text/css"  href="css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="fonts/font-awesome/css/font-awesome.css">

<!-- Stylesheet
    ================================================== -->
<link rel="stylesheet" type="text/css"  href="css/style.css">
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800,600,300' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="js/modernizr.custom.js"></script>
<link rel="stylesheet" type="text/css" href="css/pass_forgot.css">

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
      <a class="navbar-brand page-scroll" href="#page-top"> <i class="fa fa-paper-plane-o"></i>FLY HIGH</a> </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
      <ul class="nav navbar-nav">
        <!-- Hidden li included to remove active class from about link when scrolled up past about section -->
        <li class="hidden"> <a href="#page-top"></a> </li>
        <li> <a class="page-scroll" href="#about">About</a> </li>
        <li> <a class="page-scroll" href="#services">Services</a> </li>
        <li> <a class="page-scroll" href="#works">Portfolio</a> </li>
        <li> <a class="page-scroll" href="#team">Team</a> </li>
        <li> <a class="page-scroll" href="#testimonials">Testimonials</a> </li>
        <li> <a class="page-scroll" href="#contact">Contact</a> </li>
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
      <h1>ENTER EMAIL</h1>
                <p class="lead">登録したメールアドレスを入力してください</p>
                <br><br><br>
        <div class="row">
            <div class="col-sm-offset-4 col-sm-4">
              <form method="post" action="">
                <div class="form-group">
                  <div class="input-group" data-validate="email">
                    <input type="text" class="form-control" name="validate-email" id="validate-email" placeholder="登録したメールアドレスを入力してください" required>
                    <span class="input-group-addon danger"></span>
                  </div>
                </div>
                <a href="login.php"><button type="button" class="btn btn-default btn-pass"><span class="angle">&laquo;&nbsp;</span>log in</button></a>
                <button type="submit" class="btn btn-default btn-pass">送信<span class="angle">&nbsp;&raquo;</span></button>
                <?php if(isset($_SESSION['error']) && $_SESSION['error'] == 'nohash'){ ?>
                  <p class="error">再度、メールアドレスを入力してください(๑•̀ㅂ•́)و✧</p>
                <?php } ?>
                <?php if(isset($error['pass_forgot']) && $error['pass_forgot'] == 'faild'){ ?>
                  <p class="error">メールアドレスが間違っています(๑•̀ㅂ•́)و✧</p>
                <?php } ?>
                </form>
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
<!-- <script type="text/javascript" src="js/contact_me.js"></script>
<script type="text/javascript" src="js/signup.js"></script> -->

<!-- Javascripts
    ================================================== -->
<script type="text/javascript" src="js/main.js"></script>
</body>
</html>