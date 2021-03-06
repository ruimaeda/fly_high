<?php
  session_start();

  //DBへ接続
  require('dbconnect.php');

  //セッションにデータがなかったらsignup.phpへ遷移（ok）
  if (!isset($_SESSION['signup'])) {
    header("Location: signup.php");
  }

  //セッションの中身をサニタイズして変数に代入する
  $nick_name = htmlspecialchars($_SESSION['signup']['nick_name'], ENT_QUOTES, 'UTF-8');
  $email=htmlspecialchars($_SESSION['signup']['email'], ENT_QUOTES, 'UTF-8');
  $password=htmlspecialchars($_SESSION['signup']['password'], ENT_QUOTES, 'UTF-8');
  $re_password=htmlspecialchars($_SESSION['signup']['re_password'], ENT_QUOTES, 'UTF-8');

  if (isset($_SESSION['signup']['style'])) {
    $style = $_SESSION['signup']['style'];
  }else{
    $style = null;
  }
  if (isset($_SESSION['signup']['country'])) {
    $country = $_SESSION['signup']['country'];
  }else{
    $country = null;
  }


  //1.DB登録処理(ok、ただし国とスタイル除く)--------------------------
  if (!empty($_POST)) {//hiddenのポスト!

    $sql = sprintf('INSERT INTO `users` (`nick_name`, `email`, `password`, `created`, `modified`) VALUES ("%s", "%s", "%s", now(), now());',
        mysqli_real_escape_string($db,$_SESSION['signup']['nick_name']),
        mysqli_real_escape_string($db,$_SESSION['signup']['email']),
        mysqli_real_escape_string($db,sha1($_SESSION['signup']['password']))
        );
    //SQL文を実行
    mysqli_query($db, $sql) or die(mysqli_error($db));

  //2.ユーザーIDと国IDを国ユーザーテーブルに登録する
    //2-1.ユーザーIDを取ってくる（ユーザーテーブル）(ok)
    $sql = sprintf('SELECT `user_id` FROM `users` WHERE `email` = "%s"',
      mysqli_real_escape_string($db,$email)
      );
      //SQL文の実行と変数への代入
      $select_user_ids = mysqli_query($db,$sql) or die(mysqli_error($db));
      $select_user_id = mysqli_fetch_assoc($select_user_ids);

      //３.ユーザーIDとスタイルIDをユーザースタイルテーブルに登録し、
      //４.スタイルIDから国IDを取ってきてユーザー国テーブルに登録する。

        //3-1.スタイル名($style)からそれぞれのスタイルIDを取ってくる（スタイルテーブル）
        $select_style_id_array = array();
        foreach ($style as $select_styles) {
          $sql = sprintf('SELECT `style_id` FROM `styles` WHERE `style_name` = "%s"',
            mysqli_real_escape_string($db,$select_styles)
            );
            //SQL文の実行と変数への代入
            $select_style_ids = mysqli_query($db,$sql) or die(mysqli_error($db));
            $select_style_id = mysqli_fetch_assoc($select_style_ids);
            // $select_style_id_array[] = $select_style_id['style_id'];

        //3-2.スタイルIDとユーザーIDをINSERTする（ユーザースタイルテーブル）
          $sql = sprintf('INSERT INTO `user_styles` (`user_id`, `style_id`) VALUES ("%s", "%s");',
              mysqli_real_escape_string($db,$select_user_id['user_id']),
              mysqli_real_escape_string($db,$select_style_id['style_id'])
              );
            if($select_style_id['style_id'] == false){
              break;
            }
            mysqli_query($db, $sql) or die(mysqli_error($db));

        //選んだスタイルからユーザーIDと国IDを登録する

          //4-1.スタイルIDから国IDを取ってくる（国スタイルテーブル）
          $select_country_id_array2 = array();
            $sql = sprintf('SELECT `country_id` FROM `country_styles` WHERE `style_id` = "%s"',
              mysqli_real_escape_string($db,$select_style_id['style_id'])
              );
              //SQL文の実行と変数への代入
              $select_country_ids2 = mysqli_query($db,$sql) or die(mysqli_error($db));
              // $select_country_id2 = mysqli_fetch_assoc($select_country_ids2);

              while(true) {
                $select_country_id2 = mysqli_fetch_assoc($select_country_ids2);
                  if($select_country_id2 == false){
                    break;
                  }

      //4-2.国IDとユーザーIDをINSERT（ユーザー国テーブル）
          $sql = sprintf('INSERT INTO `user_countries` (`user_id`, `country_id`, `style_flag`) VALUES ("%s", "%s", 1)',
              mysqli_real_escape_string($db,$select_user_id['user_id']),
              mysqli_real_escape_string($db,$select_country_id2['country_id'])
              );
            mysqli_query($db, $sql) or die(mysqli_error($db));
              }//while文
        }//ユーザースタイルテーブルのforeach文

    //2-2.国の名前($country)からそれぞれの国IDを取ってくる（国テーブル）
    $select_country_id_array = array();//←foreachの外で使うため？
    foreach ($country as $select_countries) {
      $sql = sprintf('SELECT `country_id` FROM `countries` WHERE `country_name` = "%s"',
        mysqli_real_escape_string($db,$select_countries)
        );
        //SQL文の実行と変数への代入
        $select_country_ids = mysqli_query($db,$sql) or die(mysqli_error($db));
        $select_country_id = mysqli_fetch_assoc($select_country_ids);

    //2-3.国IDとユーザーIDをINSERTする（ユーザー国テーブル）
      $sql = sprintf('INSERT INTO `user_countries` (`user_id`, `country_id`, `style_flag`) VALUES ("%s", "%s", 0)',
          mysqli_real_escape_string($db,$select_user_id['user_id']),
          mysqli_real_escape_string($db,$select_country_id['country_id'])
          );
        if($select_country_id['country_id'] == false){
          break;
        }
        mysqli_query($db, $sql) or die(mysqli_error($db));
    } //foreach文ここ！


    //5.全てのINSERT終了後、ユーザー国テーブルの重複を削除する
    $sql = sprintf('DELETE FROM `user_countries` WHERE `user_country_id` NOT IN (SELECT Max_id FROM (SELECT MAX(`user_country_id`) Max_id FROM `user_countries` GROUP BY `user_id`, `country_id`) tmp)');

    mysqli_query($db, $sql) or die(mysqli_error($db));

    header("Location: thanks.php");
    exit();

  }//全体のPOST送信があったら。

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
      <a href="index.php" class="navbar-brand page-scroll">
      <img class="header-logo" src="img/flyhigh_logo_white.png" width="27px" height="27px"> FLY HIGH</a> </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
      <ul class="nav navbar-nav">
        <!-- Hidden li included to remove active class from about link when scrolled up past about section -->
        <li class="hidden"> <a href="#page-top"></a> </li>
        <li> <a class="page-scroll" href="#about">About</a> </li>
        <li> <a class="page-scroll" href="#style">STYLE</a> </li>
        <li> <a class="page-scroll" href="#country">COUNTRY</a></li>
       <!--  <li> <a class="page-scroll" href="#testimonials">Testimonials</a> </li>
        <li> <a class="page-scroll" href="#contact">Contact</a> </li> -->
      </ul>
    </div>
    <!-- /.navbar-collapse -->
  </div>
  <!-- /.container -->
