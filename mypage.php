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
var_dump($_SESSION['login_user_id']);

//ログインしている人の選択したスタイル情報を取得
$sql = sprintf('SELECT `style_name`,`style_name_ja` FROM `styles` INNER JOIN `user_styles` on `styles`.`style_id` = `user_styles`.`style_id` WHERE `user_id` = %d',
  mysqli_real_escape_string($db,$_SESSION['login_user_id'])
  );
$record2 = mysqli_query($db,$sql) or die(mysqli_error($db));
//取り出したstyle_nameを$user_styleに繰り返し入れる処理
while(true) {
   $style_record = mysqli_fetch_assoc($record2);
   if($style_record == false){
        break;
      }
    $user_style[] = $style_record;
}
$sql = sprintf('SELECT `country_name`,`country_area`,`country_name_ja` FROM `countries` INNER JOIN `user_countries` on `countries`.`country_id` = `user_countries`.`country_id` WHERE `user_id` = %d',
  mysqli_real_escape_string($db,$_SESSION['login_user_id'])
  );
$record3 = mysqli_query($db,$sql) or die(mysqli_error($db));
//取り出したstyle_nameを$user_styleに繰り返し入れる処理
while(true) {
   $country_record = mysqli_fetch_assoc($record3);
   if($country_record == false){
        break;
      }
    $user_country[] = $country_record;
      }

 var_dump($user_country);
echo "<br>";
 var_dump($user_style);
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
        <li> <a class="page-scroll" href="#style">STYLE</a> </li>
        <li> <a class="page-scroll" href="#country">COUNTRY</a></li>
        <li> <a class="page-scroll" href="#question">QUESTION</a> </li>
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
<a href="edit.php" class="btn btn-default page-scroll btn2">編集する</a>
<div id="about">
<h2 class='mypage'>MY PAGE</h2>

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
    
    <!-- 選択したスタイルを繰り返し表示 -->
    <?php foreach ($user_style as $style) { ?>
      <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
          <div class="portfolio-item">

              <img src="img/style/icon_<?php echo $style['style_name']; ?>.png" class="img-responsive" alt="Project Title">
              <p id="country-name"><?php echo $style['style_name_ja']; ?></p>
          </div>
        </div>
    <?php } ?>

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
      <!-- 選択した国を繰り返し表示 -->
      <?php foreach ($user_country as $country) { ?>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 <?php echo $country['country_area']; ?>">
          <div class="portfolio-item">
            <div class="hover-bg">
              <img src="img/country/<?php echo $country['country_name'];?>.jpg" class="img-responsive check" alt="Project Title"> </a> </div>
              <p id="country-name"><?php echo $country['country_name_ja']; ?></p>
          </div>
        </div>

        <?php } ?>

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
        <div class="about-question　">
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
  <div class="text-center">
    <a href="index.php"><button type="button" class="btn btn-default">TOPへ戻る</button></a>
    <a href="logout.php"><button type="button" class="btn btn-default">LOG OUT</button></a>
    <a href="edit.php"><button type="button" class="btn btn-default">編集する</button></a>
  </div>
</div>

<!-- フッターの外部読み込み-->
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