<?php
  //セッションを開始
  session_start();

  //DBへ接続
  require('dbconnect.php');

  // var_dump($_SESSION['admin']);
  // var_dump($_SESSION['admin']['style']);
  var_dump($_SESSION['admin']['country']);

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

  //セッションにデータがなかったらindex.phpに移動する
  if(!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit();
  }

  if(isset($_SESSION['admin']['country'])) {
  //adminで選択された国を使って、国DBから国IDを取得する処理
  //途中です

    //$_SESSION['admin']['country']が配列なので、文字にする必要があるらしい
    // $sql = sprintf('SELECT `country_id` FROM `countries` WHERE `country_name` = "India"');
    //   //SQL文の実行と変数への代入
    //   $select_country_ids = mysqli_query($db,$sql) or die(mysqli_error($db));
    //   $select_country_id = mysqli_fetch_assoc($select_country_ids);

    //var_dump($select_country_id);

    //こっちは配列のままのバージョン
    //繰り返しで$_SESSION['admin']['country']の中身を出して、別の配列に代入する必要がある？
    $select_country_id_array = array();
    //多次元の連想配列$_SESSION['admin']['country']から値を取得
    foreach ($_SESSION['admin']['country'] as $select_countries) {

    $sql = sprintf('SELECT `country_id` FROM `countries` WHERE `country_name` = "%s"',
      mysqli_real_escape_string($db,$select_countries)
      );
      //SQL文の実行と変数への代入
      $select_country_ids = mysqli_query($db,$sql) or die(mysqli_error($db));
      $select_country_id = mysqli_fetch_assoc($select_country_ids);

      $select_country_id_array[] = $select_country_id['country_id'];
    }

    var_dump($select_country_id_array);

    //取得した国IDを使って、ユーザー国テーブルからユーザーIDを取得する処理
    // $sql = sprintf('SELECT `user_id` FROM `user_countries` WHERE `country_id` = 27');
    //   //SQL文の実行と変数への代入
    //   $select_user_ids = mysqli_query($db,$sql) or die(mysqli_error($db));
    //   $select_user_id = mysqli_fetch_assoc($select_user_ids);

    //var_dump($select_user_id);

    //配列のままだと怒られる（国IDの取得と同じエラー）
    $select_user_id_array = array();
    foreach ($select_country_id_array as $select_country_id_value) {
    $sql = sprintf('SELECT `user_id` FROM `user_countries` WHERE `country_id` = "%s"',
      mysqli_real_escape_string($db,$select_country_id_value)
      );
      //SQL文の実行と変数への代入
      $select_user_ids = mysqli_query($db,$sql) or die(mysqli_error($db));
      $select_user_id = mysqli_fetch_assoc($select_user_ids);
      $select_user_id_array[] = $select_user_id['user_id'];
    }

    var_dump($select_user_id_array);

    //取得したユーザーIDを使って、ユーザーテーブルからメールアドレスを取得する処理
    $select_user_email_array = array();
    foreach ($select_user_id_array as $select_user_id_value) {
    $sql = sprintf('SELECT `email` FROM `users` WHERE `user_id` = "%s"',
      mysqli_real_escape_string($db,$select_user_id_value)
      );
      //SQL文の実行と変数への代入
      $select_user_emails = mysqli_query($db,$sql) or die(mysqli_error($db));
      $select_user_email = mysqli_fetch_assoc($select_user_emails);
      $select_user_email_array[] = $select_user_email['email'];
    }

    var_dump($select_user_email_array);
  }


  //DB登録処理
  if (!empty($_POST)){
    $sql = sprintf('INSERT INTO `sales`(`sale_title`, `sale_text`, `picture_path`, `sale_created`) VALUES ("%s","%s","%s", now());',
      mysqli_real_escape_string($db,$_SESSION['admin']['title']),
      mysqli_real_escape_string($db,$_SESSION['admin']['message']),
      mysqli_real_escape_string($db,$_SESSION['admin']['picture_path'])
      );

    //SQL文を実行する処理
    mysqli_query($db,$sql) or die(mysqli_error($db));
    header("location: admin.php");
    exit();
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
        <li> <a class="page-scroll" href="#mail">Form</a> </li>
        <li> <a class="page-scroll" href="logout.php">Logout</a> </li>
      </ul>
    </div>
    <!-- /.navbar-collapse -->
  </div>
  <!-- /.container -->
</nav>

<!-- About Section -->
<!-- <div class="container_all"> -->
<div id="about">
  <div class="container">
    <h1><span class="brand-heading text-center center">送信内容に間違いはありませんか？</span></h1>
    <?php if(isset($_SESSION['admin']['style'])) { ?>
    <div class="section-title text-center center">
      <h2>選択したスタイル</h2>
      <hr>
    </div>
    <div class="row">

      <div class="form-group col-md-12 columns">
              <!-- <label class="col-md-2 control-label" for="Checkboxes">Checkboxes</label>   -->

        <div class="row">
          <div class="col-md-12 columns">
            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                <label class="checkbox-inline" for="alone">
                  <?php if(in_array("alone", $_SESSION['admin']['style'])) { ?>
                  <!-- チェックがあったら表示 -->
                  <input type="hidden" name="Checkboxes" id="alone" value="alone">
                  <input type="checkbox" id='checkon' disabled='disabled' checked='checked'> <label for='checkon' class="text">ひとり旅</label>
                  <?php }else{ ?>
                  <!-- チェックがなかったら表示 -->
                  <input type="hidden" name="Checkboxes" id="alone" value="alone">
                  <input type="checkbox" id='checkoff' disabled='disabled'> <label for='checkoff' class="text">ひとり旅</label>
                  <?php } ?>
                </label>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                <label class="checkbox-inline" for="couple">
                  <?php if(in_array("couple", $_SESSION['admin']['style'])) { ?>
                  <!-- チェックがあったら表示 -->
                  <input type="hidden" name="Checkboxes" id="couple" value="couple">
                  <input type="checkbox" id='checkon' disabled='disabled' checked='checked'> <label for='checkon' class="text">カップル・夫婦</label>
                  <?php }else{ ?>
                  <!-- チェックがなかったら表示 -->
                  <input type="hidden" name="Checkboxes" id="couple" value="couple">
                  <input type="checkbox" id='checkoff' disabled='disabled'> <label for='checkoff' class="text">カップル・夫婦</label>
                  <?php } ?>
                </label>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                <label class="checkbox-inline" for="family">
                  <?php if(in_array("family", $_SESSION['admin']['style'])) { ?>
                  <!-- チェックがあったら表示 -->
                  <input type="hidden" name="Checkboxes" id="family" value="family">
                  <input type="checkbox" id='checkon' disabled='disabled' checked='checked'> <label for='checkon' class="text">家族旅行</label>
                  <?php }else{ ?>
                  <!-- チェックがなかったら表示 -->
                  <input type="hidden" name="Checkboxes" id="family" value="family">
                  <input type="checkbox" id='checkoff' disabled='disabled'> <label for='checkoff' class="text">家族旅行</label>
                  <?php } ?>
                </label>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                <label class="checkbox-inline" for="food">
                  <?php if(in_array("food", $_SESSION['admin']['style'])) { ?>
                  <!-- チェックがあったら表示 -->
                  <input type="hidden" name="Checkboxes" id="food" value="food">
                  <input type="checkbox" id='checkon' disabled='disabled' checked='checked'> <label for='checkon' class="text">グルメ</label>
                  <?php }else{ ?>
                  <!-- チェックがなかったら表示 -->
                  <input type="hidden" name="Checkboxes" id="food" value="food">
                  <input type="checkbox" id='checkoff' disabled='disabled'> <label for='checkoff' class="text">グルメ</label>
                  <?php } ?>
                </label>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                <label class="checkbox-inline" for="resort">
                  <?php if(in_array("resort", $_SESSION['admin']['style'])) { ?>
                  <!-- チェックがあったら表示 -->
                  <input type="hidden" name="Checkboxes" id="resort" value="resort">
                  <input type="checkbox" id='checkon' disabled='disabled' checked='checked'> <label for='checkon' class="text">リゾート</label>
                  <?php }else{ ?>
                  <!-- チェックがなかったら表示 -->
                  <input type="hidden" name="Checkboxes" id="resort" value="resort">
                  <input type="checkbox" id='checkoff' disabled='disabled'> <label for='checkoff' class="text">リゾート</label>
                  <?php } ?>
                </label>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                <label class="checkbox-inline" for="nature">
                  <?php if(in_array("nature", $_SESSION['admin']['style'])) { ?>
                  <!-- チェックがあったら表示 -->
                  <input type="hidden" name="Checkboxes" id="nature" value="nature">
                  <input type="checkbox" id='checkon' disabled='disabled' checked='checked'> <label for='checkon' class="text">自然</label>
                  <?php }else{ ?>
                  <!-- チェックがなかったら表示 -->
                  <input type="hidden" name="Checkboxes" id="nature" value="nature">
                  <input type="checkbox" id='checkoff' disabled='disabled'> <label for='checkoff' class="text">自然</label>
                  <?php } ?>
                </label>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                <label class="checkbox-inline" for="ruins">
                  <?php if(in_array("ruins", $_SESSION['admin']['style'])) { ?>
                  <!-- チェックがあったら表示 -->
                  <input type="hidden" name="Checkboxes" id="ruins" value="ruins">
                  <input type="checkbox" id='checkon' disabled='disabled' checked='checked'> <label for='checkon' class="text">遺跡</label>
                  <?php }else{ ?>
                  <!-- チェックがなかったら表示 -->
                  <input type="hidden" name="Checkboxes" id="ruins" value="ruins">
                  <input type="checkbox" id='checkoff' disabled='disabled'> <label for='checkoff' class="text">遺跡</label>
                  <?php } ?>
                </label>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                <label class="checkbox-inline" for="shopping">
                  <?php if(in_array("shopping", $_SESSION['admin']['style'])) { ?>
                  <!-- チェックがあったら表示 -->
                  <input type="hidden" name="Checkboxes" id="shopping" value="shopping">
                  <input type="checkbox" id='checkon' disabled='disabled' checked='checked'> <label for='checkon' class="text">ショッピング</label>
                  <?php }else{ ?>
                  <!-- チェックがなかったら表示 -->
                  <input type="hidden" name="Checkboxes" id="shopping" value="shopping">
                  <input type="checkbox" id='checkoff' disabled='disabled'> <label for='checkoff' class="text">ショッピング</label>
                  <?php } ?>
                </label>
            </div>
            <!-- スタイルALLを使うか分からないので、コメントアウトしてます -->
            <?php /* ?>
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
            <?php */ ?>
          </div>
        </div>
      </div>
    </div>
    <?php } ?>
  </div>
</div>

</div>

<?php if(isset($_SESSION['admin']['country'])) { ?>
<!-- Services Section -->
<!-- <div id="services" class="text-center"> -->
<div id="services" class="">
  <div class="container">
    <div class="section-title center box">
      <h2>選択した国</h2>
      <hr>
    </div>

    <div class="row">
      <div class="col-md-12 columns">
          <h3>Asia</h3>
            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
              <label class="checkbox-inline" for="uae">
                <?php if(in_array("United Arab Emirates", $_SESSION['admin']['country'])) { ?>
                <!-- チェックがあったら表示 -->
                <input type="hidden" name="Checkboxes" id="uae" value="United Arab Emirates">
                <input type="checkbox" id='checkon' disabled='disabled' checked='checked'> <label for='checkon' class="text">アラブ首長国連邦</label>
                <?php }else{ ?>
                <!-- チェックがなかったら表示 -->
                <input type="hidden" name="Checkboxes" id="uae" value="United Arab Emirates">
                <input type="checkbox" id='checkoff' disabled='disabled'><label for='checkoff' class="text">アラブ首長国連邦</label>
                <?php } ?>
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
<?php } ?>


<!-- Contact Section -->
<!-- <div id="contact" class="text-center"> -->
<div id="works" class="text-center">
  <div class="container">
    <div class="section-title center">
      <h2>送信内容に間違いはありませんか？</h2>
      <hr>
    </div>

    <div class="col-md-8 col-md-offset-2">
      <form method="post" action="" class="form-horizontal">
        <input type="hidden" name="action" value="submit">
        <table class="table table-striped table-condensed">
          <tbody>
            <tr>
              <td><div class="text-center">タイトル</div></td>
              <?php if(isset($_SESSION['admin']['title'])): ?>
                <td><div class="text-center"><?php echo $_SESSION['admin']['title']; ?></div></td>
              <?php else: ?>
                <td><div class="text-center">セールのタイトル</div></td>
              <?php endif; ?>
            </tr>
            <tr>
              <td><div class="text-center">本文</div></td>
              <?php if(isset($_SESSION['admin']['message'])): ?>
                <td><div class="text-center"><?php echo $_SESSION['admin']['message']; ?></div></td>
              <?php else: ?>
                <td><div class="text-center">セールの本文</div></td>
              <?php endif; ?>
            </tr>
            <?php /* ?>
            <tr>
              <td><div class="text-center">プロフィール画像</div></td>
              <?php if(isset($_SESSION['join']['picture_path'])): ?>
                <td><div class="text-center"><?php echo '<img src="../member_picture/' . $_SESSION['join']['picture_path'] . '" width=50% height=50%>'; ?></div></td>
              <?php else: ?>
                <td><div class="text-center"><img src="http://c85c7a.medialib.glogster.com/taniaarca/media/71/71c8671f98761a43f6f50a282e20f0b82bdb1f8c/blog-images-1349202732-fondo-steve-jobs-ipad.jpg" width="100" height="100"></div></td>
              <?php endif; ?>
            </tr>
            <?php */ ?>
          </tbody>
        </table>
    </div>

<?php /* ?>
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
<?php */ ?>

        <!-- <div id="success"></div> -->
        <a href="admin.php?action=rewrite"><button type="button" class="btn btn-custom btn-lg2" >戻る</button></a>
        <button type="submit" class="btn btn-custom btn-lg2">送信する</button>
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
<!-- <script type="text/javascript" src="js/contact_me.js"></script> -->
<!-- <script type="text/javascript" src="js/admin_contact_me.js"></script> -->



<!-- Javascripts
    ================================================== -->
<script type="text/javascript" src="js/main.js"></script>
</body>
</html>