</nav>


<!-- 全ての入力項目をformで囲み、hiddenで値を受け渡しする -->
<form id="form_check" method="post" action="">
<input type="hidden" name="action" value="submit">

<!-- 登録内容を表示 -->
<!-- About Section -->
<div id="about">
  <div class="container">
  <h1 class="text-center">ご登録の確認</h1>
    <div class="section-title text-center center">
      <h2>About You</h2>
      <hr>
    </div>
    <div class="row">
        <div class="about-text">
          <div class="col-md-6">
            <h4><small>お名前</small></h4>
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
      <p>旅のスタイルは、下記で間違いないですか？</p>
    </div>
    <div class="row">

      <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
        <div class="portfolio-item">
          <?php if(in_array("alone", (array)$style)) { ?>
              <img src="img/style/icon_alone.png" class="img-responsive style-photo selected" alt="ひとり旅">
          <?php }else{ ?>
              <img src="img/style/icon_alone.png" class="img-responsive style-photo check" alt="ひとり旅">
          <?php } ?>
          <p id="country-name">ひとり旅</p>
        </div>
      </div>

      <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
        <div class="portfolio-item">
          <?php if(in_array("couple", (array)$style)) { ?>
              <img src="img/style/icon_couple.png" class="img-responsive style-photo selected" alt="カップル">
          <?php }else{ ?>
              <img src="img/style/icon_couple.png" class="img-responsive style-photo check" alt="カップル">
          <?php } ?>
          <p id="country-name">カップル・夫婦</p>
        </div>
      </div>

      <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
        <div class="portfolio-item">
          <?php if(in_array("family", (array)$style)) { ?>
              <img src="img/style/icon_family.png" class="img-responsive style-photo selected" alt="家族旅行">
          <?php }else{ ?>
                <img src="img/style/icon_family.png" class="img-responsive style-photo check" alt="家族旅行">
          <?php } ?>
          <p id="country-name">家族旅行</p>
        </div>
      </div>

      <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
        <div class="portfolio-item">
          <?php if(in_array("food", (array)$style)) { ?>
              <img src="img/style/icon_food.png" class="img-responsive style-photo selected" alt="グルメ">
          <?php }else{ ?>
              <img src="img/style/icon_food.png" class="img-responsive style-photo check" alt="グルメ">
          <?php } ?>
          <p id="country-name">グルメ</p>
        </div>
      </div>

      <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
        <div class="portfolio-item">
          <?php if(in_array("resort", (array)$style)) { ?>
              <img src="img/style/icon_resort.png" class="img-responsive style-photo selected" alt="リゾート">
          <?php }else{ ?>
              <img src="img/style/icon_resort.png" class="img-responsive style-photo check" alt="リゾート">
          <?php } ?>
          <p id="country-name">リゾート</p>
        </div>
      </div>

      <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
        <div class="portfolio-item">
          <?php if(in_array("nature", (array)$style)) { ?>
              <img src="img/style/icon_nature.png" class="img-responsive style-photo selected" alt="自然">
          <?php }else{ ?>
              <img src="img/style/icon_nature.png" class="img-responsive style-photo check" alt="自然">
          <?php } ?>
          <p id="country-name">自然</p>
        </div>
      </div>

      <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
        <div class="portfolio-item">
          <?php if(in_array("ruins", (array)$style)) { ?>
              <img src="img/style/icon_ruins.png" class="img-responsive style-photo selected" alt="遺跡">
          <?php }else{ ?>
              <img src="img/style/icon_ruins.png" class="img-responsive style-photo check" alt="遺跡">
          <?php } ?>
          <p id="country-name">遺跡</p>
        </div>
      </div>

      <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
        <div class="portfolio-item">
          <?php if(in_array("shopping", (array)$style)) { ?>
              <img src="img/style/icon_shopping.png" class="img-responsive style-photo selected" alt="ショッピング">
          <?php }else{ ?>
              <img src="img/style/icon_shopping.png" class="img-responsive style-photo check" alt="ショッピング">
          <?php } ?>
          <p id="country-name">ショッピング</p>
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
              <?php if(in_array("Ireland", (array)$country)) { ?>
                  <img src="img/country/ireland.jpg" class="img-responsive country-photo selected" alt="アイルランド">
              <?php }else{ ?>
                  <img src="img/country/ireland.jpg" class="img-responsive country-photo check" alt="アイルランド">
              <?php } ?>
            </div>
            <p id="country-name">アイルランド</p>
          </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 north_america">
          <div class="portfolio-item">
            <div class="hover-bg">
              <?php if(in_array("UnitedStates", (array)$country)) { ?>
                  <img src="img/country/usa.jpg" class="img-responsive country-photo selected" alt="アメリカ">
              <?php }else{ ?>
                  <img src="img/country/usa.jpg" class="img-responsive country-photo check" alt="アメリカ">
              <?php } ?>
            </div>
            <p id="country-name">アメリカ</p>
          </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <?php if(in_array("UnitedArabEmirates", (array)$country)) { ?>
                  <img src="img/country/uae.jpg" class="img-responsive country-photo selected" alt="アラブ首長国連邦">
              <?php }else{ ?>
                  <img src="img/country/uae.jpg" class="img-responsive country-photo check" alt="アラブ首長国連邦">
              <?php } ?>
            </div>
            <p id="country-name">アラブ首長国連邦</p>
          </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 europe">
          <div class="portfolio-item">
            <div class="hover-bg">
              <?php if(in_array("UnitedKingdom", (array)$country)) { ?>
                  <img src="img/country/uk.jpg" class="img-responsive country-photo selected" alt="イギリス">
              <?php }else{ ?>
                  <img src="img/country/uk.jpg" class="img-responsive country-photo check" alt="イギリス">
              <?php } ?>
            </div>
            <p id="country-name">イギリス</p>
          </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 europe">
          <div class="portfolio-item">
            <div class="hover-bg">
              <?php if(in_array("Italy", (array)$country)) { ?>
                  <img src="img/country/italy.jpg" class="img-responsive country-photo selected" alt="イタリア">
              <?php }else{ ?>
                  <img src="img/country/italy.jpg" class="img-responsive country-photo check" alt="イタリア">
              <?php } ?>
            </div>
            <p id="country-name">イタリア</p>
          </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <?php if(in_array("India", (array)$country)) { ?>
                  <img src="img/country/india.jpg" class="img-responsive country-photo selected" alt="インド">
              <?php }else{ ?>
                  <img src="img/country/india.jpg" class="img-responsive country-photo check" alt="インド">
              <?php } ?>
            </div>
            <p id="country-name">インド</p>
          </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <?php if(in_array("Indonesia", (array)$country)) { ?>
                  <img src="img/country/indonesia.jpg" class="img-responsive country-photo selected" alt="インドネシア">
              <?php }else{ ?>
                  <img src="img/country/indonesia.jpg" class="img-responsive country-photo check" alt="インドネシア">
              <?php } ?>
            </div>
            <p id="country-name">インドネシア</p>
          </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 oceania">
          <div class="portfolio-item">
            <div class="hover-bg">
              <?php if(in_array("Australia", (array)$country)) { ?>
                  <img src="img/country/australia.jpg" class="img-responsive country-photo selected" alt="オーストラリア">
              <?php }else{ ?>
                  <img src="img/country/australia.jpg" class="img-responsive country-photo check" alt="オーストラリア">
              <?php } ?>
            </div>
            <p id="country-name">オーストラリア</p>
          </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 europe">
          <div class="portfolio-item">
            <div class="hover-bg">
              <?php if(in_array("Netherlands", (array)$country)) { ?>
                  <img src="img/country/netherland.jpg" class="img-responsive country-photo selected" alt="オランダ">
              <?php }else{ ?>
                  <img src="img/country/netherland.jpg" class="img-responsive country-photo check" alt="オランダ">
              <?php } ?>
            </div>
            <p id="country-name">オランダ</p>
          </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <?php if(in_array("Qatar", (array)$country)) { ?>
                  <img src="img/country/qatar.jpg" class="img-responsive country-photo selected" alt="カタール">
              <?php }else{ ?>
                  <img src="img/country/qatar.jpg" class="img-responsive country-photo check" alt="カタール">
              <?php } ?>
            </div>
            <p id="country-name">カタール</p>
          </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 north_america">
          <div class="portfolio-item">
            <div class="hover-bg">
              <?php if(in_array("Canada", (array)$country)) { ?>
                  <img src="img/country/canada.jpg" class="img-responsive country-photo selected" alt="カナダ">
              <?php }else{ ?>
                  <img src="img/country/canada.jpg" class="img-responsive country-photo check" alt="カナダ">
              <?php } ?>
            </div>
            <p id="country-name">カナダ</p>
          </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <?php if(in_array("Korea", (array)$country)) { ?>
                  <img src="img/country/korea.jpg" class="img-responsive country-photo selected" alt="韓国">
              <?php }else{ ?>
                  <img src="img/country/korea.jpg" class="img-responsive country-photo check" alt="韓国">
              <?php } ?>
            </div>
            <p id="country-name">韓国</p>
          </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <?php if(in_array("Cambodia", (array)$country)) { ?>
                  <img src="img/country/cambodia.jpg" class="img-responsive country-photo selected" alt="カンボジア">
              <?php }else{ ?>
                  <img src="img/country/cambodia.jpg" class="img-responsive country-photo check" alt="カンボジア">
              <?php } ?>
            </div>
            <p id="country-name">カンボジア</p>
          </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 oceania">
          <div class="portfolio-item">
            <div class="hover-bg">
              <?php if(in_array("Guam", (array)$country)) { ?>
                  <img src="img/country/guam.jpg" class="img-responsive country-photo selected" alt="グアム">
              <?php }else{ ?>
                  <img src="img/country/guam.jpg" class="img-responsive country-photo check" alt="グアム">
              <?php } ?>
            </div>
            <p id="country-name">グアム</p>
          </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 oceania">
          <div class="portfolio-item">
            <div class="hover-bg">
              <?php if(in_array("Saipan", (array)$country)) { ?>
                  <img src="img/country/saipan.jpg" class="img-responsive country-photo selected" alt="サイパン">
              <?php }else{ ?>
                  <img src="img/country/saipan.jpg" class="img-responsive country-photo check" alt="サイパン">
              <?php } ?>
            </div>
            <p id="country-name">サイパン</p>
          </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <?php if(in_array("Singapore", (array)$country)) { ?>
                  <img src="img/country/singapore.jpg" class="img-responsive country-photo selected" alt="シンガポール">
              <?php }else{ ?>
                  <img src="img/country/singapore.jpg" class="img-responsive country-photo check" alt="シンガポール">
              <?php } ?>
            </div>
            <p id="country-name">シンガポール</p>
          </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 europe">
          <div class="portfolio-item">
            <div class="hover-bg">
              <?php if(in_array("Spain", (array)$country)) { ?>
                  <img src="img/country/spain.jpg" class="img-responsive country-photo selected" alt="スペイン">
              <?php }else{ ?>
                  <img src="img/country/spain.jpg" class="img-responsive country-photo check" alt="スペイン">
              <?php } ?>
            </div>
            <p id="country-name">スペイン</p>
          </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <?php if(in_array("Thailand", (array)$country)) { ?>
                  <img src="img/country/thailand.jpg" class="img-responsive country-photo selected" alt="タイ">
              <?php }else{ ?>
                  <img src="img/country/thailand.jpg" class="img-responsive country-photo check" alt="タイ">
              <?php } ?>
            </div>
            <p id="country-name">タイ</p>
          </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <?php if(in_array("Taiwan", (array)$country)) { ?>
                  <img src="img/country/taiwan.jpg" class="img-responsive country-photo selected" alt="台湾">
              <?php }else{ ?>
                  <img src="img/country/taiwan.jpg" class="img-responsive country-photo check" alt="台湾">
              <?php } ?>
            </div>
            <p id="country-name">台湾</p>
          </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <?php if(in_array("China", (array)$country)) { ?>
                  <img src="img/country/china.jpg" class="img-responsive country-photo selected" alt="中国">
              <?php }else{ ?>
                  <img src="img/country/china.jpg" class="img-responsive country-photo check" alt="中国">
              <?php } ?>
            </div>
            <p id="country-name">中国</p>
          </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <?php if(in_array("Turkey", (array)$country)) { ?>
                  <img src="img/country/turkey.jpg" class="img-responsive country-photo selected" alt="トルコ">
              <?php }else{ ?>
                  <img src="img/country/turkey.jpg" class="img-responsive country-photo check" alt="トルコ">
              <?php } ?>
            </div>
            <p id="country-name">トルコ</p>
          </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 oceania">
          <div class="portfolio-item">
            <div class="hover-bg">
              <?php if(in_array("NewCaledonia", (array)$country)) { ?>
                  <img src="img/country/newcaledonia.jpg" class="img-responsive country-photo selected" alt="ニューカレドニア">
              <?php }else{ ?>
                  <img src="img/country/newcaledonia.jpg" class="img-responsive country-photo check" alt="ニューカレドニア">
              <?php } ?>
            </div>
            <p id="country-name">ニューカレドニア</p>
          </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 oceania">
          <div class="portfolio-item">
            <div class="hover-bg">
              <?php if(in_array("NewZealand", (array)$country)) { ?>
                  <img src="img/country/newzealand.jpg" class="img-responsive country-photo selected" alt="ニュージーランド">
              <?php }else{ ?>
                  <img src="img/country/newzealand.jpg" class="img-responsive country-photo check" alt="ニュージーランド">
              <?php } ?>
            </div>
            <p id="country-name">ニュージーランド</p>
          </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 oceania">
          <div class="portfolio-item">
            <div class="hover-bg">
              <?php if(in_array("Hawaii", (array)$country)) { ?>
                  <img src="img/country/hawaii.jpg" class="img-responsive country-photo selected" alt="ハワイ">
              <?php }else{ ?>
                  <img src="img/country/hawaii.jpg" class="img-responsive country-photo check" alt="ハワイ">
              <?php } ?>
            </div>
            <p id="country-name">ハワイ</p>
          </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <?php if(in_array("Philippines", (array)$country)) { ?>
                  <img src="img/country/elnido.jpg" class="img-responsive country-photo selected" alt="フィリピン">
              <?php }else{ ?>
                  <img src="img/country/elnido.jpg" class="img-responsive country-photo check" alt="フィリピン">
              <?php } ?>
            </div>
            <p id="country-name">フィリピン</p>
          </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 europe">
          <div class="portfolio-item">
            <div class="hover-bg">
              <?php if(in_array("Finland", (array)$country)) { ?>
                  <img src="img/country/finland.jpg" class="img-responsive country-photo selected" alt="フィンランド">
              <?php }else{ ?>
                  <img src="img/country/finland.jpg" class="img-responsive country-photo check" alt="フィンランド">
              <?php } ?>
            </div>
            <p id="country-name">フィンランド</p>
          </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 europe">
          <div class="portfolio-item">
            <div class="hover-bg">
              <?php if(in_array("France", (array)$country)) { ?>
                  <img src="img/country/france.jpg" class="img-responsive country-photo selected" alt="フランス">
              <?php }else{ ?>
                  <img src="img/country/france.jpg" class="img-responsive country-photo check" alt="フランス">
              <?php } ?>
            </div>
            <p id="country-name">フランス</p>
          </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <?php if(in_array("VietNam", (array)$country)) { ?>
                  <img src="img/country/vietnam.jpg" class="img-responsive country-photo selected" alt="ベトナム">
              <?php }else{ ?>
                  <img src="img/country/vietnam.jpg" class="img-responsive country-photo check" alt="ベトナム">
              <?php } ?>
            </div>
            <p id="country-name">ベトナム</p>
          </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <?php if(in_array("HongKong", (array)$country)) { ?>
                  <img src="img/country/hongkong.jpg" class="img-responsive country-photo selected" alt="香港">
              <?php }else{ ?>
                  <img src="img/country/hongkong.jpg" class="img-responsive country-photo check" alt="香港">
              <?php } ?>
            </div>
            <p id="country-name">香港・マカオ</p>
          </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <?php if(in_array("Malaysia", (array)$country)) { ?>
                  <img src="img/country/malaysia.jpg" class="img-responsive country-photo selected" alt="マレーシア">
              <?php }else{ ?>
                  <img src="img/country/malaysia.jpg" class="img-responsive country-photo check" alt="マレーシア">
              <?php } ?>
            </div>
            <p id="country-name">マレーシア</p>
          </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 north_america">
          <div class="portfolio-item">
            <div class="hover-bg">
              <?php if(in_array("Mexico", (array)$country)) { ?>
                  <img src="img/country/mexico.jpg" class="img-responsive country-photo selected" alt="メキシコ">
              <?php }else{ ?>
                  <img src="img/country/mexico.jpg" class="img-responsive country-photo check" alt="メキシコ">
              <?php } ?>
            </div>
            <p id="country-name">メキシコ</p>
          </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 europe">
          <div class="portfolio-item">
            <div class="hover-bg">
              <?php if(in_array("Russia", (array)$country)) { ?>
                  <img src="img/country/russia.jpg" class="img-responsive country-photo selected" alt="ロシア">
              <?php }else{ ?>
                  <img src="img/country/russia.jpg" class="img-responsive country-photo check" alt="ロシア">
              <?php } ?>
            </div>
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
<div id="button">
  <div class="container">
      <div class="text-center">
        <a href="signup.php?action=rewrite" class="btn btn-default">&laquo;&nbsp;書き直す</a>
        <input form="form_check" type="submit" class="btn btn-default" value="会員登録&nbsp;&raquo;">
      </div>
  </div>
</div>
</form>


<!-- フッターの外部読み込み-->
<?php include('footer.php'); ?>

<!-- フローティングボタンの外部読み込み-->
<?php include('to-top.php'); ?>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script type="text/javascript" src="js/jquery.1.11.1.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script type="text/javascript" src="js/bootstrap.js"></script>
<script type="text/javascript" src="js/SmoothScroll.js"></script>
<script type="text/javascript" src="js/jquery.prettyPhoto.js"></script>
<script type="text/javascript" src="js/jquery.isotope.js"></script>
<script type="text/javascript" src="js/jquery.parallax.js"></script>
<script type="text/javascript" src="js/jqBootstrapValidation.js"></script>
<!-- <script type="text/javascript" src="js/contact_me.js"></script>  -->

<!-- Javascripts
    ================================================== -->
<script type="text/javascript" src="js/main.js"></script>
</body>
</html>