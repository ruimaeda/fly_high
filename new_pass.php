<?php
//セッションスタート
session_start();

//DBへ接続
require('dbconnect.php');

//$_GETからハッシュタグの値を取得して、どのユーザーのパスを更新するのか探す
//$_GETの値がないユーザーはリジェクトする
//$_GETのハッシュデータを元にユーザーIDをSELECTする
if(isset($_GET['hash'])){
  var_dump("GETがある");
  var_dump($_GET);

  $sql = sprintf('SELECT `user_id` FROM `users` WHERE `hash` ="%s" ',
  mysqli_real_escape_string($db,$_GET['hash']));
  $record = mysqli_query($db,$sql) or die(mysqli_error($db));
  $user_id = mysqli_fetch_assoc($record);
  var_dump($user_id);

  if(!empty($_POST)){
    //入力されたパスワードのエラー処理（パスワードが6文字未満）
    if (strlen($_POST['password'])<6) {
      $error['password']='length';
    }

    //入力されたパスワードのエラー処理（入力したパスワードが一致しない）
    if ($_POST['re_password'] !== $_POST['password']) {
      $error['re_password']='not_same';
    }

    //エラーがなかった場合
    if(empty($error)){

    //特定したuser_idを元に、パスワードを更新する
    $sql = sprintf('UPDATE `users` SET `password` = "%s" WHERE `user_id` = "%s" ',
    mysqli_real_escape_string($db,sha1($_POST['password'])),
    mysqli_real_escape_string($db,$user_id['user_id'])
    );
    mysqli_query($db,$sql) or die(mysqli_error($db));
    $_SESSION['new_password'] = 'success';
    header("location: login.php");
    exit();

    }
  }

}else{
  var_dump("GETがない");
  //なんらかのエラー変数をSESSIONに代入して、pass_forgotに飛ばして、エラーを表示する（未実装）
  $_SESSION['error'] = 'nohash';
  // header("location: pass_forgot.php");
  // exit();

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
<link rel="stylesheet" type="text/css" href="css/new_pass.css">

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
      <a class="navbar-brand page-scroll" href="#page-top"> <i class="fa fa-paper-plane-o"></i> Modus</a> </div>
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
      <h1>Change password</h1>
                <p class="lead">新しいパスワードを登録してください</p>
                <br><br><br>
        <div class="row">
            <div class="col-sm-offset-4 col-sm-4">
              <form method="post" action="">
                <div class="form-group">
                  <div class="input-group" data-validate="email">
                    <input type="password" class="form-control" name="password" id="password" placeholder="パスワードを入力してください" required>
                    <span class="input-group-addon danger"></span>
                  </div>
                  <!-- 字数エラーの処理(ok) -->
                  <?php if(isset($error['password']) && $error['password']=='length'){ ?>
                    <p class="error">* passwordは6文字以上で入力してください</p>
                  <?php } ?>
                </div>
                <div class="form-group">
                  <div class="input-group" data-validate="email">
                    <input type="password" class="form-control" name="re_password" id="re_password" placeholder="パスワードをもう一度入力してください" required>
                    <span class="input-group-addon danger"></span>
                  </div>
                  <!-- パスワード確認の処理(ok) -->
                  <?php if(isset($error['re_password']) && $error['re_password']=='not_same'){ ?>
                    <p class="error">* 入力された2つのpasswordが異なります</p>
                  <?php } ?>
                </div>
                <button type="submit" class="btn btn-default btn-forgot">更新する</button>
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