<?php 

session_start();

require('dbconnect.php');

//ログインしているユーザー情報の取得
$sql = sprintf('SELECT * FROM `users` WHERE `user_id` = %d',
       mysqli_real_escape_string($db,$_SESSION['login_user_id']));

$record = mysqli_query($db,$sql) or die(mysqli_error($db));
$user = mysqli_fetch_assoc($record);


if (isset($_POST) && !empty($_POST)){

  //エラー項目の確認：pass(文字長６文字以上)
  if (strlen($_POST['password'])<6) {
    $error['password']='length';
  }

  $sql = sprintf('SELECT `email` FROM `users` WHERE `email` = "%s"',
    mysqli_real_escape_string($db,$_POST['email'])
    );

    //SQLを実行
    $user_emails = mysqli_query($db,$sql) or die(mysqli_error($db));
    $user_email = mysqli_fetch_assoc($user_emails);

    $email=htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');

    //エラー項目の確認（ブランクの場合についてはjsで表示済）
    //エラー項目の確認：email（＠マークがない場合をエラーにする）
    if ($email !== "" && strpos($email, "@") === FALSE){
      $error['email'] = "wrong";
    }

    //エラー項目の確認：:email（すでに登録されています処理=DBを使う）
    // if ($_POST['email'] == $user_email['email']) {
    //   $error['email']='already';
    // }

   //エラー項目の確認：確認用pass
  if ($_POST['re_password'] !== $_POST['password']) {
    $error['re_password']='not_same';
  }

  //ニックネーム、メール、パスワードのアップデート 
if(empty($error)){

  $sql = sprintf('UPDATE `users` SET `nick_name`="%s" ,`email` ="%s", `password` ="%s"  WHERE `user_id`= %d',
  mysqli_real_escape_string($db,$_POST['nick_name']),
  mysqli_real_escape_string($db,$_POST['email']),
  mysqli_real_escape_string($db,sha1($_POST['password'])),
  mysqli_real_escape_string($db,$_SESSION['login_user_id']));


   mysqli_query($db,$sql) or die(mysqli_error($db));
    }

    //追加の質問、チェックボックス（旅の目的）のアップデート
if (isset($_POST['travel_purpose']) && is_array($_POST['travel_purpose'])) {
  $travel_purpose = implode("、", $_POST["travel_purpose"]);

  $sql = sprintf('UPDATE `users` SET `travel_purpose` ="%s"
  WHERE `user_id`= %d',
  mysqli_real_escape_string($db,$travel_purpose),
  mysqli_real_escape_string($db,$_SESSION['login_user_id']));

  mysqli_query($db,$sql) or die(mysqli_error($db));
}


//追加の質問のアップデート
if(empty($error)){


  $sql = sprintf('UPDATE `users` SET `age` ="%s" ,`address`  ="%s" ,`income` ="%s" ,`travel_budget` ="%s" ,`travel_period` ="%s" ,`travel_country` ="%s"  ,`travel_time`="%s" ,`know_flyhigh`="%s",`demand`="%s" ,`gender`="%s"
    WHERE `user_id`= %d',

  mysqli_real_escape_string($db,$_POST['age']),
  mysqli_real_escape_string($db,$_POST['address']),
  mysqli_real_escape_string($db,$_POST['income']),
  mysqli_real_escape_string($db,$_POST['travel_budget']),
  mysqli_real_escape_string($db,$_POST['travel_period']),
  mysqli_real_escape_string($db,$_POST['travel_country']),
  mysqli_real_escape_string($db,$_POST['travel_time']),
  mysqli_real_escape_string($db,$_POST['know_flyhigh']),
  mysqli_real_escape_string($db,$_POST['demand']),
  mysqli_real_escape_string($db,$_POST['gender']),
  mysqli_real_escape_string($db,$_SESSION['login_user_id']));
 
  mysqli_query($db,$sql) or die(mysqli_error($db));

 header('Location: mypage.php');
 exit();
}



    
     
  }

