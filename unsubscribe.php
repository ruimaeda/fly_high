<?php
// var_dump($_SESSION['login_user_id']);

//セッションを開始
 session_start();

 //DBへ接続
 require('dbconnect.php');

 //退会処理
 //POST送信されているか確認する
 if (!empty($_POST)) {
  var_dump("POST送信されているか確認する");

       //セッションから取得したユーザーIDと入力されたpasswordでDBから会員情報を取得できたら、退会処理を実行
       //取得できなかったら、$error['login']にfaildを代入して、エラーメッセージを表示する
       $sql = sprintf('SELECT `email`, `password`, `user_id` FROM `users` WHERE `user_id` = "%s" AND `password` = "%s"',
       mysqli_real_escape_string($db,$_SESSION['login_user_id']),
       mysqli_real_escape_string($db,sha1($_POST['password']))
       );

       //SQLを実行
       $record = mysqli_query($db,$sql) or die(mysqli_error($db));
       //$tableってなんだっけ？
       if ($table = mysqli_fetch_assoc($record)) {
         //パスワード確認成功
         $sql = 'UPDATE `users` SET `delete_flag` = 1 WHERE `user_id` = '.$_SESSION['login_user_id'];
         mysqli_query($db,$sql) or die(mysqli_error($db));

         //ログイン後のadmin.php（トップページ）に遷移
         header("location: otukare.php");
         exit();

       }else{
         //パスワード確認失敗
         $error['password'] = 'faild';
       }
 }

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
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800,600,300' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="js/modernizr.custom.js"></script>
<link rel="stylesheet" type="text/css" href="css/unsubscribe.css">

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
      <h1>FLYHIGHを退会する</h1>
                <p class="lead">登録内容が全て失われます。本当に退会しますか？</p>
                <br><br><br>
        <div class="row">
            <div class="col-sm-offset-4 col-sm-4">
              <form method="post" action="">
                <div class="form-group">
                  <div class="input-group" data-validate="email">
                    <input type="password" name="password" id="inputPassword" class="form-control" placeholder="退会する場合はパスワードを入力してください" required>
                    <!-- <input type="text" class="form-control" name="validate-email" id="validate-email" placeholder="退会する場合はパスワードを入力してください" required> -->
                    <span class="input-group-addon danger"></span>
                  </div>
                  <?php if(isset($error['password']) && $error['password'] == 'faild'){ ?>
                      <p class="error">パスワードが間違っています</p>
                    <?php } ?>
                </div>
                <button type="button" class="btn btn-default btn-unsbscribe">編集ページに戻る</button>
                <button type="submit" class="btn btn-default btn-unsbscribe">退会する</button>
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