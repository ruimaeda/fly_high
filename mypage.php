<?php

session_start();

//ログイン状態のチェック
//1.セッションにIDが入っていること
//2.最後の行動から1時間以内であること
// if ((isset($_SESSION['login_user_id'])) && ($_SESSION['time'] + 3600 > time() )) {
//   $_SESSION['time'] = time();
// }else{
//   header('Location: login.php')
//   exit();
// }

//dbconnect.phpを読み込む
require('dbconnect.php');

//ログインしている人の情報を取得
$sql = sprintf('SELECT * FROM `users` WHERE `user_id` = %d',
       mysqli_real_escape_string($db,$_SESSION['login_user_id']));

$record = mysqli_query($db,$sql) or die(mysqli_error($db));
$user = mysqli_fetch_assoc($record);

//ログインしている人の選択した国情報を取得
// $sql = sprintf('SELECT * FROM `user_countries` INNER JOIN `countries` on `countries`.`country_id` = `user_countries`.`country_id` ');
// $record = mysqli_query($db,$sql) or die(mysqli_error($db));
// $user_country = mysqli_fetch_assoc($record);

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
<link rel="stylesheet" type="text/css"  href="css/mypage.css">
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
<!-- About Section -->
<div id="about">
<h2 class='mypage'>MY PAGE</h2>
<a href="#about" class="btn btn-default page-scroll btn2">編集する</a>
  <div class="container">
      <div class="section-title text-center center">
      <h2>About You</h2>
      <hr>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="about-text">
          <h4>名前</h4>
          <p><?php echo $user['nick_name']; ?></p>
          </div>
      </div>
      <div class="col-md-6">
        <div class="about-text">
          <h4>メールアドレス</h4>
          <p><?php echo $user['email']; ?></p>
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
      <p>あなたが選択した旅のスタイルです。</p>
    </div>
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
          <div class="portfolio-item">
              <img src="img/style/icon_alone.png" class="img-responsive" alt="Project Title">
              <p id="country-name"><?php echo $user['travel_purpose'] ?></p>
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
      <p>あなたが選択した国です。</p>
    </div>
    <div class="categories">
      <ul class="cat">
        <li>
          <ol class="type">
            <li><a href="#" data-filter="*" class="active">全て</a></li>
            <li><a href="#" data-filter=".asia">アジア</a></li>
            <li><a href="#" data-filter=".oceania">オセアニア</a></li>
            <li><a href="#" data-filter=".europe">ヨーロッパ</a></li>
            <li><a href="#" data-filter=".north_america">北米</a></li>
          </ol>
        </li>
      </ul>
      <div class="clearfix"></div>
    </div>
    <div class="row">
      <div class="portfolio-items">
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 europe">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/ireland.jpg" class="img-responsive country-photo check " alt="Project Title"> </a> </div>
              <p id="country-name"><?php echo $user_country['county_name']; ?></p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 north_america">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/usa.jpg" class="img-responsive country-photo check" alt="Project Title"> </a> </div>
              <p id="country-name">アメリカ</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/uae.jpg" class="img-responsive country-photo" alt="Project Title"> </a> </div>
              <p id="country-name">アラブ首長国連邦</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 europe">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/uk.jpg" class="img-responsive country-photo" alt="Project Title"> </a> </div>
              <p id="country-name">イギリス</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 europe">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/italy.jpg" class="img-responsive country-photo" alt="Project Title"> </a> </div>
              <p id="country-name">イタリア</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/india.jpg" class="img-responsive country-photo" alt="Project Title"> </a> </div>
              <p id="country-name">インド</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/indonesia.jpg" class="img-responsive country-photo" alt="Project Title"> </a> </div>
              <p id="country-name">インドネシア</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 oceania">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/australia.jpg" class="img-responsive country-photo" alt="Project Title"> </a> </div>
              <p id="country-name">オーストラリア</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 europe">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/netherland.jpg" class="img-responsive country-photo" alt="Project Title"> </a> </div>
              <p id="country-name">オランダ</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/qatar.jpg" class="img-responsive country-photo" alt="Project Title"> </a> </div>
              <p id="country-name">カタール</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 north_america">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/canada.jpg" class="img-responsive country-photo" alt="Project Title"> </a> </div>
              <p id="country-name">カナダ</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/korea.jpg" class="img-responsive country-photo" alt="Project Title"> </a> </div>
              <p id="country-name">韓国</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/cambodia.jpg" class="img-responsive country-photo" alt="Project Title"> </a> </div>
              <p id="country-name">カンボジア</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 oceania">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/guam.jpg" class="img-responsive country-photo" alt="Project Title"> </a> </div>
              <p id="country-name">グアム</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 oceania">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/saipan.jpg" class="img-responsive country-photo" alt="Project Title"> </a> </div>
              <p id="country-name">サイパン</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/singapore.jpg" class="img-responsive country-photo" alt="Project Title"> </a> </div>
              <p id="country-name">シンガポール</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 europe">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/spain.jpg" class="img-responsive country-photo" alt="Project Title"> </a> </div>
              <p id="country-name">スペイン</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/thailand.jpg" class="img-responsive country-photo" alt="Project Title"> </a> </div>
              <p id="country-name">タイ</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/taiwan.jpg" class="img-responsive country-photo" alt="Project Title"> </a> </div>
              <p id="country-name">台湾</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/china.jpg" class="img-responsive country-photo" alt="Project Title"> </a> </div>
              <p id="country-name">中国</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/turkey.jpg" class="img-responsive country-photo" alt="Project Title"> </a> </div>
              <p id="country-name">トルコ</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 oceania">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/newcaledonia.jpg" class="img-responsive country-photo" alt="Project Title"> </a> </div>
              <p id="country-name">ニューカレドニア</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 oceania">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/newzealand.jpg" class="img-responsive country-photo" alt="Project Title"> </a> </div>
              <p id="country-name">ニュージーランド</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 oceania">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/hawaii.jpg" class="img-responsive country-photo" alt="Project Title"> </a> </div>
              <p id="country-name">ハワイ</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/elnido.jpg" class="img-responsive country-photo" alt="Project Title"> </a> </div>
              <p id="country-name">フィリピン</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 europe">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/finland.jpg" class="img-responsive country-photo" alt="Project Title"> </a> </div>
              <p id="country-name">フィンランド</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 europe">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/france.jpg" class="img-responsive country-photo" alt="Project Title"> </a> </div>
              <p id="country-name">フランス</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/vietnam.jpg" class="img-responsive country-photo" alt="Project Title"> </a> </div>
              <p id="country-name">ベトナム</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/hongkong.jpg" class="img-responsive country-photo" alt="Project Title"> </a> </div>
              <p id="country-name">香港・マカオ</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/malaysia.jpg" class="img-responsive country-photo" alt="Project Title"> </a> </div>
              <p id="country-name">マレーシア</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 north_america">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/mexico.jpg" class="img-responsive country-photo" alt="Project Title"> </a> </div>
              <p id="country-name">メキシコ</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 europe">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/russia.jpg" class="img-responsive country-photo" alt="Project Title"> </a> </div>
              <p id="country-name">ロシア</p>
          </div>
        </div>
      </div>

      </div>
    </div>
  </div>