// var_dump($travel_purpose);

?>



<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>FLYHIGH</title>
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
<link rel="stylesheet" type="text/css"  href="css/signup.css">
<link rel="stylesheet" type="text/css"  href="css/edit.css">
<link rel="stylesheet" type="text/css"  href="css/thanks.css">
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
      <a class="navbar-brand page-scroll" href="#page-top"> <i class="fa fa-paper-plane-o"></i> FLYHIGH</a> </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
      <ul class="nav navbar-nav">
        <!-- Hidden li included to remove active class from about link when scrolled up past about section -->
        <li class="hidden"> <a href="#page-top"></a> </li>
        <li> <a class="page-scroll" href="#style">Style</a> </li>
        <li> <a class="page-scroll" href="#country">Country</a> </li>
        <li> <a class="page-scroll" href="#country">Country</a> </li>
      </ul>
    </div>
    <!-- /.navbar-collapse -->
  </div>
  <!-- /.container -->
</nav>

<!-- Header -->
<form action="" method="post">
  <div id="intro">
  <div class="intro-body bg">
    <div class="container box">
      <h1>Edit</h1>
                <p class="lead">ご登録いただいた情報を変更できます</p>
                <br><br><br>
        <div class="row">
            <div class="col-sm-offset-4 col-sm-4">
              <!-- <form method="post"　action=""> -->
                <div class="form-group">
                  <div class="input-group" data-validate="email">
                    <input type="text" class="form-control" name="nick_name" id="validate-email" value="<?php echo $user['nick_name'] ?>" required>
                    <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group" data-validate="email">
                    <input type="text" class="form-control" name="email" id="validate-email" value="<?php echo $user['email'] ?>" required>
                    <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
                  </div>

                  <!-- すでに登録されている時の表示(ok) -->
                <!--   <?php if(isset($error['email']) && $error['email']=='already'){ ?>
                    <p class="error">* このメールアドレスはすでに登録されています。</p>
                  <?php } ?> -->
                  <!-- ＠マークない場合の表示(ok) -->
                  <?php if(isset($error['email']) && $error['email']=='wrong'){ ?>
                    <p class="error">* メールアドレスに@が含まれていません。</p>
                  <?php } ?>

                </div>
                <div class="form-group">
                  <div class="input-group" data-validate="email">
                    <input type="password" class="form-control" name="password" id="validate-email" value="<?php echo $user['password'] ?>" email your-email "example@example.com" 　required>
                    <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
                  </div>

                  <!-- 字数エラーの処理(ok) -->
                  <?php if(isset($error['password']) && $error['password']=='length'){ ?>
                    <p class="error">* passwordは6文字以上で入力してください</p>
                  <?php } ?>


                </div>
                <div class="form-group">
                  <div class="input-group" data-validate="email">
                    <input type="text" class="form-control" name="re_password" id="validate-email" value="<?php echo $user['password'] ?>" required>
                    <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
                  </div>
                  <!-- パスワード確認の処理(ok) -->
                  <?php if(isset($error['re_password']) && $error['re_password']=='not_same'){ ?>
                    <p class="error">* passwordが違います</p>
                  <?php } ?>

                </div>
               <!--  <button type="submit" class="btn btn-default">情報を更新する</button>
                </form> -->
            </div>
        </div>
    </div>
  </div>
