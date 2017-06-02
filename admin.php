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
      <a class="navbar-brand page-scroll" href="#page-top"> <i class="fa fa-paper-plane-o"></i> FLY HIGH</a> </div>
    
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
      <ul class="nav navbar-nav">
        <!-- Hidden li included to remove active class from about link when scrolled up past about section -->
        <li class="hidden"> <a href="#page-top"></a> </li>
        <li> <a class="page-scroll" href="#about">Style</a> </li>
        <li> <a class="page-scroll" href="#services">Country</a> </li>
        <li> <a class="page-scroll" href="#contact">Form</a> </li>
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

<!-- About Section -->
<div id="about">
  <div class="container">
    <div class="section-title text-center center">
      <h2>Styleを選択</h2>
      <hr>
    </div>
    <div class="row">
      <div class="col-md-12 columns">
          <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
              <label class="checkbox-inline" for="alone">
                <input type="checkbox" name="Checkboxes" id="alone" value="alone">
                ひとり旅
              </label>
          </div>
          <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
              <label class="checkbox-inline" for="couple">
                <input type="checkbox" name="Checkboxes" id="couple" value="couple">
                カップル・夫婦
              </label>
          </div>
          <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
              <label class="checkbox-inline" for="family">
                <input type="checkbox" name="Checkboxes" id="family" value="family">
                家族旅行
              </label>
          </div>
          <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
              <label class="checkbox-inline" for="food">
                <input type="checkbox" name="Checkboxes" id="food" value="food">
                グルメ
              </label>
          </div>
          <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
              <label class="checkbox-inline" for="resort">
                <input type="checkbox" name="Checkboxes" id="resort" value="resort">
                リゾート
              </label>
          </div>
          <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
              <label class="checkbox-inline" for="nature">
                <input type="checkbox" name="Checkboxes" id="nature" value="nature">
                自然
              </label>
          </div>
          <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
              <label class="checkbox-inline" for="ruins">
                <input type="checkbox" name="Checkboxes" id="ruins" value="ruins">
                遺跡
              </label>
          </div>
          <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
              <label class="checkbox-inline" for="shopping">
                <input type="checkbox" name="Checkboxes" id="shopping" value="shopping">
                ショッピング
              </label>
          </div>
          <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
              <label class="checkbox-inline" for="all">
                <input type="checkbox" name="Checkboxes" id="all" value="all">
                運営のおすすめ（全て）
              </label>
          </div>
      </div>
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
      <h2>Countryを選択</h2>
      <hr>
    </div>
    <div class="row">
      <div class="row">
        <div class="col-md-12 columns">
            <h3>Asia</h3>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <label class="checkbox-inline" for="uae">
                  <input type="checkbox" name="Checkboxes" id="uae" value="uae">
                  アラブ首長国連邦
                </label>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <label class="checkbox-inline" for="india">
                  <input type="checkbox" name="Checkboxes" id="india" value="india">
                  インド
                </label>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <label class="checkbox-inline" for="indonesia">
                  <input type="checkbox" name="Checkboxes" id="indonesia" value="indonesia">
                  インドネシア
                </label>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <label class="checkbox-inline" for="qatar">
                  <input type="checkbox" name="Checkboxes" id="qatar" value="qatar">
                  カタール
                </label>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <label class="checkbox-inline" for="korea">
                  <input type="checkbox" name="Checkboxes" id="korea" value="korea">
                  韓国
                </label>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <label class="checkbox-inline" for="cambodia">
                  <input type="checkbox" name="Checkboxes" id="cambodia" value="cambodia">
                  カンボジア
                </label>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <label class="checkbox-inline" for="singapore">
                  <input type="checkbox" name="Checkboxes" id="singapore" value="singapore">
                  シンガポール
                </label>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <label class="checkbox-inline" for="thailand">
                  <input type="checkbox" name="Checkboxes" id="thailand" value="thailand">
                  タイ
                </label>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <label class="checkbox-inline" for="taiwan">
                  <input type="checkbox" name="Checkboxes" id="taiwan" value="taiwan">
                  台湾
                </label>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <label class="checkbox-inline" for="china">
                  <input type="checkbox" name="Checkboxes" id="china" value="china">
                  中国
                </label>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <label class="checkbox-inline" for="turkey">
                  <input type="checkbox" name="Checkboxes" id="turkey" value="turkey">
                  トルコ
                </label>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <label class="checkbox-inline" for="philippines">
                  <input type="checkbox" name="Checkboxes" id="philippines" value="philippines">
                  フィリピン
                </label>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <label class="checkbox-inline" for="vietnam">
                  <input type="checkbox" name="Checkboxes" id="vietnam" value="vietnam">
                  ベトナム
                </label>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <label class="checkbox-inline" for="hongkong_macao">
                  <input type="checkbox" name="Checkboxes" id="hongkong_macao" value="hongkong_macao">
                  香港・マカオ
                </label>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <label class="checkbox-inline" for="malaysia">
                  <input type="checkbox" name="Checkboxes" id="malaysia" value="malaysia">
                  マレーシア
                </label><br><br>
              </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12 columns">
            <h3>Oceania</h3>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <label class="checkbox-inline" for="austraria">
                  <input type="checkbox" name="Checkboxes" id="austraria" value="austraria">
                  オーストラリア
                </label>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <label class="checkbox-inline" for="guam">
                  <input type="checkbox" name="Checkboxes" id="guam" value="guam">
                  グアム
                </label>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <label class="checkbox-inline" for="saipan">
                  <input type="checkbox" name="Checkboxes" id="saipan" value="saipan">
                  サイパン
                </label>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <label class="checkbox-inline" for="newcaledonia">
                  <input type="checkbox" name="Checkboxes" id="newcaledonia" value="newcaledonia">
                  ニューカレドニア
                </label>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <label class="checkbox-inline" for="newzealand">
                  <input type="checkbox" name="Checkboxes" id="newzealand" value="newzealand">
                  ニュージーランド
                </label><br><br>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <label class="checkbox-inline" for="hawaii">
                  <input type="checkbox" name="Checkboxes" id="hawaii" value="hawaii">
                  ハワイ
                </label><br><br>
              </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12 columns">
            <h3>Europe</h3>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <label class="checkbox-inline" for="ireland">
                  <input type="checkbox" name="Checkboxes" id="ireland" value="ireland">
                  アイルランド
                </label>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <label class="checkbox-inline" for="uk">
                  <input type="checkbox" name="Checkboxes" id="uk" value="uk">
                  イギリス
                </label>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <label class="checkbox-inline" for="italy">
                  <input type="checkbox" name="Checkboxes" id="italy" value="italy">
                  イタリア
                </label>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <label class="checkbox-inline" for="netherland">
                  <input type="checkbox" name="Checkboxes" id="netherland" value="netherland">
                  オランダ
                </label>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <label class="checkbox-inline" for="spain">
                  <input type="checkbox" name="Checkboxes" id="spain" value="spain">
                  スペイン
                </label>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <label class="checkbox-inline" for="finland">
                  <input type="checkbox" name="Checkboxes" id="finland" value="finland">
                  フィンランド
                </label>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <label class="checkbox-inline" for="france">
                  <input type="checkbox" name="Checkboxes" id="france" value="france">
                  フランス
                </label>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <label class="checkbox-inline" for="russia">
                  <input type="checkbox" name="Checkboxes" id="russia" value="russia">
                  ロシア
                </label><br><br>
              </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12 columns">
            <h3>North_America</h3>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <label class="checkbox-inline" for="usa">
                  <input type="checkbox" name="Checkboxes" id="usa" value="usa">
                  アメリカ
                </label>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <label class="checkbox-inline" for="canada">
                  <input type="checkbox" name="Checkboxes" id="canada" value="canada">
                  カナダ
                </label>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <label class="checkbox-inline" for="mexico">
                  <input type="checkbox" name="Checkboxes" id="mexico" value="mexico">
                  メキシコ
                </label>
              </div>
        </div>
      </div>
    </div>
  </div>
