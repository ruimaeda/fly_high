<?php
  session_start();

  //DBへ接続
  require('dbconnect.php');


  //セッションにデータがなかったらsignup.phpへ遷移（動いた◎）
  if (!isset($_SESSION['signup'])) {
    header("Location: signup.php");
  }

  //セッションの中身をサニタイズして変数に代入する
  $nick_name = htmlspecialchars($_SESSION['signup']['nick_name'], ENT_QUOTES, 'UTF-8');
  $email=htmlspecialchars($_SESSION['signup']['email'], ENT_QUOTES, 'UTF-8');
  $password=htmlspecialchars($_SESSION['signup']['password'], ENT_QUOTES, 'UTF-8');
  $re_password=htmlspecialchars($_SESSION['signup']['re_password'], ENT_QUOTES, 'UTF-8');



  // //DB登録処理（パスワードはsha1で暗号化）
  // if (!empty($_POST)) {$sql = sprintf('INSERT INTO');




  //   //SQL文を実行し、うまくいったら遷移する処理
  //   mysqli_query($db, $sql) or die(mysqli_error($db));
  //   header("Location: thanks.php");
  //   exit();

  // }

?>



<!DOCTYPE html>
<html lang="en">
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
<link rel="stylesheet" type="text/css"  href="css/signup.css">
<link rel="stylesheet" type="text/css"  href="css/check.css">
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
      <a class="navbar-brand page-scroll" href="#page-top"> <i class="fa fa-paper-plane-o"></i>FLY HIGH</a> </div>
    
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
      <ul class="nav navbar-nav">
        <!-- Hidden li included to remove active class from about link when scrolled up past about section -->
        <li class="hidden"> <a href="#page-top"></a> </li>
        <li> <a class="page-scroll" href="#about">About</a> </li>
        <li> <a class="page-scroll" href="#services">STYLE</a> </li>
        <li> <a class="page-scroll" href="#works">COUNTRY</a></li>
        <li> <a class="page-scroll" href="#team">QUESTION</a> </li>
       <!--  <li> <a class="page-scroll" href="#testimonials">Testimonials</a> </li>
        <li> <a class="page-scroll" href="#contact">Contact</a> </li> -->
      </ul>
    </div>
    <!-- /.navbar-collapse --> 
  </div>
  <!-- /.container --> 
</nav>

<!-- Header -->
<!-- <div id="intro">
  <div class="intro-body">
    <div class="container">

      <div class="row">
        <div class="col-md-10 col-md-offset-1">
          <h1>Welcom to <span class="brand-heading">My page</span></h1>
          <p class="intro-text"></p>
          </div>
      </div>
    </div>
  </div>
</div> -->

<!-- 登録内容を表示 -->
<!-- About Section -->
<div id="about">
  <div class="container">
  <h2 class="text-center">ご登録の確認</h2>
    <div class="section-title text-center center">
      <h2>About You</h2>
      <hr>
    </div>
    <div class="row">
      <div class="about-text">
        <div class="col-md-6">
          <h4><small>名前</small></h4>
          <p><?php echo $nick_name; ?></p>
        </div>
        <div class="col-md-6">
          <h4><small>メールアドレス</small></h4>
          <p><?php echo $email; ?></p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Style Section -->
<div id="style">
  <div class="container"> <!-- Container -->
    <div class="section-title text-center center">
      <h2>Your style</h2>
      <hr>
      <div class="clearfix"></div>
      <p>旅のスタイルは下記で間違いないですか？</p>
    </div>
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
          <div class="portfolio-item">
              <img src="img/style/icon_alone.png" class="img-responsive" alt="Project Title">
              <p id="country-name">ひとり旅</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
          <div class="portfolio-item">
              <img src="img/style/icon_couple.png" class="img-responsive" alt="Project Title">
              <p id="country-name">カップル・夫婦</p>
          </div>
        </div>
       <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
          <div class="portfolio-item">
              <img src="img/style/icon_family.png" class="img-responsive" alt="Project Title">
              <p id="country-name">家族旅行</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
          <div class="portfolio-item">
              <img src="img/style/icon_food.png" class="img-responsive" alt="Project Title">
              <p id="country-name">グルメ</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
          <div class="portfolio-item">
              <img src="img/style/icon_resort.png" class="img-responsive" alt="Project Title">
              <p id="country-name">リゾート</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
          <div class="portfolio-item">
              <img src="img/style/icon_nature.png" class="img-responsive" alt="Project Title">
              <p id="country-name">自然</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
          <div class="portfolio-item">
              <img src="img/style/icon_ruins.png" class="img-responsive" alt="Project Title">
              <p id="country-name">遺跡</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
          <div class="portfolio-item">
              <img src="img/style/icon_shopping.png" class="img-responsive" alt="Project Title">
              <p id="country-name">ショッピング</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Country Section -->