</div>
<!-- Style Section -->
<div id="style">
  <div class="container"> <!-- Container -->
    <div class="section-title text-center center">
      <h2>Choose Your style</h2>
      <hr>
      <div class="clearfix"></div>
      <p>旅のスタイルを選んでください。</p>
    </div>
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
          <div class="portfolio-item">

        <!-- value 選ばれている時1 選ばれてない時0　の実装 -->
              <input type="image" value="" name="alone" img src="img/style/icon_alone.png" class="img-responsive style-photo check" alt="Project Title">
              <p id="country-name">ひとり旅</p>
              

          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
          <div class="portfolio-item">

              <input type="image" value="" name='couple'  img src="img/style/icon_couple.png" class="img-responsive style-photo check" alt="Project Title">
              <p id="country-name">カップル・夫婦</p>
          
          </div>
        </div>
       <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
          <div class="portfolio-item">
              <input type="image" value="" name="family" img src="img/style/icon_family.png" class="img-responsive style-photo check" alt="Project Title">
              <p id="country-name">家族旅行</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
          <div class="portfolio-item">
              <input type="image" value="" name="food" img src="img/style/icon_food.png" class="img-responsive style-photo check" alt="Project Title">
              <p id="country-name">グルメ</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
          <div class="portfolio-item">
              <input type="image" value="" name="resort" img src="img/style/icon_resort.png" class="img-responsive style-photo check" alt="Project Title">
              <p id="country-name">リゾート</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
          <div class="portfolio-item">
              <input type="image" value="" name="nature" img src="img/style/icon_nature.png" class="img-responsive style-photo check" alt="Project Title">
              <p id="country-name">自然</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
          <div class="portfolio-item">
              <input type="image" value="" name="ruins"  img src="img/style/icon_ruins.png" class="img-responsive style-photo check" alt="Project Title">
              <p id="country-name">遺跡</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
          <div class="portfolio-item">
              <input type="image" value="" name="shopping" img src="img/style/icon_shopping.png" class="img-responsive style-photo check" alt="Project Title">
              <p id="country-name">ショッピング</p>
          </div>
        </div>
      </div>
    </div>
  </div>