</div>



<!-- Contact Section スタンダウトから取って来たフォームのやつ -->
<!-- <div id="contact" class="text-center"> -->
<div id="works" class="text-center">
  <div class="container">
    <div class="section-title center">
      <h2>セール内容を入力</h2>
      <hr>
    </div>

    <div class="col-md-8 col-md-offset-2">
      <form type="post" action="" name="sentMessage" id="contactForm" novalidate>
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
            <!-- type="file"が指定されている。 -->
            <!-- <?php if(isset($error['picture_path']) && $error['picture_path']=='type'){ ?> -->
            <!-- <p class="error">*写真は「.gif」「.jpg」「.png」の画像を指定してください。</p> -->
            <!-- <?php } ?> -->
            <!-- nicknameやemailのように戻っても表示させるのは結構大変なので、もう一度指定してもらうように誘導する -->
            <!-- <?php if (!empty($error)): ?> -->
              <!-- <p class="error">* もう一度画像を指定してください。</p> -->
            <!-- <?php endif; ?> -->
          </div>
        </div>

        <!-- テキスト -->
        <div class="form-group">
            <textarea name="message" id="message" class="form-control" rows="10" placeholder="Message" required></textarea>
            <p class="help-block text-danger"></p>
        </div>

        <div id="success"></div>
        <!-- <button type="submit" class="btn btn-custom btn-lg">Send Message</button> -->
        <button type="submit" class="btn btn-custom btn-lg2">送信内容を確認</button>
      </form>

    </div>
  </div>
</div>



<!-- フッターの外部読み込みはできたが、字が白くなっている -->
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