<?php
  //セッションを開始
  session_start();

  //DBへ接続
  require('dbconnect.php');

  //自動ログイン処理


  //パスワードの再設定からジャンプしてきた場合
  if(isset($_SESSION['new_password']) && $_SESSION['new_password'] == 'success') {
    $_SESSION['new_password'] = '';
    $error['login'] = 'newpass';
  }

  //ログイン処理
  //メールアドレスとパスワードが入力されたらまずは空チェック
  if (!empty($_POST)) {

    //エラー項目の確認
    //メールアドレスが無い場合にkey'mail'にvalue'blank'を代入
    if (empty($_POST['email'])) {
      $error['login'] = 'blank';
    }

    //パスワードが無い場合にkey'password'にvalue'blank'を代入
    if (empty($_POST['password'])) {
      $error['login'] = 'blank';
    }

    //エラーがない場合
    if (empty($error)) {

        //ログイン処理を開始
        //入力されたemail,passwordでDBから会員情報を取得できたら、正常ログイン、取得できなかったら、$error['login']にfaildを代入して、
        //パスワードの下に「ログインに失敗しました。正しくご記入ください」とメッセージを表示する
        $sql = sprintf('SELECT `email`, `password`, `user_id` FROM `users` WHERE `email` = "%s" AND `password` = "%s" AND `delete_flag` = 0',
        mysqli_real_escape_string($db,$_POST['email']),
        mysqli_real_escape_string($db,sha1($_POST['password']))
        );

        //SQLを実行
        $record = mysqli_query($db,$sql) or die(mysqli_error($db));
        if ($table = mysqli_fetch_assoc($record)) {
          //ログイン成功
          //SESSION変数に会員IDを保存
          $_SESSION['login_user_id'] = $table['user_id'];
          //SESSION変数にログイン時間を記録
          $_SESSION['time'] = time();

          //自動ログインをONにしてたら、cookieにログイン情報を保存する
          if($_POST['save'] == 'on'){
            //setcookie(保存するキー,保存する値,保存する期間(秒数))
            setcookie('email',$_POST['email'],time() + 60*60*24*14);
            setcookie('password',$_POST['password'],time() + 60*60*24*14);
          }

          //ログイン後のadmin.php（トップページ）に遷移
          header("location: mypage.php");

          exit();

        }else{
          //ログイン失敗
          $error['login'] = 'faild';
        }
      }
  }

?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Flyhigh</title>
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
<!-- <link rel="stylesheet" type="text/css"  href="css/signup.css"> -->
<link rel="stylesheet" type="text/css"  href="css/thanks.css">
<link rel="stylesheet" type="text/css"  href="css/login.css">
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

<!-- Header -->
<div id="intro">
  <div class="intro-body bg">
    <div class="container box">
      <h1>log in</h1>
        <p class="lead">ログイン情報を入力してください</p>
        <div class="card card-container">
              <img id="profile-img" class="profile-img-card" src="img/flyhigh_logo.png" />
              <form method="post" action="" class="form-signin">
                  <span id="reauth-email" class="reauth-email"></span>
                  <input type="email" name="email" id="inputEmail" class="form-control" placeholder="メールアドレス" required autofocus>
                  <input type="password" name="password" id="inputPassword" class="form-control" placeholder="パスワード" required>
                  <div id="remember" class="checkbox">
                      <label>
                          <input type="checkbox" name="save" value="remember-me"><span class="auto-login">自動ログインする</span>
                      </label>
                  </div>
                  <div class="login-btn-field">
                    <input type="submit" class="btn btn-lg btn-primary btn-block btn-signin" value="log in&nbsp;&raquo;"></input>
                  </div>
                  <?php if(isset($error['login']) && $error['login'] == 'newpass') { ?>
                    <p class="error">新しいパスワードへの変更が完了しました</p>
                  <?php } ?>
                  <?php if(isset($error['login']) && $error['login'] == 'blank'){ ?>
                    <p class="error">メールアドレスとパスワードを入力してください(๑•̀ㅂ•́)و✧</p>
                  <?php } ?>
                  <?php if(isset($error['login']) && $error['login'] == 'faild'){ ?>
                    <p class="error">ログイン失敗(๑•̀ㅂ•́)و✧</p>
                  <?php } ?>
              </form>
              <p class="login-text"><a href="pass_forgot.php" class="forgot-password">パスワードを忘れましたか？&nbsp;&raquo;</a></p>
              <p class="login-text"><a href="index.php" class="forgot-password">&laquo;&nbsp;TOPに戻る</a></p>
              </div><!-- /card-container -->
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
<!-- <script type="text/javascript" src="js/contact_me.js"></script> -->
<!-- <script type="text/javascript" src="js/signup.js"></script> -->
<!-- <script type="text/javascript" src="js/login.js"></script> -->

<!-- Javascripts
    ================================================== -->
<script type="text/javascript" src="js/main.js"></script>
</body>
</html>