<!-- </div> -->
<!-- Country Section -->
<div id="country">
  <div class="container"> <!-- Container -->
    <div class="section-title text-center center">

      <h2>Choose Your Country</h2>
      <hr>
      <div class="clearfix"></div>
      <p>あなたが行きたい場所を選んでください。</p>
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
              <img src="img/country/ireland.jpg" class="img-responsive check" id= "click-country" alt="アイルランド">
            </div>
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
              <img src="img/country/canada.jpg" class="img-responsive" alt="Project Title"> </a> </div>
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
<!-- </form> -->
<!-- Additional Question Section -->
<div id="add-question">
  <div class="container">
    <div class="section-title text-center">
       <h2>Additional Questions</h2>
       <hr>
       <p>もしよければ、あなたの情報をもっと教えてください</p>
    </div>
       <div class="row">
               <!-- <form class="form-horizontal"> -->
               <fieldset class="questions">

               <!-- Multiple Radios -->
               <div class="form-group">
                 <label class="col-md-4 control-label" for="radios">性別</label>
                 <div class="col-md-4">
                 <div class="radio">
                   <label for="radios-0">
                     <input type="radio" name="gender" id="radios-0" value="男性" checked="checked">
                     男性
                   </label>
                 </div>
                 <div class="radio">
                   <label for="radios-1">
                     <input type="radio" name="gender" id="radios-1" value="女性">
                     女性
                   </label>
                 </div>
                 </div>
               </div>

               <!-- Select Basic -->
               <div class="form-group">
                 <label class="col-md-4 control-label" for="selectbasic">年齢</label>
                 <div class="col-md-4">
                   <select id="selectbasic" name="age" class="form-control">
                     <option value="10代">10代</option>
                     <option value="20代">20代</option>
                     <option value="30代">30代</option>
                     <option value="40代">40代</option>
                     <option value="50代">50代</option>
                     <option value="60代以上">60代以上</option>
                   </select>
                 </div>
               </div>

               <!-- Select Basic -->
               <div class="form-group">
                 <label class="col-md-4 control-label" for="selectbasic">居住地</label>
                 <div class="col-md-4">
                   <select id="selectbasic" name="address" class="form-control">
                     <option value="北海道">北海道</option>
                     <option value="関東">関東</option>
                     <option value="甲信越">甲信越</option>
                     <option value="北陸">北陸</option>
                     <option value="中部">中部</option>
                     <option value="関西">関西</option>
                     <option value="中国">中国</option>
                     <option value="九州・沖縄">九州・沖縄</option>
                     <option value="海外">海外</option>
                   </select>
                 </div>
               </div>

               <!-- Select Basic -->
               <div class="form-group">
                 <label class="col-md-4 control-label" for="selectbasic">年収</label>
                 <div class="col-md-4">
                   <select id="selectbasic" name="income" class="form-control">
                     <option value="300万円未満">300万円未満</option>
                     <option value="300万円〜500万円">300万円〜500万円</option>
                     <option value="500万円〜700万円">500万円〜700万円未満</option>
                     <option value="700万円〜1000万円">700万円〜1000万円</option>
                     <option value="1000万円以上">1000万円以上</option>
                   </select>
                 </div>
               </div>

               <!-- Multiple Checkboxes -->
               <div class="form-group">
                 <label class="col-md-4 control-label" for="checkboxes">海外旅行先の決め手</label>
                 <div class="col-md-4">
                 <div class="checkbox">
                   <label for="checkboxes-0">
                     <input type="checkbox" name="travel_purpose[]" id="checkboxes-0" value="自然">
                     自然
                   </label>
                 </div>
                 <div class="checkbox">
                   <label for="checkboxes-1">
                     <input type="checkbox" name="travel_purpose[]" id="checkboxes-1" value="歴史的建造物">
                     歴史的建造物
                   </label>
                 </div>
                 <div class="checkbox">
                   <label for="checkboxes-2">
                     <input type="checkbox" name="travel_purpose[]" id="checkboxes-0" value="リゾート・ビーチ">
                     リゾート・ビーチ
                   </label>
                 </div>
                 <div class="checkbox">
                   <label for="checkboxes-2">
                     <input type="checkbox" name="travel_purpose[]" id="checkboxes-0" value="ショッピング">
                     ショッピング
                   </label>
                 </div>
                 <div class="checkbox">
                   <label for="checkboxes-2">
                     <input type="checkbox" name="travel_purpose[]" id="checkboxes-0" value="グルメ">
                     グルメ
                   </label>
                 </div>
                  <div class="checkbox">
                   <label for="checkboxes-2">
                     <input type="checkbox" name="travel_purpose[]" id="checkboxes-0" value="異文化体験">
                     異文化体験
                   </label>
                   <div class="checkbox">
                   <label for="checkboxes-2">
                     <input type="checkbox" name="travel_purpose[]" id="checkboxes-0" value="イベント">
                     イベント
                   </label>
                 </div>
                 <div class="checkbox">
                   <label for="checkboxes-2">
                     <input type="checkbox" name="travel_purpose[]" id="checkboxes-0" value="テーマパーク">
                     テーマパーク
                   </label>
                 </div>
                  <div class="checkbox">
                   <label for="checkboxes-2">
                     <input type="checkbox" name="travel_purpose[]" id="checkboxes-0" value="スポーツやアクティビティ">
                     スポーツやアクティビティ
                   </label>
                 </div>
                  <div class="checkbox">
                   <label for="checkboxes-2">
                     <input type="checkbox" name="travel_purpose[]" id="checkboxes-0" value="現地の人との交流">
                     現地の人との交流
                   </label>
                 </div>
                  <div class="checkbox">
                   <label for="checkboxes-2">
                     <input type="checkbox" name="travel_purpose[]" id="checkboxes-0" value="エステ・美容">
                     エステ・美容
                   </label>
                 </div>
                 </div>
                 </div>
               </div>

               <!-- Select Basic -->
               <div class="form-group">
                 <label class="col-md-4 control-label" for="selectbasic">海外旅行の平均的な予算</label>
                 <div class="col-md-4">
                   <select id="selectbasic" name="travel_budget" class="form-control">
                     <option value="〜5万円">〜5万円</option>
                     <option value="5万円〜10万円">5万円〜10万円</option>
                     <option value="10万円〜20万円">10万円〜20万円</option>
                     <option value="20万円〜30万円">20万円〜30万円</option>
                     <option value="30万円〜40万円">30万円〜40万円</option>
                     <option value="40万円〜">40万円〜</option>
                   </select>
                 </div>
               </div>

               <!-- Select Basic -->
               <div class="form-group">
                 <label class="col-md-4 control-label" for="selectbasic">海外旅行の平均的な期間</label>
                 <div class="col-md-4">
                   <select id="selectbasic" name="travel_period" class="form-control">
                     <option value="3日以内">3日以内</option>
                     <option value="3~5日以内">3~5日間</option>
                     <option value="5~7日以内">5日~7日</option>
                     <option value="7~9日以内">7~9日間</option>
                     <option value="9日~">9日~</option>
                   </select>
                 </div>
               </div>

               <!-- Select Basic -->
               <div class="form-group">
                 <label class="col-md-4 control-label" for="selectbasic">これまでに訪れた国の数</label>
                 <div class="col-md-4">
                   <select id="selectbasic" name="travel_country" class="form-control">
                     <option value="0カ国">0ヶ国</option>
                     <option value="1~5カ国">1~5ヶ国</option>
                     <option value="6~10カ国">6~10ヶ国</option>
                     <option value="11~20カ国">11~20ヶ国</option>
                     <option value="21~30カ国">21~30ヶ国</option>
                     <option value="31カ国~">31ヶ国~</option>
                   </select>
                 </div>
               </div>
               <!-- Select Basic -->
               <div class="form-group">
                 <label class="col-md-4 control-label" for="selectbasic">過去1年間の海外旅行の回数</label>
                 <div class="col-md-4">
                   <select id="selectbasic" name="travel_time" class="form-control">
                     <option value="0回">0回</option>
                     <option value="1回">1回</option>
                     <option value="2回">2回</option>
                     <option value="3~5回">3~5回</option>
                     <option value="6~10回以上">6~10回</option>
                     <option value="11回~">11回~</option>
                   </select>
                 </div>
               </div>

               <!-- Select Basic -->
               <div class="form-group">
                 <label class="col-md-4 control-label" for="selectbasic">Fly Highを知ったキッカケ</label>
                 <div class="col-md-4">
                   <select id="selectbasic" name="know_flyhigh" class="form-control">
                     <option value="友人・知人">友人・知人</option>
                     <option value="開発メンバー">開発メンバー</option>
                     <option value="検索サイト">検索サイト</option>
                     <option value="他サイトでの紹介">他サイトでの紹介</option>
                     <option value="その他">その他</option>
                   </select>
                 </div>
               </div>

               <!-- Textarea -->
               <div class="form-group">
                 <label class="col-md-4 control-label" for="textarea">サイトへのご要望</label>
                 <div class="col-md-4">
                   <textarea class="form-control" id="textarea" name="demand">要望を入力してください</textarea>
                 </div>
               </div>
               
               </fieldset>
           </div>
       </div>

       <br><br><br>
      <div class="text-center">
        <button type="" class="btn btn-default">TOPページに戻る</button>
        <button type="submit" class="btn btn-default">情報を更新する</button>
        <button type="" class="btn btn-default">マイページに戻る</button>
      </div>

      <div class="text-center agree">
      Fly Highを退会する場合は<a hreaf="">こちら</a>をクリック
      </div>

  </div>

  </div>
</div>
</form>

<div id="footer">
  <div class="container">
    <p>Copyright &copy; FlyHigh</p>
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
<script type="text/javascript" src="js/signup.js"></script>

<!-- Javascripts
    ================================================== -->
<script type="text/javascript" src="js/main.js"></script>
</body>
</html>