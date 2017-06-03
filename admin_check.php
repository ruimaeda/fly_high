<?php
  //セッションを開始
  session_start();

  //ログイン状態をチェックする→強制ログアウトを作る
  //ログインしていると判断できる条件
  // 1.セッションにidが入っていること
  // 2.最後の行動から1時間以内であること
  // if(isset($_SESSION['login_member_id']) && ($_SESSION['time'] + 3600 > time()) ){
  //   //ログインしている and 最後の行動から1時間以内
  //   //セッションの時間を更新
  //   $_SESSION['time'] = time();

  // } else {
  //   //ログインしていない or 最後の行動から1時間以上経った
  //   header('Location: admin_login.php');
  //   exit();

  // }

?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>FLY HIGH-Modus</title>
<meta name="description" content="">
<meta name="author" content="">

<!-- Bootstrap -->
<link rel="stylesheet" type="text/css"  href="css/bootstrap.css">
<link rel="stylesheet" type="text/css"  href="css/admin_bootstrap.css">
<link rel="stylesheet" type="text/css" href="fonts/font-awesome/css/font-awesome.css">

<!-- Stylesheet
    ================================================== -->
<link rel="stylesheet" type="text/css"  href="css/style.css">
<link rel="stylesheet" type="text/css"  href="css/admin_style.css">
<link rel="stylesheet" type="text/css"  href="css/admin_check_style.css">
<link rel="stylesheet" type="text/css" href="css/prettyPhoto.css">
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800,600,300' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="js/modernizr.custom.js"></script>

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
<!-- <?php include('common_part.css'); ?> --><!-- うまくいかない。場所が悪い？ -->
<div id="preloader">
  <div id="status"> <img src="img/preloader.gif" height="64" width="64" alt=""> </div>
</div>
<!-- Navigation -->
<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse"> <i class="fa fa-bars"></i> </button>
      <a class="navbar-brand page-scroll" href="#page-top"> <i class="fa fa-paper-plane-o"></i> FLY HIGH</a> </div>
    
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
      <ul class="nav navbar-nav">
        <!-- Hidden li included to remove active class from about link when scrolled up past about section -->
        <li class="hidden"> <a href="#page-top"></a> </li>
        <li> <a class="page-scroll" href="#about">選択したStyle</a> </li>
        <li> <a class="page-scroll" href="#services">選択したCountry</a> </li>
        <li> <a class="page-scroll" href="#mail">メール</a> </li>
      </ul>
    </div>
    <!-- /.navbar-collapse --> 
  </div>
  <!-- /.container --> 
</nav>

<!-- Headerはなくした -->
<!-- <div id="intro">
  <div class="intro-body">
    <div class="container">
      <div class="row">
        <div class="col-md-10 col-md-offset-1">
          <h1><span class="brand-heading">送信内容に間違いはありませんか？</span></h1>
          <p class="intro-check">Admin_Check</p>
        </div>
      </div>
    </div>
  </div>
</div> -->