</div>
<!-- question Section -->
<div id="question">
  <div class="container">
    <div class="section-title text-center center">
      <h2>Additional questions</h2>
      <hr>
    </div>
    <div class="row">
      <div class="col-md-3">
      </div>
      <div class="col-md-3">
        <div class="about-question">
          <!-- <h4><i class="fa fa-question" aria-hidden="true"></i> QUESTION</h4> -->
          <div class="box30">
          <div class="box-title box1">性別</div>
          <p><?php echo $user['gender'] ?></p>
          <p><i class="fa fa-user logo" aria-hidden="true"></i></p>
         <!--  <i class="fa fa-venus-mars logo" aria-hidden="true"></i> -->
          </div>
          <div class="box30">
          <div class="box-title box3">居住地</div>
          <p><?php echo $user['address'] ?></p>
          <p><i class="fa fa-home logo" aria-hidden="true"></i></p>
          </div>
          <div class="box30">
          <div class="box-title box5">料金以外の旅行先の決め手</div>
          <p><?php echo $user['travel_purpose'] ?></p>
          <p><i class="fa fa-university logo" aria-hidden="true"></i></p>
          </div>
          <div class="box30">
          <div class="box-title box7">海外旅行の平均的な期間</div>
          <p><?php echo $user['travel_period'] ?></p>
          <p><i class="fa fa-calendar logo" aria-hidden="true"></i></p>

          </div>
          <div class="box30">
          <div class="box-title box9">過去1年間の海外旅行の回数</div>
          <p><?php echo $user['travel_time'] ?></p>
          <p><i class="fa fa-plane logo" aria-hidden="true"></i></p>
          </div>

          </div>
      </div>
      <div class="col-md-3">
        <div class="about-question">
          <!-- <h4><i class="fa fa-reply" aria-hidden="true"></i> ANSWER</h4> -->
          <div class="box30">
          <div class="box-title box2">年齢</div>
          <p><?php echo $user['age']  ?></p>
          <p><i class="fa fa-binoculars logo" aria-hidden="true"></i></p>
          </div>
          <div class="box30 ">
          <div class="box-title box4">年収</div>
          <p><?php echo $user['income'] ?></p>
          <p><i class="fa fa-money logo" aria-hidden="true"></i></p>
          </div><div class="box30">
          <div class="box-title box6">海外旅行の平均的な予算</div>
          <p><?php echo $user['travel_budget'] ?></p>
          <p><i class="fa fa-diamond logo" aria-hidden="true"></i></p>
          </div>
          <div class="box30">
          <div class="box-title box8">これまでに訪れた国の数</div>
          <p><?php echo $user['travel_country'] ?></p>
          <p><i class="fa fa-globe logo" aria-hidden="true"></i></p>
          </div>

          <div class="box30">
          <div class="box-title box10">FLY HIGHを知ったきっかけ</div>
          <p><?php echo $user['know_flyhigh'] ?></p>
          <p><i class="fa fa-comments-o logo" aria-hidden="true"></i></p>
          </div>
        </div>
        <div class="col-md-3">
        </div>
      </div>
    </div>
  </div>