<div id="country">
  <div class="container"> <!-- Container -->
    <div class="section-title text-center center">
      <h2>Your Country</h2>
      <hr>
      <div class="clearfix"></div>
      <p>あなたが行きたい国は、下記で間違いないですか？</p>
    </div>
    <div class="categories">
      <!-- <ul class="cat">
        <li>
          <ol class="type">
            <li><a href="#" data-filter="*" class="active">全て</a></li>
            <li><a href="#" data-filter=".asia">アジア</a></li>
            <li><a href="#" data-filter=".oceania">オセアニア</a></li>
            <li><a href="#" data-filter=".europe">ヨーロッパ</a></li>
            <li><a href="#" data-filter=".north_america">北米</a></li>
          </ol>
        </li>
      </ul> -->
      <div class="clearfix"></div>
    </div>
    <div class="row">
      <div class="portfolio-items">
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 europe">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/ireland.jpg" class="img-responsive check" alt="Project Title"> </a> </div>
              <p id="country-name">アイルランド</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 north_america">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/usa.jpg" class="img-responsive check" alt="Project Title"> </a> </div>
              <p id="country-name">アメリカ</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/uae.jpg" class="img-responsive" alt="Project Title"> </a> </div>
              <p id="country-name">アラブ首長国連邦</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 europe">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/uk.jpg" class="img-responsive" alt="Project Title"> </a> </div>
              <p id="country-name">イギリス</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 europe">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/italy.jpg" class="img-responsive" alt="Project Title"> </a> </div>
              <p id="country-name">イタリア</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/india.jpg" class="img-responsive" alt="Project Title"> </a> </div>
              <p id="country-name">インド</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/indonesia.jpg" class="img-responsive" alt="Project Title"> </a> </div>
              <p id="country-name">インドネシア</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 oceania">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/australia.jpg" class="img-responsive" alt="Project Title"> </a> </div>
              <p id="country-name">オーストラリア</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 europe">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/netherland.jpg" class="img-responsive" alt="Project Title"> </a> </div>
              <p id="country-name">オランダ</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/qatar.jpg" class="img-responsive" alt="Project Title"> </a> </div>
              <p id="country-name">カタール</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 north_america">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/canada.jpg" width="165" height="110"  class="img-responsive" alt="Project Title"> </a> </div>
              <p id="country-name">カナダ</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/korea.jpg" class="img-responsive" alt="Project Title"> </a> </div>
              <p id="country-name">韓国</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/cambodia.jpg" class="img-responsive" alt="Project Title"> </a> </div>
              <p id="country-name">カンボジア</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 oceania">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/guam.jpg" class="img-responsive" alt="Project Title"> </a> </div>
              <p id="country-name">グアム</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 oceania">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/saipan.jpg" class="img-responsive" alt="Project Title"> </a> </div>
              <p id="country-name">サイパン</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/singapore.jpg" class="img-responsive" alt="Project Title"> </a> </div>
              <p id="country-name">シンガポール</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 europe">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/spain.jpg" class="img-responsive" alt="Project Title"> </a> </div>
              <p id="country-name">スペイン</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/thailand.jpg" class="img-responsive" alt="Project Title"> </a> </div>
              <p id="country-name">タイ</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/taiwan.jpg" class="img-responsive" alt="Project Title"> </a> </div>
              <p id="country-name">台湾</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/china.jpg" class="img-responsive" alt="Project Title"> </a> </div>
              <p id="country-name">中国</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/turkey.jpg" class="img-responsive" alt="Project Title"> </a> </div>
              <p id="country-name">トルコ</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 oceania">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/newcaledonia.jpg" class="img-responsive" alt="Project Title"> </a> </div>
              <p id="country-name">ニューカレドニア</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 oceania">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/newzealand.jpg" class="img-responsive" alt="Project Title"> </a> </div>
              <p id="country-name">ニュージーランド</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 oceania">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/hawaii.jpg" class="img-responsive" alt="Project Title"> </a> </div>
              <p id="country-name">ハワイ</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/elnido.jpg" class="img-responsive" alt="Project Title"> </a> </div>
              <p id="country-name">フィリピン</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 europe">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/finland.jpg" class="img-responsive" alt="Project Title"> </a> </div>
              <p id="country-name">フィンランド</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 europe">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/france.jpg" class="img-responsive" alt="Project Title"> </a> </div>
              <p id="country-name">フランス</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/vietnam.jpg" class="img-responsive" alt="Project Title"> </a> </div>
              <p id="country-name">ベトナム</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/hongkong.jpg" class="img-responsive" alt="Project Title"> </a> </div>
              <p id="country-name">香港・マカオ</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/malaysia.jpg" class="img-responsive" alt="Project Title"> </a> </div>
              <p id="country-name">マレーシア</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 north_america">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/mexico.jpg" class="img-responsive" alt="Project Title"> </a> </div>
              <p id="country-name">メキシコ</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 europe">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/russia.jpg" class="img-responsive" alt="Project Title"> </a> </div>
              <p id="country-name">ロシア</p>
          </div>
        </div>
      </div>
      </div>
    </div>
  </div>
</div>
</div>


<!-- ボタンsectionのdivを作り、新しくid=buttonを付ける -->
<!-- <form method="post" action=""> -->
<div id="button">
  <div class="container">
    <div class="text-center">
      <a href="signup.php" type="submit" class="btn btn-default">書き直す</a>
      <!-- <a href="signup.php?action=rewrite" class="btn btn-default">&laquo;&nbsp;書き直す</a> -->
      <button type="submit" class="btn btn-default">登録する</button>
    </div>
  </div>
</div>


<?php include('footer.php'); ?>

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

<!-- Javascripts
    ================================================== --> 
<script type="text/javascript" src="js/main.js"></script>
</body>
</html>