<!-- About Section -->
<!-- <div class="container_all"> -->
<div id="about">
<p class="intro-check text-center center">Admin_Check</p>
  <div class="container">
    <h1><span class="brand-heading text-center center">送信内容に間違いはありませんか？</span></h1>
    <div class="section-title text-center center">
      <h2>選択したStyle</h2>
      <hr>
    </div>
    <div class="row">

      <div class="form-group col-md-12 columns">
              <!-- <label class="col-md-2 control-label" for="Checkboxes">Checkboxes</label>   -->

        <div class="row">
          <div class="col-md-12 columns">
            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                <label class="checkbox-inline" for="alone">
                  <!-- チェックがなかったら表示 -->
                  <input type="hidden" name="Checkboxes" id="alone" value="alone">
                  <input type="checkbox" id='checkoff' disabled='disabled'> <label for='checkoff' class="text">ひとり旅OFF</label>
                  <!-- チェックがあったら表示 -->
                  <input type="hidden" name="Checkboxes" id="alone" value="alone">
                  <input type="checkbox" id='checkon' disabled='disabled' checked='checked'> <label for='checkon' class="text">ひとり旅ON</label>
                </label>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                <label class="checkbox-inline" for="couple">
                  <!-- チェックがなかったら表示 -->
                  <input type="hidden" name="Checkboxes" id="couple" value="couple">
                  <input type="checkbox" id='checkoff' disabled='disabled'> <label for='checkoff' class="text">カップル・夫婦</label>
                  <!-- チェックがあったら表示 -->
                  <input type="hidden" name="Checkboxes" id="couple" value="couple">
                  <input type="checkbox" id='checkon' disabled='disabled' checked='checked'> <label for='checkon' class="text">カップル・夫婦</label>
                </label>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                <label class="checkbox-inline" for="family">
                  <!-- チェックがなかったら表示 -->
                  <input type="hidden" name="Checkboxes" id="family" value="family">
                  <input type="checkbox" id='checkoff' disabled='disabled'> <label for='checkoff' class="text">家族旅行</label>
                  <!-- チェックがあったら表示 -->
                  <input type="hidden" name="Checkboxes" id="family" value="family">
                  <input type="checkbox" id='checkon' disabled='disabled' checked='checked'> <label for='checkon' class="text">家族旅行</label>
                </label>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                <label class="checkbox-inline" for="food">
                  <!-- チェックがなかったら表示 -->
                  <input type="hidden" name="Checkboxes" id="food" value="food">
                  <input type="checkbox" id='checkoff' disabled='disabled'> <label for='checkoff' class="text">グルメ</label>
                  <!-- チェックがあったら表示 -->
                  <input type="hidden" name="Checkboxes" id="food" value="food">
                  <input type="checkbox" id='checkon' disabled='disabled' checked='checked'> <label for='checkon' class="text">グルメ</label>
                </label>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                <label class="checkbox-inline" for="resort">
                  <!-- チェックがなかったら表示 -->
                  <input type="hidden" name="Checkboxes" id="resort" value="resort">
                  <input type="checkbox" id='checkoff' disabled='disabled'> <label for='checkoff' class="text">リゾート</label>
                  <!-- チェックがあったら表示 -->
                  <input type="hidden" name="Checkboxes" id="resort" value="resort">
                  <input type="checkbox" id='checkon' disabled='disabled' checked='checked'> <label for='checkon' class="text">リゾート</label>
                </label>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                <label class="checkbox-inline" for="nature">
                  <!-- チェックがなかったら表示 -->
                  <input type="hidden" name="Checkboxes" id="nature" value="nature">
                  <input type="checkbox" id='checkoff' disabled='disabled'> <label for='checkoff' class="text">自然</label>
                  <!-- チェックがあったら表示 -->
                  <input type="hidden" name="Checkboxes" id="nature" value="nature">
                  <input type="checkbox" id='checkon' disabled='disabled' checked='checked'> <label for='checkon' class="text">自然</label>
                </label>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                <label class="checkbox-inline" for="ruins">
                  <!-- チェックがなかったら表示 -->
                  <input type="hidden" name="Checkboxes" id="ruins" value="ruins">
                  <input type="checkbox" id='checkoff' disabled='disabled'> <label for='checkoff' class="text">遺跡</label>
                  <!-- チェックがあったら表示 -->
                  <input type="hidden" name="Checkboxes" id="ruins" value="ruins">
                  <input type="checkbox" id='checkon' disabled='disabled' checked='checked'> <label for='checkon' class="text">遺跡</label>
                </label>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                <label class="checkbox-inline" for="shopping">
                  <!-- チェックがなかったら表示 -->
                  <input type="hidden" name="Checkboxes" id="shopping" value="shopping">
                  <input type="checkbox" id='checkoff' disabled='disabled'> <label for='checkoff' class="text">ショッピング</label>
                  <!-- チェックがあったら表示 -->
                  <input type="hidden" name="Checkboxes" id="shopping" value="shopping">
                  <input type="checkbox" id='checkon' disabled='disabled' checked='checked'> <label for='checkon' class="text">ショッピング</label>
                </label>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                <label class="checkbox-inline" for="all">
                  <!-- チェックがなかったら表示 -->
                  <input type="hidden" name="Checkboxes" id="all" value="all">
                  <input type="checkbox" id='checkoff' disabled='disabled'> <label for='checkoff' class="text">運営のおすすめ（全て）</label>
                  <!-- チェックがあったら表示 -->
                  <input type="hidden" name="Checkboxes" id="all" value="all">
                  <input type="checkbox" id='checkon' disabled='disabled' checked='checked'> <label for='checkon' class="text">運営のおすすめ（全て）</label>
                </label>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