</div>


</div>

<!-- Contact Section -->
<div id="contact" class="text-center">
  <div class="container">
    <div class="section-title center">
  <!--     <h2>Contact us</h2>
      <hr>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis sed dapibus leo nec ornare diamcommodo nibh ante facilisis.</p>
    </div>
    <div class="col-md-8 col-md-offset-2">
      <div class="col-md-4">
        <div class="contact-item"> <i class="fa fa-map-marker fa-2x"></i>
          <p>4321 California St,<br>
            San Francisco, CA 12345</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="contact-item"> <i class="fa fa-envelope-o fa-2x"></i>
          <p>info@company.com</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="contact-item"> <i class="fa fa-phone fa-2x"></i>
          <p> +1 123 456 1234<br>
            +1 321 456 1234</p>
        </div>
      </div> -->
     <!--  <div class="clearfix"></div>
    </div>
    <div class="col-md-8 col-md-offset-2">
      <h3>Leave us a message</h3>
      <form name="sentMessage" id="contactForm" novalidate>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <input type="text" id="name" class="form-control" placeholder="Name" required="required">
              <p class="help-block text-danger"></p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <input type="email" id="email" class="form-control" placeholder="Email" required="required">
              <p class="help-block text-danger"></p>
            </div>
          </div>
        </div> -->
        <!-- <div class="form-group">
          <textarea name="message" id="message" class="form-control" rows="4" placeholder="Message" required></textarea>
          <p class="help-block text-danger"></p>
        </div> -->
       <!--  <div id="success"></div>
        <button type="submit" class="btn btn-default">Send Message</button>
      </form> -->
      <div class="text-center">
  <button type="submit" class="btn btn-default  ">TOPへ戻る</button>
  <button type="submit" class="btn btn-default ">LOG OUT</button>
  <button type="submit" class="btn btn-default ">編集する</button>
</div>

    </div>
  </div>
</div>
<div id="footer">
  <div class="container">
    <p>Copyright &copy; Modus. Designed by <a href="http://www.templatewire.com" rel="nofollow">TemplateWire</a></p>
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
<script type="text/javascript" src="js/contact_me.js"></script>

<!-- Javascripts
    ================================================== -->
<script type="text/javascript" src="js/main.js"></script>
</body>
</html>