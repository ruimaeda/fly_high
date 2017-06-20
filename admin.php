<?php
  //セッションを開始
  session_start();

  //DBへ接続
  require('dbconnect.php');

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

  //スタイルを選択している人数を表示する処理
    //style_nameとstyle_idを含む配列$find_style_arrayを作成する
    $find_style_array = array();
    $sql = sprintf('SELECT `style_id`, `style_name` FROM `styles`');
    $find_styles = mysqli_query($db,$sql) or die(mysqli_error($db));

    //繰り返し開始
    while(true) {
    $find_style = mysqli_fetch_assoc($find_styles);
      if($find_style == false){
        break;
      }
    $sql = 'SELECT COUNT(*) as `user_number` FROM `user_styles` WHERE `style_id`='.$find_style['style_id'];

    $count_userstyle_numbers = mysqli_query($db,$sql) or die(mysqli_error($db));
    $count_userstyle_number = mysqli_fetch_assoc($count_userstyle_numbers);
    $find_style['user_number'] = $count_userstyle_number['user_number'];

    $find_style_array[] = $find_style;
    }
    //繰り返し終了

    //$find_style_arrayに含まれるstyle_nameを使って、user_numberを取得する
    foreach($find_style_array as $data) {
      //$$cnameで配列名を成立させるために、$data['style_name']のスペースを詰める処理
      $sname = str_replace(" ","",$data['style_name']);
      if ($data['style_name'] == $sname) {
        $$sname = $data['user_number'];
      }
    }

  //国を選択している人数を表示する処理
    //delete_flag=0のcountry_nameとcountry_idを含む配列$find_country_arrayを作成する
    $find_country_array = array();
    $sql = sprintf('SELECT `country_id`, `country_name` FROM `countries` WHERE `delete_flag` = 0');
    $find_countries = mysqli_query($db,$sql) or die(mysqli_error($db));

    //繰り返し開始
    while(true) {
    $find_country = mysqli_fetch_assoc($find_countries);
      if($find_country == false){
        break;
      }
    $sql = 'SELECT COUNT(*) as `user_number` FROM `user_countries` WHERE `country_id`='.$find_country['country_id'];

    $count_user_numbers = mysqli_query($db,$sql) or die(mysqli_error($db));
    $count_user_number = mysqli_fetch_assoc($count_user_numbers);
    $find_country['user_number'] = $count_user_number['user_number'];

    $find_country_array[] = $find_country;
    }
    //繰り返し終了

    //$find_country_arrayに含まれるcountry_nameを使って、user_numberを取得する
    foreach($find_country_array as $data) {
      //$$cnameで配列名を成立させるために、$data['country_name']のスペースを詰める処理
      $cname = str_replace(" ","",$data['country_name']);
      if ($data['country_name'] == $cname) {
        $$cname = $data['user_number'];
      }
    }

  //セール送信フォームからデータがPOST送信された時の空データと拡張子チェックとエラーがない場合、画像をアップロード
  if (!empty($_POST)) {

    //エラー項目の確認
    //タイトルが入力されていない場合に$error'blank'を代入
    if ($_POST['title'] == '') {
      $error['title'] = 'blank';
    }

    //本文が入力されていない場合に$error'blank'を代入
    if ($_POST['message'] == '') {
      $error['message'] = 'blank';
    }

    //画像ファイルの拡張子チェック（$_FILES）
    $fileName = $_FILES['picture_path']['name'];
    if (!empty($fileName)){

      //拡張子を取得
      $ext = substr($fileName, -3);
      $ext = strtolower($ext);

      if($ext != 'jpg' && $ext != 'gif' && $ext != 'png') {
        $error['picture_path'] = 'type';
      }
    }

      //エラーが無い場合
      if (empty($error)) {
        //画像をディレクトリにアップロードする
        $picture_path = date('YmdHis') . $_FILES['picture_path']['name'];
        move_uploaded_file($_FILES['picture_path']['tmp_name'], 'img/sale/' . $picture_path);

        //セッションに値を保存する
        $_SESSION['admin'] = $_POST;
        $_SESSION['admin']['picture_path'] = $picture_path;

        header('Location: admin_check.php');
      }
    }

  //書き直しの処理
  $select_country = array();
  if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'rewrite'){
    $_POST = $_SESSION['admin'];
    // var_dump($_SESSION['admin']['country']);
    $select_country = $_SESSION['admin']['country'];
    // var_dump($select_country);
    $error['rewrite'] = true;
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
<div id="preloader">
  <div id="status"> <img src="img/preloader.gif" height="64" width="64" alt=""> </div>
</div>
<!-- Navigation -->
<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse"> <i class="fa fa-bars"></i> </button>
      <a class="navbar-brand page-scroll" href="index.php"> <img class="header-logo" src="img/flyhigh_logo_white.png" width="27px" height="27px"> Fly High</a> </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
      <ul class="nav navbar-nav">
        <!-- Hidden li included to remove active class from about link when scrolled up past about section -->
        <li class="hidden"> <a href="#page-top"></a> </li>
        <li> <a class="page-scroll" href="#about">Style</a> </li>
        <li> <a class="page-scroll" href="#services">Country</a> </li>
        <li> <a class="page-scroll" href="#works">Form</a> </li>
        <li> <a class="page-scroll" href="logout.php">Logout</a> </li>
      </ul>
    </div>
    <!-- /.navbar-collapse -->
  </div>
  <!-- /.container -->
</nav>

<!-- Header -->
<div id="intro">
  <div class="intro-body">
    <div class="container">
      <div class="row">
        <div class="col-md-10 col-md-offset-1">
          <h1><span class="brand-heading">Admin</span></h1>
          <!-- <p class="intro-text">There’s no better way to fly.</p>
          <a href="#" class="btn btn-default page-scroll">sign up</a>
          <a href="#" class="btn btn-default page-scroll">log in</a> -->
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Style Section -->
<form method="post" action="" enctype="multipart/form-data" id="send_form">
<div id="about">
  <div class="container">
    <div class="section-title text-center center">
      <h2>スタイルは選べません、登録人数を見るだけです</h2>
      <hr>
    </div>
    <div class="row">
        <div class="col-md-12 columns">
            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                <label class="checkbox-inline" for="alone">
                  <input type="checkbox" name="style[]" value="alone" disabled='disabled' checked='checked'>
                  ひとり旅：<?php echo $alone ?>
                </label>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                <label class="checkbox-inline" for="couple">
                  <input type="checkbox" name="style[]" value="couple" disabled='disabled' checked='checked'>
                  カップル・夫婦：<?php echo $couple ?>
                </label>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                <label class="checkbox-inline" for="family">
                  <input type="checkbox" name="style[]" value="family" disabled='disabled' checked='checked'>
                  家族旅行：<?php echo $family ?>
                </label>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                <label class="checkbox-inline" for="food">
                  <input type="checkbox" name="style[]" id="food" value="food" disabled='disabled' checked='checked'>
                  グルメ：<?php echo $food ?>
                </label>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                <label class="checkbox-inline" for="resort">
                  <input type="checkbox" name="style[]" id="resort" value="resort" disabled='disabled' checked='checked'>
                  リゾート：<?php echo $resort ?>
                </label>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                <label class="checkbox-inline" for="nature">
                  <input type="checkbox" name="style[]" id="nature" value="nature" disabled='disabled' checked='checked'>
                  自然：<?php echo $nature ?>
                </label>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                <label class="checkbox-inline" for="ruins">
                  <input type="checkbox" name="style[]" id="ruins" value="ruins" disabled='disabled' checked='checked'>
                  遺跡：<?php echo $ruins ?>
                </label>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                <label class="checkbox-inline" for="shopping">
                  <input type="checkbox" name="style[]" id="shopping" value="shopping" disabled='disabled' checked='checked'>
                  ショッピング：<?php echo $shopping ?>
                </label>
            </div>
            <!-- スタイルALLを使うか分からないので、コメントアウトしてます -->
<!--             <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                <label class="checkbox-inline" for="all">
                  <input type="checkbox" name="Checkboxes" id="all" value="all">
                  全てのスタイルに送る
                </label>
            </div> -->
        </div>
    </div>
  </div>
</div>

<!-- Services Section -->
<!-- <div id="services" class="text-center"> -->


<div id="services" class="">
<div class="overlay">
  <div class="container box">
    <div class="section-title center">
      <h2 style="color:white">配信先の国を選択</h2>
      <hr>
    </div>
    <div class="row">
      <div class="row">
        <div class="col-md-12 columns">
            <h3>Asia</h3>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <?php if(in_array("UnitedArabEmirates", $select_country)) { ?>
                <label class="checkbox-inline" for="UnitedArabEmirates">
                  <input type="checkbox" name="country[]" value="UnitedArabEmirates" checked='checked'>
                  アラブ首長国連邦：<?php echo $UnitedArabEmirates ?>
                </label>
                <?php }else{ ?>
                <label class="checkbox-inline" for="UnitedArabEmirates">
                  <input type="checkbox" name="country[]" value="UnitedArabEmirates">
                  アラブ首長国連邦：<?php echo $UnitedArabEmirates ?>
                </label>
                <?php } ?>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <?php if(in_array("India", $select_country)) { ?>
                <label class="checkbox-inline" for="India">
                  <input type="checkbox" name="country[]" value="India" checked='checked'>
                  インド：<?php echo $India ?>
                </label>
                <?php }else{ ?>
                <label class="checkbox-inline" for="India">
                  <input type="checkbox" name="country[]" value="India">
                  インド：<?php echo $India ?>
                </label>
                <?php } ?>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <?php if(in_array("Indonesia", $select_country)) { ?>
                <label class="checkbox-inline" for="Indonesia">
                  <input type="checkbox" name="country[]" value="Indonesia" checked='checked'>
                  インドネシア：<?php echo $Indonesia ?>
                </label>
                <?php }else{ ?>
                <label class="checkbox-inline" for="Indonesia">
                  <input type="checkbox" name="country[]" value="Indonesia">
                  インドネシア：<?php echo $Indonesia ?>
                </label>
                <?php } ?>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <?php if(in_array("Qatar", $select_country)) { ?>
                <label class="checkbox-inline" for="Qatar">
                  <input type="checkbox" name="country[]" value="Qatar" checked='checked'>
                  カタール：<?php echo $Qatar ?>
                </label>
                <?php }else{ ?>
                <label class="checkbox-inline" for="Qatar">
                  <input type="checkbox" name="country[]" value="Qatar">
                  カタール：<?php echo $Qatar ?>
                </label>
                <?php } ?>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <?php if(in_array("Korea", $select_country)) { ?>
                <label class="checkbox-inline" for="Korea">
                  <input type="checkbox" name="country[]" value="Korea" checked='checked'>
                  韓国：<?php echo $Korea ?>
                </label>
                <?php }else{ ?>
                <label class="checkbox-inline" for="Korea">
                  <input type="checkbox" name="country[]" value="Korea">
                  韓国：<?php echo $Korea ?>
                </label>
                <?php } ?>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <?php if(in_array("Cambodia", $select_country)) { ?>
                <label class="checkbox-inline" for="Cambodia">
                  <input type="checkbox" name="country[]" value="Cambodia" checked='checked'>
                  カンボジア：<?php echo $Cambodia ?>
                </label>
                <?php }else{ ?>
                <label class="checkbox-inline" for="Cambodia">
                  <input type="checkbox" name="country[]" value="Cambodia">
                  カンボジア：<?php echo $Cambodia ?>
                </label>
                <?php } ?>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <?php if(in_array("Singapore", $select_country)) { ?>
                <label class="checkbox-inline" for="Singapore">
                  <input type="checkbox" name="country[]" value="Singapore" checked='checked'>
                  シンガポール：<?php echo $Singapore ?>
                </label>
                <?php }else{ ?>
                <label class="checkbox-inline" for="Singapore">
                  <input type="checkbox" name="country[]" value="Singapore">
                  シンガポール：<?php echo $Singapore ?>
                </label>
                <?php } ?>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <?php if(in_array("Thailand", $select_country)) { ?>
                <label class="checkbox-inline" for="Thailand">
                  <input type="checkbox" name="country[]" id="Thailand" value="Thailand" checked='checked'>
                  タイ：<?php echo $Thailand ?>
                </label>
                <?php }else{ ?>
                <label class="checkbox-inline" for="Thailand">
                  <input type="checkbox" name="country[]" id="Thailand" value="Thailand">
                  タイ：<?php echo $Thailand ?>
                </label>
                <?php } ?>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <?php if(in_array("Taiwan", $select_country)) { ?>
                <label class="checkbox-inline" for="taiwan">
                  <input type="checkbox" name="country[]" id="taiwan" value="Taiwan" checked='checked'>
                  台湾：<?php echo $Taiwan ?>
                </label>
                <?php }else{ ?>
                <label class="checkbox-inline" for="taiwan">
                  <input type="checkbox" name="country[]" id="taiwan" value="Taiwan">
                  台湾：<?php echo $Taiwan ?>
                </label>
                <?php } ?>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <?php if(in_array("China", $select_country)) { ?>
                <label class="checkbox-inline" for="china">
                  <input type="checkbox" name="country[]" id="china" value="China" checked='checked'>
                  中国：<?php echo $China ?>
                </label>
                <?php }else{ ?>
                <label class="checkbox-inline" for="china">
                  <input type="checkbox" name="country[]" id="china" value="China">
                  中国：<?php echo $China ?>
                </label>
                <?php } ?>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <?php if(in_array("Turkey", $select_country)) { ?>
                <label class="checkbox-inline" for="turkey">
                  <input type="checkbox" name="country[]" id="turkey" value="Turkey" checked='checked'>
                  トルコ：<?php echo $Turkey ?>
                </label>
                <?php }else{ ?>
                <label class="checkbox-inline" for="turkey">
                  <input type="checkbox" name="country[]" id="turkey" value="Turkey">
                  トルコ：<?php echo $Turkey ?>
                </label>
                <?php } ?>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <?php if(in_array("Philippines", $select_country)) { ?>
                <label class="checkbox-inline" for="philippines">
                  <input type="checkbox" name="country[]" id="philippines" value="Philippines" checked='checked'>
                  フィリピン：<?php echo $Philippines ?>
                </label>
                <?php }else{ ?>
                <label class="checkbox-inline" for="philippines">
                  <input type="checkbox" name="country[]" id="philippines" value="Philippines">
                  フィリピン：<?php echo $Philippines ?>
                </label>
                <?php } ?>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <?php if(in_array("VietNam", $select_country)) { ?>
                <label class="checkbox-inline" for="vietnam">
                  <input type="checkbox" name="country[]" id="vietnam" value="VietNam" checked='checked'>
                  ベトナム：<?php echo $VietNam ?>
                </label>
                <?php }else{ ?>
                <label class="checkbox-inline" for="vietnam">
                  <input type="checkbox" name="country[]" id="vietnam" value="VietNam">
                  ベトナム：<?php echo $VietNam ?>
                </label>
                <?php } ?>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <?php if(in_array("HongKong", $select_country)) { ?>
                <label class="checkbox-inline" for="HongKong">
                  <input type="checkbox" name="country[]" id="hongkong_macao" value="HongKong" checked='checked'>
                  香港・マカオ：<?php echo $HongKong ?>
                </label>
                <?php }else{ ?>
                <label class="checkbox-inline" for="HongKong">
                  <input type="checkbox" name="country[]" id="hongkong_macao" value="HongKong">
                  香港・マカオ：<?php echo $HongKong ?>
                </label>
                <?php } ?>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <?php if(in_array("Malaysia", $select_country)) { ?>
                <label class="checkbox-inline" for="malaysia">
                  <input type="checkbox" name="country[]" id="malaysia" value="Malaysia" checked='checked'>
                  マレーシア：<?php echo $Malaysia ?>
                </label><br><br>
                <?php }else{ ?>
                <label class="checkbox-inline" for="malaysia">
                  <input type="checkbox" name="country[]" id="malaysia" value="Malaysia">
                  マレーシア：<?php echo $Malaysia ?>
                </label><br><br>
                <?php } ?>
              </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12 columns">
            <h3>Oceania</h3>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <?php if(in_array("Australia", $select_country)) { ?>
                <label class="checkbox-inline" for="austraria">
                  <input type="checkbox" name="country[]" id="austraria" value="Australia" checked='checked'>
                  オーストラリア：<?php echo $Australia ?>
                </label>
                <?php }else{ ?>
                <label class="checkbox-inline" for="austraria">
                  <input type="checkbox" name="country[]" id="austraria" value="Australia">
                  オーストラリア：<?php echo $Australia ?>
                </label>
                <?php } ?>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <?php if(in_array("Guam", $select_country)) { ?>
                <label class="checkbox-inline" for="guam">
                  <input type="checkbox" name="country[]" id="guam" value="Guam" checked='checked'>
                  グアム：<?php echo $Guam ?>
                </label>
                <?php }else{ ?>
                <label class="checkbox-inline" for="guam">
                  <input type="checkbox" name="country[]" id="guam" value="Guam">
                  グアム：<?php echo $Guam ?>
                </label>
                <?php } ?>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <?php if(in_array("Saipan", $select_country)) { ?>
                <label class="checkbox-inline" for="saipan">
                  <input type="checkbox" name="country[]" id="saipan" value="Saipan" checked='checked'>
                  サイパン：<?php echo $Saipan ?>
                </label>
                <?php }else{ ?>
                <label class="checkbox-inline" for="saipan">
                  <input type="checkbox" name="country[]" id="saipan" value="Saipan">
                  サイパン：<?php echo $Saipan ?>
                </label>
                <?php } ?>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <?php if(in_array("NewCaledonia", $select_country)) { ?>
                <label class="checkbox-inline" for="newcaledonia">
                  <input type="checkbox" name="country[]" id="newcaledonia" value="NewCaledonia" checked='checked'>
                  ニューカレドニア：<?php echo $NewCaledonia ?>
                </label>
                <?php }else{ ?>
                <label class="checkbox-inline" for="newcaledonia">
                  <input type="checkbox" name="country[]" id="newcaledonia" value="NewCaledonia">
                  ニューカレドニア：<?php echo $NewCaledonia ?>
                </label>
                <?php } ?>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <?php if(in_array("NewZealand", $select_country)) { ?>
                <label class="checkbox-inline" for="newzealand">
                  <input type="checkbox" name="country[]" id="newzealand" value="NewZealand" checked='checked'>
                  ニュージーランド：<?php echo $NewZealand ?>
                </label><br><br>
                <?php }else{ ?>
                <label class="checkbox-inline" for="newzealand">
                  <input type="checkbox" name="country[]" id="newzealand" value="NewZealand">
                  ニュージーランド：<?php echo $NewZealand ?>
                </label><br><br>
                <?php } ?>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <?php if(in_array("Hawaii", $select_country)) { ?>
                <label class="checkbox-inline" for="hawaii">
                  <input type="checkbox" name="country[]" id="hawaii" value="Hawaii" checked='checked'>
                  ハワイ：<?php echo $Hawaii ?>
                </label><br><br>
                <?php }else{ ?>
                <label class="checkbox-inline" for="hawaii">
                  <input type="checkbox" name="country[]" id="hawaii" value="Hawaii">
                  ハワイ：<?php echo $Hawaii ?>
                </label><br><br>
                <?php } ?>
              </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12 columns">
            <h3>Europe</h3>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <?php if(in_array("Ireland", $select_country)) { ?>
                <label class="checkbox-inline" for="ireland">
                  <input type="checkbox" name="country[]" id="ireland" value="Ireland" checked='checked'>
                  アイルランド：<?php echo $Ireland ?>
                </label>
                <?php }else{ ?>
                <label class="checkbox-inline" for="ireland">
                  <input type="checkbox" name="country[]" id="ireland" value="Ireland">
                  アイルランド：<?php echo $Ireland ?>
                </label>
                <?php } ?>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <?php if(in_array("UnitedKingdom", $select_country)) { ?>
                <label class="checkbox-inline" for="uk">
                  <input type="checkbox" name="country[]" id="uk" value="UnitedKingdom" checked='checked'>
                  イギリス：<?php echo $UnitedKingdom ?>
                </label>
                <?php }else{ ?>
                <label class="checkbox-inline" for="uk">
                  <input type="checkbox" name="country[]" id="uk" value="UnitedKingdom">
                  イギリス：<?php echo $UnitedKingdom ?>
                </label>
                <?php } ?>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <?php if(in_array("Italy", $select_country)) { ?>
                <label class="checkbox-inline" for="italy">
                  <input type="checkbox" name="country[]" id="italy" value="Italy" checked='checked'>
                  イタリア：<?php echo $Italy ?>
                </label>
                <?php }else{ ?>
                <label class="checkbox-inline" for="italy">
                  <input type="checkbox" name="country[]" id="italy" value="Italy">
                  イタリア：<?php echo $Italy ?>
                </label>
                <?php } ?>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <?php if(in_array("Netherlands", $select_country)) { ?>
                <label class="checkbox-inline" for="netherland">
                  <input type="checkbox" name="country[]" id="netherland" value="Netherlands" checked='checked'>
                  オランダ：<?php echo $Netherlands ?>
                </label>
                <?php }else{ ?>
                <label class="checkbox-inline" for="netherland">
                  <input type="checkbox" name="country[]" id="netherland" value="Netherlands">
                  オランダ：<?php echo $Netherlands ?>
                </label>
                <?php } ?>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <?php if(in_array("Spain", $select_country)) { ?>
                <label class="checkbox-inline" for="spain">
                  <input type="checkbox" name="country[]" id="spain" value="Spain" checked='checked'>
                  スペイン：<?php echo $Spain ?>
                </label>
                <?php }else{ ?>
                <label class="checkbox-inline" for="spain">
                  <input type="checkbox" name="country[]" id="spain" value="Spain">
                  スペイン：<?php echo $Spain ?>
                </label>
                <?php } ?>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <?php if(in_array("Finland", $select_country)) { ?>
                <label class="checkbox-inline" for="finland">
                  <input type="checkbox" name="country[]" id="finland" value="Finland" checked='checked'>
                  フィンランド：<?php echo $Finland ?>
                </label>
                <?php }else{ ?>
                <label class="checkbox-inline" for="finland">
                  <input type="checkbox" name="country[]" id="finland" value="Finland">
                  フィンランド：<?php echo $Finland ?>
                </label>
                <?php } ?>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <?php if(in_array("France", $select_country)) { ?>
                <label class="checkbox-inline" for="france">
                  <input type="checkbox" name="country[]" id="france" value="France" checked='checked'>
                  フランス：<?php echo $France ?>
                </label>
                <?php }else{ ?>
                <label class="checkbox-inline" for="france">
                  <input type="checkbox" name="country[]" id="france" value="France">
                  フランス：<?php echo $France ?>
                </label>
                <?php } ?>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <?php if(in_array("Russia", $select_country)) { ?>
                <label class="checkbox-inline" for="russia">
                  <input type="checkbox" name="country[]" id="russia" value="Russia" checked='checked'>
                  ロシア：<?php echo $Russia ?>
                </label><br><br>
                <?php }else{ ?>
                <label class="checkbox-inline" for="russia">
                  <input type="checkbox" name="country[]" id="russia" value="Russia">
                  ロシア：<?php echo $Russia ?>
                </label><br><br>
                <?php } ?>
              </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12 columns">
            <h3>North_America</h3>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <?php if(in_array("UnitedStates", $select_country)) { ?>
                <label class="checkbox-inline" for="usa">
                  <input type="checkbox" name="country[]" id="usa" value="UnitedStates">
                  アメリカ：<?php echo $UnitedStates ?>
                </label>
                <?php }else{ ?>
                 <label class="checkbox-inline" for="usa">
                  <input type="checkbox" name="country[]" id="usa" value="UnitedStates">
                  アメリカ：<?php echo $UnitedStates ?>
                </label>
                <?php } ?>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <?php if(in_array("Canada", $select_country)) { ?>
                <label class="checkbox-inline" for="Canada">
                  <input type="checkbox" name="country[]" id="Canada" value="Canada">
                  カナダ：<?php echo $Canada ?>
                </label>
                <?php }else{ ?>
                <label class="checkbox-inline" for="Canada">
                  <input type="checkbox" name="country[]" id="Canada" value="Canada">
                  カナダ：<?php echo $Canada ?>
                </label>
                <?php } ?>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <?php if(in_array("Mexico", $select_country)) { ?>
                <label class="checkbox-inline" for="mexico">
                  <input type="checkbox" name="country[]" id="mexico" value="Mexico">
                  メキシコ：<?php echo $Mexico ?>
                </label>
                <?php }else{ ?>
                <label class="checkbox-inline" for="mexico">
                  <input type="checkbox" name="country[]" id="mexico" value="Mexico">
                  メキシコ：<?php echo $Mexico ?>
                </label>
                <?php } ?>
              </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<div id="works" class="text-center">
  <div class="container">
    <div class="section-title center">
      <h2>送信内容を入力</h2>
      <hr>
    </div>

    <div class="col-md-8 col-md-offset-2">
        <!-- タイトル -->
        <div class="row">
            <div class="col-md-12">
              <?php if(isset($_POST['title'])) { ?>
                <input type="title" id="title" name="title" class="form-control" placeholder="タイトルを入力" value="<?php echo htmlspecialchars($_POST['title'], ENT_QUOTES, 'utf-8'); ?>">
                <p class="help-block text-danger"></p>
              <?php }else{ ?>
                <input type="title" id="title" name="title" class="form-control" placeholder="タイトルを入力">
                <p class="help-block text-danger"></p>
              <?php } ?>
            </div>
        </div>

        <!-- 本文 -->
        <div class="row">
            <div class="col-md-12">
              <?php if(isset($_POST['message'])) { ?>
                <textarea type="message" id="message" name="message" class="form-control" rows="10" placeholder="本文を入力"><?php echo htmlspecialchars($_POST['message'], ENT_QUOTES, 'utf-8'); ?></textarea>
                <p class="help-block text-danger"></p>
              <?php }else{ ?>
                <textarea type="message" id="message" name="message" class="form-control" rows="10" placeholder="本文を入力"></textarea>
                <p class="help-block text-danger"></p>
              <?php } ?>
            </div>
        </div>

        <!-- 画像 -->
        <div class="row">
            <div class="col-md-12">
                <input type="file" id="picture_path" name="picture_path" class="form-control">
                <?php if(isset($error['picture_path']) && $error['picture_path'] == 'type') { ?>
                  <p class="error">写真は.gifか.jpgか.pngで指定してください(๑•̀ㅂ•́)و✧</p>
                <?php } ?>
                <?php if (!empty($error)) { ?>
                  <p class="error">画像を改めて指定してください</p>
                <?php } ?>
            </div>
        </div>
        <?php if(isset($error['title']) && $error['title'] == 'blank') { ?>
          <p class="error">タイトルが入力されていません</p>
        <?php } ?>
        <?php if(isset($error['message']) && $error['message'] == 'blank') { ?>
          <p class="error">本文が入力されていません</p>
        <?php } ?>

        <!-- <div id="success"></div> -->
        <!-- この位置だと間違ってログアウトボタンを押しそうなのでヘッダーに移動-->
        <button type="submit" class="btn btn-custom btn-lg2">送信内容を確認</button>
    </div>
  </div>
</div>
</form>


<!-- フッターの外部読み込み-->
<?php include('footer.php'); ?>

<!-- フローティングボタンの外部読み込み-->
<?php include('to-top.php'); ?>

</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script type="text/javascript" src="js/jquery.1.11.1.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script type="text/javascript" src="js/bootstrap.js"></script>
<script type="text/javascript" src="js/admin_bootstrap.js"></script>
<script type="text/javascript" src="js/SmoothScroll.js"></script>
<script type="text/javascript" src="js/jquery.prettyPhoto.js"></script>
<script type="text/javascript" src="js/jquery.isotope.js"></script>
<script type="text/javascript" src="js/jquery.parallax.js"></script>
<script type="text/javascript" src="js/jqBootstrapValidation.js"></script>
<!-- contact_me.jsはメールが送信されました表示の分。これはadmin_checkで表示するため一旦コメントアウト。 -->
<!-- <script type="text/javascript" src="js/contact_me.js"></script>  -->



<!-- Javascripts
    ================================================== -->
<script type="text/javascript" src="js/main.js"></script>
</body>
</html>