</div>

<!-- Services Section -->
<!-- <div id="services" class="text-center"> -->
<div id="services" class="">
  <div class="container">
    <div class="section-title center box">
      <h2>選択したCountry</h2>
      <hr>
    </div>

    <div class="row">
      <div class="col-md-12 columns">
          <h3>Asia</h3>
            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
              <label class="checkbox-inline" for="uae">
                <!-- チェックがなかったら表示 -->
                <input type="hidden" name="Checkboxes" id="uae" value="uae">
                <input type="checkbox" id='checkoff' disabled='disabled'><label for='checkoff' class="text">アラブ首長国連邦</label>
                <!-- チェックがあったら表示 -->
                <input type="hidden" name="Checkboxes" id="uae" value="uae">
                <input type="checkbox" id='checkon' disabled='disabled' checked='checked'> <label for='checkon' class="text">アラブ首長国連邦</label>
              </label>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
              <label class="checkbox-inline" for="india">
                <!-- チェックがなかったら表示 -->
                <input type="hidden" name="Checkboxes" id="india" value="india">
                <input type="checkbox" id='checkoff' disabled='disabled'><label for='checkoff' class="text">インド</label>
                <!-- チェックがあったら表示 -->
                <input type="hidden" name="Checkboxes" id="india" value="india">
                <input type="checkbox" id='checkon' disabled='disabled' checked='checked'> <label for='checkon' class="text">インド</label>
              </label>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
              <label class="checkbox-inline" for="indonesia">
                <!-- チェックがなかったら表示 -->
                <input type="hidden" name="Checkboxes" id="indonesia" value="indonesia">
                <input type="checkbox" id='checkoff' disabled='disabled'><label for='checkoff' class="text">インドネシア</label>
                <!-- チェックがあったら表示 -->
                <input type="hidden" name="Checkboxes" id="indonesia" value="indonesia">
                <input type="checkbox" id='checkon' disabled='disabled' checked='checked'> <label for='checkon' class="text">インドネシア</label>
              </label>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
              <label class="checkbox-inline" for="qatar">
                <!-- チェックがなかったら表示 -->
                <input type="hidden" name="Checkboxes" id="qatar" value="qatar">
                <input type="checkbox" id='checkoff' disabled='disabled'><label for='checkoff' class="text">カタール</label>
                <!-- チェックがあったら表示 -->
                <input type="hidden" name="Checkboxes" id="qatar" value="qatar">
                <input type="checkbox" id='checkon' disabled='disabled' checked='checked'> <label for='checkon' class="text">カタール</label>
              </label>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
              <label class="checkbox-inline" for="korea">
                <!-- チェックがなかったら表示 -->
                <input type="hidden" name="Checkboxes" id="korea" value="korea">
                <input type="checkbox" id='checkoff' disabled='disabled'><label for='checkoff' class="text">韓国</label>
                <!-- チェックがあったら表示 -->
                <input type="hidden" name="Checkboxes" id="korea" value="korea">
                <input type="checkbox" id='checkon' disabled='disabled' checked='checked'> <label for='checkon' class="text">韓国</label>
              </label>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
              <label class="checkbox-inline" for="cambodia">
                <!-- チェックがなかったら表示 -->
                <input type="hidden" name="Checkboxes" id="cambodia" value="cambodia">
                <input type="checkbox" id='checkoff' disabled='disabled'><label for='checkoff' class="text">カンボジア</label>
                <!-- チェックがあったら表示 -->
                <input type="hidden" name="Checkboxes" id="cambodia" value="cambodia">
                <input type="checkbox" id='checkon' disabled='disabled' checked='checked'> <label for='checkon' class="text">カンボジア</label>
              </label>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
              <label class="checkbox-inline" for="singapore">
                <!-- チェックがなかったら表示 -->
                <input type="hidden" name="Checkboxes" id="singapore" value="singapore">
                <input type="checkbox" id='checkoff' disabled='disabled'><label for='checkoff' class="text">シンガポール</label>
                <!-- チェックがあったら表示 -->
                <input type="hidden" name="Checkboxes" id="singapore" value="singapore">
                <input type="checkbox" id='checkon' disabled='disabled' checked='checked'> <label for='checkon' class="text">シンガポール</label>
              </label>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
              <label class="checkbox-inline" for="thailand">
                <!-- チェックがなかったら表示 -->
                <input type="hidden" name="Checkboxes" id="thailand" value="thailand">
                <input type="checkbox" id='checkoff' disabled='disabled'><label for='checkoff' class="text">タイ</label>
                <!-- チェックがあったら表示 -->
                <input type="hidden" name="Checkboxes" id="thailand" value="thailand">
                <input type="checkbox" id='checkon' disabled='disabled' checked='checked'> <label for='checkon' class="text">タイ</label>
              </label>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
              <label class="checkbox-inline" for="taiwan">
                <!-- チェックがなかったら表示 -->
                <input type="hidden" name="Checkboxes" id="taiwan" value="taiwan">
                <input type="checkbox" id='checkoff' disabled='disabled'><label for='checkoff' class="text">台湾</label>
                <!-- チェックがあったら表示 -->
                <input type="hidden" name="Checkboxes" id="taiwan" value="taiwan">
                <input type="checkbox" id='checkon' disabled='disabled' checked='checked'> <label for='checkon' class="text">台湾</label>
              </label>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
              <label class="checkbox-inline" for="china">
                <!-- チェックがなかったら表示 -->
                <input type="hidden" name="Checkboxes" id="china" value="china">
                <input type="checkbox" id='checkoff' disabled='disabled'><label for='checkoff' class="text">中国</label>
                <!-- チェックがあったら表示 -->
                <input type="hidden" name="Checkboxes" id="china" value="china">
                <input type="checkbox" id='checkon' disabled='disabled' checked='checked'> <label for='checkon' class="text">中国</label>
              </label>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
              <label class="checkbox-inline" for="turkey">
                <!-- チェックがなかったら表示 -->
                <input type="hidden" name="Checkboxes" id="turkey" value="turkey">
                <input type="checkbox" id='checkoff' disabled='disabled'><label for='checkoff' class="text">トルコ</label>
                <!-- チェックがあったら表示 -->
                <input type="hidden" name="Checkboxes" id="turkey" value="turkey">
                <input type="checkbox" id='checkon' disabled='disabled' checked='checked'> <label for='checkon' class="text">トルコ</label>
              </label>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
              <label class="checkbox-inline" for="philippines">
                <!-- チェックがなかったら表示 -->
                <input type="hidden" name="Checkboxes" id="philippines" value="philippines">
                <input type="checkbox" id='checkoff' disabled='disabled'><label for='checkoff' class="text">フィリピン</label>
                <!-- チェックがあったら表示 -->
                <input type="hidden" name="Checkboxes" id="philippines" value="philippines">
                <input type="checkbox" id='checkon' disabled='disabled' checked='checked'> <label for='checkon' class="text">フィリピン</label>
              </label>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
              <label class="checkbox-inline" for="vietnam">
                <!-- チェックがなかったら表示 -->
                <input type="hidden" name="Checkboxes" id="vietnam" value="vietnam">
                <input type="checkbox" id='checkoff' disabled='disabled'><label for='checkoff' class="text">ベトナム</label>
                <!-- チェックがあったら表示 -->
                <input type="hidden" name="Checkboxes" id="vietnam" value="vietnam">
                <input type="checkbox" id='checkon' disabled='disabled' checked='checked'> <label for='checkon' class="text">ベトナム</label>
              </label>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
              <label class="checkbox-inline" for="hongkong_macao">
                <!-- チェックがなかったら表示 -->
                <input type="hidden" name="Checkboxes" id="hongkong_macao" value="hongkong_macao">
                <input type="checkbox" id='checkoff' disabled='disabled'><label for='checkoff' class="text">香港・マカオ</label>
                <!-- チェックがあったら表示 -->
                <input type="hidden" name="Checkboxes" id="hongkong_macao" value="hongkong_macao">
                <input type="checkbox" id='checkon' disabled='disabled' checked='checked'> <label for='checkon' class="text">香港・マカオ</label>
              </label>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
              <label class="checkbox-inline" for="malaysia">
                <!-- チェックがなかったら表示 -->
                <input type="hidden" name="Checkboxes" id="malaysia" value="malaysia">
                <input type="checkbox" id='checkoff' disabled='disabled'><label for='checkoff' class="text">マレーシア</label>
                <!-- チェックがあったら表示 -->
                <input type="hidden" name="Checkboxes" id="malaysia" value="malaysia">
                <input type="checkbox" id='checkon' disabled='disabled' checked='checked'> <label for='checkon' class="text">マレーシア</label>
              </label><br><br>
            </div>
      </div>

      <div class="col-md-12 columns">
          <h3>Oceania</h3>
            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
              <label class="checkbox-inline" for="austraria">
                <!-- チェックがなかったら表示 -->
                <input type="hidden" name="Checkboxes" id="austraria" value="austraria">
                <input type="checkbox" id='checkoff' disabled='disabled'><label for='checkoff' class="text">オーストラリア</label>
                <!-- チェックがあったら表示 -->
                <input type="hidden" name="Checkboxes" id="austraria" value="austraria">
                <input type="checkbox" id='checkon' disabled='disabled' checked='checked'> <label for='checkon' class="text">オーストラリア</label>
              </label>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
              <label class="checkbox-inline" for="guam">
                <!-- チェックがなかったら表示 -->
                <input type="hidden" name="Checkboxes" id="guam" value="guam">
                <input type="checkbox" id='checkoff' disabled='disabled'><label for='checkoff' class="text">グアム</label>
                <!-- チェックがあったら表示 -->
                <input type="hidden" name="Checkboxes" id="guam" value="guam">
                <input type="checkbox" id='checkon' disabled='disabled' checked='checked'> <label for='checkon' class="text">グアム</label>
              </label>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
              <label class="checkbox-inline" for="saipan">
                <!-- チェックがなかったら表示 -->
                <input type="hidden" name="Checkboxes" id="saipan" value="saipan">
                <input type="checkbox" id='checkoff' disabled='disabled'><label for='checkoff' class="text">サイパン</label>
                <!-- チェックがあったら表示 -->
                <input type="hidden" name="Checkboxes" id="saipan" value="saipan">
                <input type="checkbox" id='checkon' disabled='disabled' checked='checked'> <label for='checkon' class="text">サイパン</label>
              </label>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
              <label class="checkbox-inline" for="newcaledonia">
                <!-- チェックがなかったら表示 -->
                <input type="hidden" name="Checkboxes" id="newcaledonia" value="newcaledonia">
                <input type="checkbox" id='checkoff' disabled='disabled'><label for='checkoff' class="text">ニューカレドニア</label>
                <!-- チェックがあったら表示 -->
                <input type="hidden" name="Checkboxes" id="newcaledonia" value="newcaledonia">
                <input type="checkbox" id='checkon' disabled='disabled' checked='checked'> <label for='checkon' class="text">ニューカレドニア</label>
              </label>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
              <label class="checkbox-inline" for="newzealand">
                <!-- チェックがなかったら表示 -->
                <input type="hidden" name="Checkboxes" id="newzealand" value="newzealand">
                <input type="checkbox" id='checkoff' disabled='disabled'><label for='checkoff' class="text">ニュージーランド</label>
                <!-- チェックがあったら表示 -->
                <input type="hidden" name="Checkboxes" id="newzealand" value="newzealand">
                <input type="checkbox" id='checkon' disabled='disabled' checked='checked'> <label for='checkon' class="text">ニュージーランド</label>
              </label><br><br>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
              <label class="checkbox-inline" for="hawaii">
                <!-- チェックがなかったら表示 -->
                <input type="hidden" name="Checkboxes" id="hawaii" value="hawaii">
                <input type="checkbox" id='checkoff' disabled='disabled'><label for='checkoff' class="text">ハワイ</label>
                <!-- チェックがあったら表示 -->
                <input type="hidden" name="Checkboxes" id="hawaii" value="hawaii">
                <input type="checkbox" id='checkon' disabled='disabled' checked='checked'> <label for='checkon' class="text">ハワイ</label>
              </label><br><br>
            </div>
      </div>

      <div class="col-md-12 columns">
          <h3>Europe</h3>
            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
              <label class="checkbox-inline" for="ireland">
                <!-- チェックがなかったら表示 -->
                <input type="hidden" name="Checkboxes" id="ireland" value="ireland">
                <input type="checkbox" id='checkoff' disabled='disabled'><label for='checkoff' class="text">アイルランド</label>
                <!-- チェックがあったら表示 -->
                <input type="hidden" name="Checkboxes" id="ireland" value="ireland">
                <input type="checkbox" id='checkon' disabled='disabled' checked='checked'> <label for='checkon' class="text">アイルランド</label>
              </label>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
              <label class="checkbox-inline" for="uk">
                <!-- チェックがなかったら表示 -->
                <input type="hidden" name="Checkboxes" id="uk" value="uk">
                <input type="checkbox" id='checkoff' disabled='disabled'><label for='checkoff' class="text">イギリス</label>
                <!-- チェックがあったら表示 -->
                <input type="hidden" name="Checkboxes" id="uk" value="uk">
                <input type="checkbox" id='checkon' disabled='disabled' checked='checked'> <label for='checkon' class="text">イギリス</label>
              </label>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
              <label class="checkbox-inline" for="italy">
                <!-- チェックがなかったら表示 -->
                <input type="hidden" name="Checkboxes" id="italy" value="italy">
                <input type="checkbox" id='checkoff' disabled='disabled'><label for='checkoff' class="text">イタリア</label>
                <!-- チェックがあったら表示 -->
                <input type="hidden" name="Checkboxes" id="italy" value="italy">
                <input type="checkbox" id='checkon' disabled='disabled' checked='checked'> <label for='checkon' class="text">イタリア</label>
              </label>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
              <label class="checkbox-inline" for="netherland">
                <!-- チェックがなかったら表示 -->
                <input type="hidden" name="Checkboxes" id="netherland" value="netherland">
                <input type="checkbox" id='checkoff' disabled='disabled'><label for='checkoff' class="text">オランダ</label>
                <!-- チェックがあったら表示 -->
                <input type="hidden" name="Checkboxes" id="netherland" value="netherland">
                <input type="checkbox" id='checkon' disabled='disabled' checked='checked'> <label for='checkon' class="text">オランダ</label>
              </label>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
              <label class="checkbox-inline" for="spain">
                <!-- チェックがなかったら表示 -->
                <input type="hidden" name="Checkboxes" id="spain" value="spain">
                <input type="checkbox" id='checkoff' disabled='disabled'><label for='checkoff' class="text">スペイン</label>
                <!-- チェックがあったら表示 -->
                <input type="hidden" name="Checkboxes" id="spain" value="spain">
                <input type="checkbox" id='checkon' disabled='disabled' checked='checked'> <label for='checkon' class="text">スペイン</label>
              </label>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
              <label class="checkbox-inline" for="finland">
                <!-- チェックがなかったら表示 -->
                <input type="hidden" name="Checkboxes" id="finland" value="finland">
                <input type="checkbox" id='checkoff' disabled='disabled'><label for='checkoff' class="text">フィンランド</label>
                <!-- チェックがあったら表示 -->
                <input type="hidden" name="Checkboxes" id="finland" value="finland">
                <input type="checkbox" id='checkon' disabled='disabled' checked='checked'> <label for='checkon' class="text">フィンランド</label>
              </label>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
              <label class="checkbox-inline" for="france">
                <!-- チェックがなかったら表示 -->
                <input type="hidden" name="Checkboxes" id="france" value="france">
                <input type="checkbox" id='checkoff' disabled='disabled'><label for='checkoff' class="text">フランス</label>
                <!-- チェックがあったら表示 -->
                <input type="hidden" name="Checkboxes" id="france" value="france">
                <input type="checkbox" id='checkon' disabled='disabled' checked='checked'> <label for='checkon' class="text">フランス</label>
              </label>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
              <label class="checkbox-inline" for="russia">
                <!-- チェックがなかったら表示 -->
                <input type="hidden" name="Checkboxes" id="russia" value="russia">
                <input type="checkbox" id='checkoff' disabled='disabled'><label for='checkoff' class="text">ロシア</label>
                <!-- チェックがあったら表示 -->
                <input type="hidden" name="Checkboxes" id="russia" value="russia">
                <input type="checkbox" id='checkon' disabled='disabled' checked='checked'> <label for='checkon' class="text">ロシア</label>
              </label><br><br>
            </div>
      </div>

      <div class="col-md-12 columns">
          <h3>North_America</h3>
            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
              <label class="checkbox-inline" for="usa">
                <!-- チェックがなかったら表示 -->
                <input type="hidden" name="Checkboxes" id="usa" value="usa">
                <input type="checkbox" id='checkoff' disabled='disabled'><label for='checkoff' class="text">アメリカ</label>
                <!-- チェックがあったら表示 -->
                <input type="hidden" name="Checkboxes" id="usa" value="usa">
                <input type="checkbox" id='checkon' disabled='disabled' checked='checked'> <label for='checkon' class="text">アメリカ</label>
              </label>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
              <label class="checkbox-inline" for="canada">
                <!-- チェックがなかったら表示 -->
                <input type="hidden" name="Checkboxes" id="canada" value="canada">
                <input type="checkbox" id='checkoff' disabled='disabled'><label for='checkoff' class="text">カナダ</label>
                <!-- チェックがあったら表示 -->
                <input type="hidden" name="Checkboxes" id="canada" value="canada">
                <input type="checkbox" id='checkon' disabled='disabled' checked='checked'> <label for='checkon' class="text">カナダ</label>
              </label>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
              <label class="checkbox-inline" for="mexico">
                <!-- チェックがなかったら表示 -->
                <input type="hidden" name="Checkboxes" id="mexico" value="mexico">
                <input type="checkbox" id='checkoff' disabled='disabled'><label for='checkoff' class="text">メキシコ</label>
                <!-- チェックがあったら表示 -->
                <input type="hidden" name="Checkboxes" id="mexico" value="mexico">
                <input type="checkbox" id='checkon' disabled='disabled' checked='checked'> <label for='checkon' class="text">メキシコ</label>
              </label>
            </div>
      </div>
    </div>
  </div>
