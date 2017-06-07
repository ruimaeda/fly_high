<?php
//セッションを開始
session_start();

//以下が配列の記述もあるバージョン
//参考：https://blog.s-giken.net/235.html

// Phpmailerの読み込み
require_once ( 'PHPMailer/PHPMailerAutoload.php' );

// 外部SMTPサーバーのホスト名
$smtp_host = "ssl://smtp.gmail.com";

// 外部SMTPのポート番号
$smtp_port = "465";

// 外部SMTPに接続するユーザー名
$smtp_user = "sendflyhigh@gmail.com";

// 外部SMTPに接続するパスワード
$smtp_password = "flyhigh0403";

//配列を設定する
//SESSIONから取得しているが、これは正しいのか？
// $to_array = "ruisu0717@gmail.com";
$to_array = $_SESSION['mail_address'];
$subject = $_SESSION['admin']['title'];
$body = $_SESSION['admin']['message'];
$fromname = "FLYHIGH";
$fromaddress = "sendflyhigh@gmail.com";
$ccaddress = "";
$bccaddress = "louis@tabippo.net";

var_dump($to_array);

// Phpmailerを使ってメールを送信する関数の呼び出し
$res = phpmailersend ( $to_array, $subject, $body, $fromname, $fromaddress, $ccaddress, $bccaddress );

if ( $res == "Message has been sent" ){
  // 正常処理
} else {
  // エラー処理
}


// SMTPを使ってメール送信関数
function phpmailersend ( $to_array, $subject, $body, $fromname, $fromaddress, $ccaddress="", $bccaddress="" ){

  global $smtp_host, $smtp_port, $smtp_user, $smtp_password;

  // $to_array  = explode ( ',', preg_replace ( '/\s/', '', $to  ) );
  // $cc_array  = explode ( ',', preg_replace ( '/\s/', '', $ccaddress  ) );
  // $bcc_array = explode ( ',', preg_replace ( '/\s/', '', $bccaddress ) );

  $mailer = new PHPMailer();

  $mailer -> CharSet = "iso-2022-jp";
  $mailer -> Encoding = "7bit";

  $mailer -> IsSMTP();
  $mailer -> Host = $smtp_host . ":" . $smtp_port;
  $mailer -> SMTPAuth = TRUE;
  $mailer -> Username = $smtp_user;        // Gmailのアカウント名
  $mailer -> Password = $smtp_password;    // Gmailのパスワード
  $mailer -> From     = $fromaddress;      // Fromのメールアドレス
  $mailer -> FromName = mb_convert_encoding ( $fromname, "JIS", "UTF-8" );
  $mailer -> Subject  = mb_convert_encoding ( $subject, "JIS", "UTF-8" );
  $mailer -> Body     = mb_convert_encoding ( $body, "JIS", "UTF-8" );
  // $mailer -> AddAddress ( $to );
  foreach ( $to_array as $to ) {
    $mailer -> AddAddress ( $to );         // TO
  }
  // foreach ( $cc_array as $cc ) {
  //   $mailer -> AddCC  ( $cc );             // CC
  // }
  // foreach ( $bcc_array as $bcc ) {
  //   $mailer -> AddBCC ( $bcc );            // BCC
  // }

  if( !$mailer -> Send() ){
    $message  = "送信に失敗しました";
    $message .= "Mailer Error: " . $mailer->ErrorInfo;
  } else {
    $message  = "送信に成功しました";
  }

  // if( !$mailer -> Send() ){
  //   $message  = "Message was not sent<br/ >";
  //   $message .= "Mailer Error: " . $mailer->ErrorInfo;
  // } else {
  //   $message  = "Message has been sent";
  // }
  // return $message;

}

//以下がコマンドラインから実行して動いた記述
//参考：http://taitan916.info/blog/?p=1830

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
<link rel="stylesheet" type="text/css"  href="css/admin_bootstrap.css">
<link rel="stylesheet" type="text/css" href="fonts/font-awesome/css/font-awesome.css">

<!-- Stylesheet
    ================================================== -->
<link rel="stylesheet" type="text/css"  href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/prettyPhoto.css">
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800,600,300' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css"  href="css/signup.css">
<link rel="stylesheet" type="text/css"  href="css/thanks.css">
<link rel="stylesheet" type="text/css"  href="css/login.css">
<link rel="stylesheet" type="text/css"  href="css/admin_login.css">
<link rel="stylesheet" type="text/css"  href="css/sendmail.css">
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
      <h1>メール送信結果</h1>
        <?php if($message  = "送信に成功しました") { ?>
        <h2>送信成功です</h2>
        <?php }else{ ?>
        <h2>送信失敗です</h2>
        <?php } ?>
        <a href="admin.php"><button type="button" class="btn btn-custom btn-lg2">ADMINトップへ戻る</button></a>
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
<script type="text/javascript" src="js/admin_contact_me.js"></script> -->

<!-- Javascripts
    ================================================== -->
<script type="text/javascript" src="js/main.js"></script>
</body>
</html>