</div>


</div>



<!-- Contact Section -->
<!-- <div id="contact" class="text-center"> -->
<div id="mail" class="text-center">
  <div class="container">
    <div class="section-title center">
      <h2>送信内容に間違いはありませんか？</h2>
      <hr>
    </div>

    <div class="col-md-8 col-md-offset-2">
      <form name="sentMessage" id="contactForm" novalidate>
        <!-- タイトル -->
        <div class="row">
            <div class="col-md-12">
              <!-- <div class="form-group"> -->
                <input type="text" id="name" class="form-control" placeholder="Title" required="required">
                <p class="help-block text-danger"></p>
              <!-- </div> -->
            </div>
        </div>

        <!-- 画像 -->
        <div class="form-group">
          <!-- <label class="col-sm-4 control-label">画像</label> -->
          <div class="col-sm-10">
            <input type="file" name="picture_path" class="form-control">
            <!-- <img src="../member_picture/<?php echo $picture_path; ?>"  width="100" height="100"> -->
          </div>
        </div>

        <!-- テキスト -->
        <div class="form-group">
            <textarea name="message" id="message" class="form-control" rows="10" placeholder="Message" required></textarea>
            <p class="help-block text-danger"></p>
        </div>


        <div id="success"></div>
        <!-- <button type="submit" class="btn btn-custom btn-lg">Send Message</button> -->
        <button type="submit" class="btn btn-custom btn-lg2">Back</button>
        <button type="submit" class="btn btn-custom btn-lg2">Send Message</button>
      </form>

    </div>
  </div>
</div>




<?php include('footer.php'); ?>

  <!-- to-topのフローティングボタンを付け加える -->
  <a id="to-top" href="#top" class="btn btn-dark btn-lg">
    <i class="fa fa-chevron-up fa-fw fa-1x"></i>
  </a>

</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script type="text/javascript" src="js/jquery.1.11.1.js"></script> 

<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script type="text/javascript" src="js/bootstrap.js"></script> 
<!-- <script type="text/javascript" src="js/admin_bootstrap.js"></script>  -->
<script type="text/javascript" src="js/SmoothScroll.js"></script> 
<script type="text/javascript" src="js/jquery.prettyPhoto.js"></script> 
<script type="text/javascript" src="js/jquery.isotope.js"></script> 
<script type="text/javascript" src="js/jquery.parallax.js"></script> 
<script type="text/javascript" src="js/jqBootstrapValidation.js"></script> 
<script type="text/javascript" src="js/contact_me.js"></script> 
<script type="text/javascript" src="js/admin_contact_me.js"></script> 



<!-- Javascripts
    ================================================== --> 
<script type="text/javascript" src="js/main.js"></script>
</body>
</html>