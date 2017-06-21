<?php

session_start();

require('dbconnect.php');

// var_dump($_SESSION['login_user_id']);
// var_dump($_POST['style']);
// var_dump($_POST['country']);

//ログインしているユーザー情報の取得
$sql = sprintf('SELECT * FROM `users` WHERE `user_id` = %d',
       mysqli_real_escape_string($db,$_SESSION['login_user_id']));

$record = mysqli_query($db,$sql) or die(mysqli_error($db));
$user = mysqli_fetch_assoc($record);

// var_dump($user);

//編集内容のアップデートスタート
if(isset($_POST) && !empty($_POST)) {
  //エラーの確認
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

  //スタイル情報と国情報のアップデート
    //スタイルか国のどちらかが選ばれている場合
    if((isset($_POST['style']) && !empty($_POST['style'])) OR (isset($_POST['country']) && !empty($_POST['country']))){
    //チェックを外す行為をDBに反映させるために、user_idの一致を元に、user_stylesテーブルとuser_countriesテーブルの登録情報をDELETEする
      //user_idの一致を元に、user_stylesテーブルから、全ての登録スタイル情報をDELETEする
      $sql = sprintf('DELETE FROM `user_styles` WHERE `user_id`= %d',
      mysqli_real_escape_string($db,$_SESSION['login_user_id']));
      mysqli_query($db,$sql) or die(mysqli_error($db));

      //user_idの一致を元に、user_countriesテーブルから、全ての登録国情報をDELETEする
      $sql = sprintf('DELETE FROM `user_countries` WHERE `user_id`= %d',
      mysqli_real_escape_string($db,$_SESSION['login_user_id']));
      mysqli_query($db,$sql) or die(mysqli_error($db));

    //スタイルの処理がスタート
      //今回選んだスタイル情報+DBから選んだ内容をまとめてINSERTする
        //選んだスタイルから、style_idを取得する
        $select_style_names = $_POST['style'];
        $select_style_id_array = array();
        foreach($select_style_names as $select_style_name){
          $sql = sprintf('SELECT `style_id` FROM `styles` WHERE `style_name` = "%s"',
          mysqli_real_escape_string($db,$select_style_name)
          );
          $select_style_ids = mysqli_query($db,$sql) or die(mysqli_error($db));
          $select_style_id = mysqli_fetch_assoc($select_style_ids);
          $select_style_id_array[] = $select_style_id['style_id'];
        }
        // var_dump($select_style_id_array);

        //style_idとuser_idをuser_stylesテーブルにINSERTする
        foreach($select_style_id_array as $select_style_id_value){
          $sql = sprintf('INSERT INTO `user_styles`(`user_id`, `style_id`) VALUES ("%s", "%s")',
          mysqli_real_escape_string($db,$_SESSION['login_user_id']),
          mysqli_real_escape_string($db,$select_style_id_value)
          );
          mysqli_query($db,$sql) or die(mysqli_error($db));
        }
        //style_idを元にcountry_idを取得する
        $select_country_id_array = array();
        foreach($select_style_id_array as $select_style_id_value){
          $sql = sprintf('SELECT `country_id` FROM `country_styles` WHERE `style_id` = "%s"',
          mysqli_real_escape_string($db,$select_style_id_value)
          );
          $select_country_ids = mysqli_query($db,$sql) or die(mysqli_error($db));

          //ここで1つのスタイルに含まれるすべてのcountry_idを取得し、country_idとuser_idをuser_countriesテーブルにINSERTできるように繰り返し
          while(true){
          $select_country_id = mysqli_fetch_assoc($select_country_ids);
            if($select_country_id == false){
              break;
            }
          $sql = sprintf('INSERT INTO `user_countries` (`user_id`, `country_id`, `style_flag`) VALUES ("%s", "%s", 1)',
          mysqli_real_escape_string($db,$_SESSION['login_user_id']),
          mysqli_real_escape_string($db,$select_country_id['country_id'])
          );
          mysqli_query($db, $sql) or die(mysqli_error($db));
          }
          // $select_country_id_array[] = $select_country_id['country_id']; foreachで1つずつINSERTしているのでこの処理は不要
        }
        // var_dump($select_country_id_array);

  //国情報のアップデート
    //選んだ国から、country_idを取得する
    //大きくforeachを使って、country_idの取得からユーザー国テーブルへのINSERTまでを繰り返す処理の書き方をする
    $select_country_names = $_POST['country'];
    // $select_country_id_array = array();
    foreach($select_country_names as $select_country_name){ //foreach開始
      $sql = sprintf('SELECT `country_id` FROM `countries` WHERE `country_name` = "%s"',
      mysqli_real_escape_string($db,$select_country_name)
      );
      $select_country_ids = mysqli_query($db,$sql) or die(mysqli_error($db));
      $select_country_id = mysqli_fetch_assoc($select_country_ids);
      // $select_country_id_array[] = $select_country_id['country_id'];

      $sql = sprintf('INSERT INTO `user_countries` (`user_id`, `country_id`, `style_flag`) VALUES ("%s", "%s", 0)',
          mysqli_real_escape_string($db,$_SESSION['login_user_id']),
          mysqli_real_escape_string($db,$select_country_id['country_id'])
          );
        if($select_country_id['country_id'] == false){
          break;
        }
        mysqli_query($db, $sql) or die(mysqli_error($db));
    } //foreach終了

  //最後にユーザー国テーブルの重複を削除
  $sql = sprintf('DELETE FROM `user_countries` WHERE `user_country_id` NOT IN (SELECT Max_id FROM (SELECT MAX(`user_country_id`) Max_id FROM `user_countries` GROUP BY `user_id`, `country_id`) tmp)');

  mysqli_query($db, $sql) or die(mysqli_error($db));
  }//スタイル情報と国情報のアップデート終了

  //追加の質問、チェックボックス（旅の目的）のアップデート
  if (isset($_POST['travel_purpose']) && is_array($_POST['travel_purpose'])) {
    $travel_purpose = implode("、", $_POST["travel_purpose"]);

    $sql = sprintf('UPDATE `users` SET `travel_purpose` ="%s" WHERE `user_id`= %d',
    mysqli_real_escape_string($db,$travel_purpose),
    mysqli_real_escape_string($db,$_SESSION['login_user_id']));

    mysqli_query($db,$sql) or die(mysqli_error($db));
  }

  //追加の質問のアップデート
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

}//編集内容のアップデート終了


//ここからはDBに登録してある内容をedit上に選択済みの項目として表示させるための処理
  //選択済みのスタイルがどれなのかデータベースから取得して、チェック用の変数$style_checkを作る処理
  $style_check = array();
  //user_idの一致を元に、user_stylesテーブルから、style_idを取得する
  $style_id_array = array();
  $sql = sprintf('SELECT `style_id` FROM `user_styles` WHERE `user_id` = "%s"',
  mysqli_real_escape_string($db,$_SESSION['login_user_id'])
  );

    //SQLを実行
    $style_ids = mysqli_query($db,$sql) or die(mysqli_error($db));

    while(true){
    $style_id = mysqli_fetch_assoc($style_ids);
      if($style_id['style_id'] == false){
        break;
      }
    $style_id_array[] = $style_id['style_id'];
    }
  // var_dump($style_id_array);

  //取得したstyle_idを元に、stylesテーブルから、style_nameを取得する
  $style_name_array = array();
  foreach ($style_id_array as $style_id_value) {
  $sql = sprintf('SELECT `style_name` FROM `styles` WHERE `style_id` = "%s"',
  mysqli_real_escape_string($db,$style_id_value)
  );

    //SQLを実行
    $style_names = mysqli_query($db,$sql) or die(mysqli_error($db));

    while(true){
    $style_name = mysqli_fetch_assoc($style_names);
      if($style_name['style_name'] == false){
        break;
      }
    $style_name_array[] = $style_name['style_name'];
    }
  }
  // var_dump($style_name_array);
  $style_check = $style_name_array;


  //選択済みの国がどれなのかデータベースから取得して、チェック用の配列$country_checkを作る処理
  $country_check = array();
  //user_idの一致を元に、user_countriesテーブルから、country_idを取得する
  $country_id_array = array();
  $sql = sprintf('SELECT `country_id` FROM `user_countries` WHERE `user_id` = "%s" AND `style_flag` = 0',
  mysqli_real_escape_string($db,$_SESSION['login_user_id'])
  );

    //SQLを実行
    $country_ids = mysqli_query($db,$sql) or die(mysqli_error($db));

    while(true){
    $country_id = mysqli_fetch_assoc($country_ids);
      if($country_id['country_id'] == false){
        break;
      }
    $country_id_array[] = $country_id['country_id'];
    }
  // var_dump($country_id_array);

  //取得したcountry_idを元に、countriesテーブルから、country_nameを取得する
  $country_name_array = array();
  foreach ($country_id_array as $country_id_value) {
  $sql = sprintf('SELECT `country_name` FROM `countries` WHERE `country_id` = "%s"',
  mysqli_real_escape_string($db,$country_id_value)
  );

    //SQLを実行
    $country_names = mysqli_query($db,$sql) or die(mysqli_error($db));

    while(true){
    $country_name = mysqli_fetch_assoc($country_names);
      if($country_name['country_name'] == false){
        break;
      }
    $country_name_array[] = $country_name['country_name'];
    }
  }
  // var_dump($country_name_array);
  $country_check = $country_name_array;

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
<link rel="stylesheet" type="text/css"  href="css/thanks.css">
<link rel="stylesheet" type="text/css"  href="css/signup.css">
<link rel="stylesheet" type="text/css"  href="css/edit.css">
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
        <li> <a class="page-scroll" href="#style">Style</a> </li>
        <li> <a class="page-scroll" href="#country">Country</a> </li>
        <li> <a class="page-scroll" href="#add-question">Question</a> </li>
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
              <!-- <form method="post" action=""> -->
                <div class="form-group">
                  <div class="input-group" data-validate="email">
                    <input type="text" class="form-control" name="nick_name" id="validate-email" value="<?php echo $user['nick_name'] ?>" required>
                    <span class="input-group-addon danger"></span>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group" data-validate="email">
                    <input type="text" class="form-control" name="email" id="validate-email" value="<?php echo $user['email'] ?>" required>
                    <span class="input-group-addon danger"></span>
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
                    <input type="password" class="form-control" name="password" id="validate-email" value="" placeholder="パスワードを変更する場合はここに入力" >
                    <span class="input-group-addon danger"></span>
                  </div>

                  <!-- 字数エラーの処理(ok) -->
                  <?php if(isset($error['password']) && $error['password']=='length'){ ?>
                    <p class="error">* passwordは6文字以上で入力してください</p>
                  <?php } ?>


                </div>
                <div class="form-group">
                  <div class="input-group" data-validate="email">
                    <input type="password" class="form-control" name="re_password" id="validate-email" value="" placeholder="パスワードを変更する場合はここに入力" >
                    <span class="input-group-addon danger"></span>
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
              <label>
                <?php if(in_array("alone", $style_check)) { ?>
                <input type="checkbox" name="style[]" value="alone" checked='checked'>
                <img src="img/style/icon_alone.png" class="img-responsive style-photo selected" alt="ひとり旅">
                <?php }else{ ?>
                <input type="checkbox" name="style[]" value="alone" >
                <img src="img/style/icon_alone.png" class="img-responsive style-photo check" alt="ひとり旅">
                <?php } ?>
              </label>
              <p id="country-name">ひとり旅</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
          <div class="portfolio-item">
              <label>
                <?php if(in_array("couple", $style_check)) { ?>
                <input type="checkbox" name="style[]" value="couple" checked='checked'>
                <img src="img/style/icon_couple.png" class="img-responsive style-photo selected" alt="カップル">
                <?php }else{ ?>
                <input type="checkbox" name="style[]" value="couple">
                <img src="img/style/icon_couple.png" class="img-responsive style-photo check" alt="カップル">
                <?php } ?>
              </label>
              <p id="country-name">カップル・夫婦</p>
          </div>
        </div>
       <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
          <div class="portfolio-item">
              <label>
                <?php if(in_array("family", $style_check)) { ?>
                <input type="checkbox" name="style[]" value="family" checked='checked'>
                <img src="img/style/icon_family.png" class="img-responsive style-photo selected" alt="家族旅行">
                <?php }else{ ?>
                <input type="checkbox" name="style[]" value="family">
                <img src="img/style/icon_family.png" class="img-responsive style-photo check" alt="家族旅行">
                <?php } ?>
              </label>
              <p id="country-name">家族旅行</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
          <div class="portfolio-item">
              <label>
                <?php if(in_array("food", $style_check)) { ?>
                <input type="checkbox" name="style[]" value="food" checked='checked'>
                <img src="img/style/icon_food.png" class="img-responsive style-photo selected" alt="グルメ">
                <?php }else{ ?>
                <input type="checkbox" name="style[]" value="food">
                <img src="img/style/icon_food.png" class="img-responsive style-photo check" alt="グルメ">
                <?php } ?>
              </label>
              <p id="country-name">グルメ</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
          <div class="portfolio-item">
              <label>
                <?php if(in_array("resort", $style_check)) { ?>
                <input type="checkbox" name="style[]" value="resort" checked='checked'>
                <img src="img/style/icon_resort.png" class="img-responsive style-photo selected" alt="リゾート">
                <?php }else{ ?>
                <input type="checkbox" name="style[]" value="resort">
                <img src="img/style/icon_resort.png" class="img-responsive style-photo check" alt="リゾート">
                <?php } ?>
              </label>
              <p id="country-name">リゾート</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
          <div class="portfolio-item">
              <label>
                <?php if(in_array("nature", $style_check)) { ?>
                <input type="checkbox" name="style[]" value="nature" checked='checked'>
                <img src="img/style/icon_nature.png" class="img-responsive style-photo selected" alt="自然">
                <?php }else{ ?>
                <input type="checkbox" name="style[]" value="nature">
                <img src="img/style/icon_nature.png" class="img-responsive style-photo check" alt="自然">
                <?php } ?>
              </label>
              <p id="country-name">自然</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
          <div class="portfolio-item">
              <label>
                <?php if(in_array("ruins", $style_check)) { ?>
                <input type="checkbox" name="style[]" value="ruins" checked='checked'>
                <img src="img/style/icon_ruins.png" class="img-responsive style-photo selected" alt="遺跡">
                <?php }else{ ?>
                <input type="checkbox" name="style[]" value="ruins">
                <img src="img/style/icon_ruins.png" class="img-responsive style-photo check" alt="遺跡">
                <?php } ?>
              </label>
              <p id="country-name">遺跡</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
          <div class="portfolio-item">
              <label>
                <?php if(in_array("shopping", $style_check)) { ?>
                <input type="checkbox" name="style[]" value="shopping" checked='checked'>
                <img src="img/style/icon_shopping.png" class="img-responsive style-photo selected" alt="ショッピング">
                <?php }else{ ?>
                <input type="checkbox" name="style[]" value="shopping">
                <img src="img/style/icon_shopping.png" class="img-responsive style-photo check" alt="ショッピング">
                <?php } ?>
              </label>
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
              <label>
                <?php if(in_array("Ireland", $country_check)) { ?>
                  <input type="checkbox" name="country[]" value="Ireland" checked='checked'>
                  <img src="img/country/ireland.jpg" class="img-responsive country-photo selected" alt="アイルランド">
                <?php }else{ ?>
                  <input type="checkbox" name="country[]" value="Ireland">
                  <img src="img/country/ireland.jpg" class="img-responsive country-photo check" alt="アイルランド">
                <?php } ?>
              </label>
            </div>
              <p id="country-name">アイルランド</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 north_america">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <?php if(in_array("UnitedStates", $country_check)) { ?>
                  <input type="checkbox" name="country[]" value="UnitedStates" checked='checked'>
                  <img src="img/country/usa.jpg" class="img-responsive country-photo selected" alt="アメリカ">
                <?php }else{ ?>
                  <input type="checkbox" name="country[]" value="UnitedStates">
                  <img src="img/country/usa.jpg" class="img-responsive country-photo check" alt="アメリカ">
                <?php } ?>
              </label>
            </div>
              <p id="country-name">アメリカ</p>
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <?php if(in_array("UnitedArabEmirates", $country_check)) { ?>
                  <input type="checkbox" name="country[]" value="UnitedArabEmirates" checked='checked'>
                  <img src="img/country/uae.jpg" class="img-responsive country-photo selected" alt="アラブ首長国連邦">
                <?php }else{ ?>
                  <input type="checkbox" name="country[]" value="UnitedArabEmirates">
                  <img src="img/country/uae.jpg" class="img-responsive country-photo check" alt="アラブ首長国連邦">
                <?php } ?>
              </label>
            </div>
              <p id="country-name">アラブ首長国連邦</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 europe">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <?php if(in_array("UnitedKingdom", $country_check)) { ?>
                  <input type="checkbox" name="country[]" value="UnitedKingdom" checked='checked'>
                  <img src="img/country/uk.jpg" class="img-responsive country-photo selected" alt="イギリス">
                <?php }else{ ?>
                  <input type="checkbox" name="country[]" value="UnitedKingdom">
                  <img src="img/country/uk.jpg" class="img-responsive country-photo check" alt="イギリス">
                <?php } ?>
              </label>
            </div>
              <p id="country-name">イギリス</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 europe">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <?php if(in_array("Italy", $country_check)) { ?>
                <input type="checkbox" name="country[]" value="Italy" checked='checked'>
                <img src="img/country/italy.jpg" class="img-responsive country-photo selected" alt="イタリア">
                <?php }else{ ?>
                <input type="checkbox" name="country[]" value="Italy">
                <img src="img/country/italy.jpg" class="img-responsive country-photo check" alt="イタリア">
                <?php } ?>
              </label>
            </div>
              <p id="country-name">イタリア</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <?php if(in_array("India", $country_check)) { ?>
                <input type="checkbox" name="country[]" value="India" checked='checked'>
                <img src="img/country/india.jpg" class="img-responsive country-photo selected" alt="インド">
                <?php }else{ ?>
                <input type="checkbox" name="country[]" value="India">
                <img src="img/country/india.jpg" class="img-responsive country-photo check" alt="インド">
                <?php } ?>
              </label>
            </div>
              <p id="country-name">インド</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <?php if(in_array("Indonesia", $country_check)) { ?>
                <input type="checkbox" name="country[]" value="Indonesia" checked='checked'>
                <img src="img/country/indonesia.jpg" class="img-responsive country-photo selected" alt="インドネシア">
                <?php }else{ ?>
                <input type="checkbox" name="country[]" value="Indonesia">
                <img src="img/country/indonesia.jpg" class="img-responsive country-photo check" alt="インドネシア">
                <?php } ?>
              </label>
            </div>
              <p id="country-name">インドネシア</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 oceania">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <?php if(in_array("Australia", $country_check)) { ?>
                <input type="checkbox" name="country[]" value="Australia" checked='checked'>
                <img src="img/country/australia.jpg" class="img-responsive country-photo selected" alt="オーストラリア">
                <?php }else{ ?>
                <input type="checkbox" name="country[]" value="Australia">
                <img src="img/country/australia.jpg" class="img-responsive country-photo check" alt="オーストラリア">
                <?php } ?>
              </label>
            </div>
              <p id="country-name">オーストラリア</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 europe">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <?php if(in_array("Netherlands", $country_check)) { ?>
                <input type="checkbox" name="country[]" value="Netherlands" checked='checked'>
                <img src="img/country/netherland.jpg" class="img-responsive country-photo selected" alt="オランダ">
                <?php }else{ ?>
                <input type="checkbox" name="country[]" value="Netherlands">
                <img src="img/country/netherland.jpg" class="img-responsive country-photo check" alt="オランダ">
                <?php } ?>
              </label>
            </div>
              <p id="country-name">オランダ</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <?php if(in_array("Qatar", $country_check)) { ?>
                <input type="checkbox" name="country[]" value="Qatar" checked='checked'>
                <img src="img/country/qatar.jpg" class="img-responsive country-photo selected" alt="カタール">
                <?php }else{ ?>
                <input type="checkbox" name="country[]" value="Qatar">
                <img src="img/country/qatar.jpg" class="img-responsive country-photo check" alt="カタール">
                <?php } ?>
              </label>
            </div>
              <p id="country-name">カタール</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 north_america">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <?php if(in_array("Canada", $country_check)) { ?>
                <input type="checkbox" name="country[]" value="Canada" checked='checked'>
                <img src="img/country/canada.jpg" class="img-responsive country-photo selected" alt="カナダ">
                <?php }else{ ?>
                <input type="checkbox" name="country[]" value="Canada">
                <img src="img/country/canada.jpg" class="img-responsive country-photo check" alt="カナダ">
                <?php } ?>
              </label>
            </div>
              <p id="country-name">カナダ</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <?php if(in_array("Korea", $country_check)) { ?>
                <input type="checkbox" name="country[]" value="Korea" checked='checked'>
                <img src="img/country/korea.jpg" class="img-responsive country-photo selected" alt="韓国">
                <?php }else{ ?>
                <input type="checkbox" name="country[]" value="Korea">
                <img src="img/country/korea.jpg" class="img-responsive country-photo check" alt="韓国">
                <?php } ?>
              </label>
            </div>
              <p id="country-name">韓国</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <?php if(in_array("Cambodia", $country_check)) { ?>
                <input type="checkbox" name="country[]" value="Cambodia" checked='checked'>
                <img src="img/country/cambodia.jpg" class="img-responsive country-photo selected" alt="カンボジア">
                <?php }else{ ?>
                <input type="checkbox" name="country[]" value="Cambodia">
                <img src="img/country/cambodia.jpg" class="img-responsive country-photo check" alt="カンボジア">
                <?php } ?>
              </label>
            </div>
              <p id="country-name">カンボジア</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 oceania">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <?php if(in_array("Guam", $country_check)) { ?>
                <input type="checkbox" name="country[]" value="Guam" checked='checked'>
                <img src="img/country/guam.jpg" class="img-responsive country-photo selected" alt="グアム">
                <?php }else{ ?>
                <input type="checkbox" name="country[]" value="Guam">
                <img src="img/country/guam.jpg" class="img-responsive country-photo check" alt="グアム">
                <?php } ?>
              </label>
            </div>
              <p id="country-name">グアム</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 oceania">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <?php if(in_array("Saipan", $country_check)) { ?>
                <input type="checkbox" name="country[]" value="Saipan" checked='checked'>
                <img src="img/country/saipan.jpg" class="img-responsive country-photo selected" alt="サイパン">
                <?php }else{ ?>
                <input type="checkbox" name="country[]" value="Saipan">
                <img src="img/country/saipan.jpg" class="img-responsive country-photo check" alt="サイパン">
                <?php } ?>
              </label>
            </div>
              <p id="country-name">サイパン</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <?php if(in_array("Singapore", $country_check)) { ?>
                <input type="checkbox" name="country[]" value="Singapore" checked='checked'>
                <img src="img/country/singapore.jpg" class="img-responsive country-photo selected" alt="シンガポール">
                <?php }else{ ?>
                <input type="checkbox" name="country[]" value="Singapore">
                <img src="img/country/singapore.jpg" class="img-responsive country-photo check" alt="シンガポール">
                <?php } ?>
              </label>
            </div>
              <p id="country-name">シンガポール</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 europe">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <?php if(in_array("Spain", $country_check)) { ?>
                <input type="checkbox" name="country[]" value="Spain" checked='checked'>
                <img src="img/country/spain.jpg" class="img-responsive country-photo selected" alt="スペイン">
                <?php }else{ ?>
                <input type="checkbox" name="country[]" value="Spain">
                <img src="img/country/spain.jpg" class="img-responsive country-photo check" alt="スペイン">
                <?php } ?>
              </label>
            </div>
              <p id="country-name">スペイン</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <?php if(in_array("Thailand", $country_check)) { ?>
                <input type="checkbox" name="country[]" value="Thailand" checked='checked'>
                <img src="img/country/thailand.jpg" class="img-responsive country-photo selected" alt="タイ">
                <?php }else{ ?>
                <input type="checkbox" name="country[]" value="Thailand">
                <img src="img/country/thailand.jpg" class="img-responsive country-photo check" alt="タイ">
                <?php } ?>
              </label>
            </div>
              <p id="country-name">タイ</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <?php if(in_array("Taiwan", $country_check)) { ?>
                <input type="checkbox" name="country[]" value="Taiwan" checked='checked'>
                <img src="img/country/taiwan.jpg" class="img-responsive country-photo selected" alt="台湾">
                <?php }else{ ?>
                <input type="checkbox" name="country[]" value="Taiwan">
                <img src="img/country/taiwan.jpg" class="img-responsive country-photo check" alt="台湾">
                <?php } ?>
              </label>
            </div>
              <p id="country-name">台湾</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <?php if(in_array("China", $country_check)) { ?>
                <input type="checkbox" name="country[]" value="China" checked='checked'>
                <img src="img/country/china.jpg" class="img-responsive country-photo selected" alt="中国">
                <?php }else{ ?>
                <input type="checkbox" name="country[]" value="China">
                <img src="img/country/china.jpg" class="img-responsive country-photo check" alt="中国">
                <?php } ?>
              </label>
            </div>
              <p id="country-name">中国</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <?php if(in_array("Turkey", $country_check)) { ?>
                <input type="checkbox" name="country[]" value="Turkey" checked='checked'>
                <img src="img/country/turkey.jpg" class="img-responsive country-photo selected" alt="トルコ">
                <?php }else{ ?>
                <input type="checkbox" name="country[]" value="Turkey">
                <img src="img/country/turkey.jpg" class="img-responsive country-photo check" alt="トルコ">
                <?php } ?>
              </label>
            </div>
              <p id="country-name">トルコ</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 oceania">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <?php if(in_array("NewCaledonia", $country_check)) { ?>
                <input type="checkbox" name="country[]" value="NewCaledonia" checked='checked'>
                <img src="img/country/newcaledonia.jpg" class="img-responsive country-photo selected" alt="ニューカレドニア">
                <?php }else{ ?>
                <input type="checkbox" name="country[]" value="NewCaledonia">
                <img src="img/country/newcaledonia.jpg" class="img-responsive country-photo check" alt="ニューカレドニア">
                <?php } ?>
              </label>
            </div>
              <p id="country-name">ニューカレドニア</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 oceania">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <?php if(in_array("NewZealand", $country_check)) { ?>
                <input type="checkbox" name="country[]" value="NewZealand" checked='checked'>
                <img src="img/country/newzealand.jpg" class="img-responsive country-photo selected" alt="ニュージーランド">
                <?php }else{ ?>
                <input type="checkbox" name="country[]" value="NewZealand">
                <img src="img/country/newzealand.jpg" class="img-responsive country-photo check" alt="ニュージーランド">
                <?php } ?>
              </label>
            </div>
              <p id="country-name">ニュージーランド</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 oceania">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <?php if(in_array("Hawaii", $country_check)) { ?>
                <input type="checkbox" name="country[]" value="Hawaii" checked='checked'>
                <img src="img/country/hawaii.jpg" class="img-responsive country-photo selected" alt="ハワイ">
                <?php }else{ ?>
                <input type="checkbox" name="country[]" value="Hawaii">
                <img src="img/country/hawaii.jpg" class="img-responsive country-photo check" alt="ハワイ">
                <?php } ?>
              </label>
            </div>
              <p id="country-name">ハワイ</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <?php if(in_array("Philippines", $country_check)) { ?>
                <input type="checkbox" name="country[]" value="Philippines" checked='checked'>
                <img src="img/country/elnido.jpg" class="img-responsive country-photo selected" alt="フィリピン">
                <?php }else{ ?>
                <input type="checkbox" name="country[]" value="Philippines">
                <img src="img/country/elnido.jpg" class="img-responsive country-photo check" alt="フィリピン">
                <?php } ?>
              </label>
            </div>
              <p id="country-name">フィリピン</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 europe">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <?php if(in_array("Finland", $country_check)) { ?>
                <input type="checkbox" name="country[]" value="Finland" checked='checked'>
                <img src="img/country/finland.jpg" class="img-responsive country-photo selected" alt="フィンランド">
                <?php }else{ ?>
                <input type="checkbox" name="country[]" value="Finland">
                <img src="img/country/finland.jpg" class="img-responsive country-photo check" alt="フィンランド">
                <?php } ?>
              </label>
            </div>
              <p id="country-name">フィンランド</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 europe">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <?php if(in_array("France", $country_check)) { ?>
                <input type="checkbox" name="country[]" value="France" checked='checked'>
                <img src="img/country/france.jpg" class="img-responsive country-photo selected" alt="フランス">
                <?php }else{ ?>
                <input type="checkbox" name="country[]" value="France">
                <img src="img/country/france.jpg" class="img-responsive country-photo check" alt="フランス">
                <?php } ?>
              </label>
            </div>
              <p id="country-name">フランス</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <?php if(in_array("VietNam", $country_check)) { ?>
                <input type="checkbox" name="country[]" value="VietNam" checked='checked'>
                <img src="img/country/vietnam.jpg" class="img-responsive country-photo selected" alt="ベトナム">
                <?php }else{ ?>
                <input type="checkbox" name="country[]" value="VietNam">
                <img src="img/country/vietnam.jpg" class="img-responsive country-photo check" alt="ベトナム">
                <?php } ?>
              </label>
            </div>
              <p id="country-name">ベトナム</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <?php if(in_array("HongKong", $country_check)) { ?>
                <input type="checkbox" name="country[]" value="HongKong" checked='checked'>
                <img src="img/country/hongkong.jpg" class="img-responsive country-photo selected" alt="香港">
                <?php }else{ ?>
                <input type="checkbox" name="country[]" value="HongKong">
                <img src="img/country/hongkong.jpg" class="img-responsive country-photo check" alt="香港">
                <?php } ?>
              </label>
            </div>
              <p id="country-name">香港・マカオ</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <?php if(in_array("Malaysia", $country_check)) { ?>
                <input type="checkbox" name="country[]" value="Malaysia" checked='checked'>
                <img src="img/country/malaysia.jpg" class="img-responsive country-photo selected" alt="マレーシア">
                <?php }else{ ?>
                <input type="checkbox" name="country[]" value="Malaysia">
                <img src="img/country/malaysia.jpg" class="img-responsive country-photo check" alt="マレーシア">
                <?php } ?>
              </label>
            </div>
              <p id="country-name">マレーシア</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 north_america">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <?php if(in_array("Mexico", $country_check)) { ?>
                <input type="checkbox" name="country[]" value="Mexico" checked='checked'>
                <img src="img/country/mexico.jpg" class="img-responsive country-photo selected" alt="メキシコ">
                <?php }else{ ?>
                <input type="checkbox" name="country[]" value="Mexico">
                <img src="img/country/mexico.jpg" class="img-responsive country-photo check" alt="メキシコ">
                <?php } ?>
              </label>
            </div>
              <p id="country-name">メキシコ</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 europe">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <?php if(in_array("Russia", $country_check)) { ?>
                <input type="checkbox" name="country[]" value="Russia" checked='checked'>
                <img src="img/country/russia.jpg" class="img-responsive country-photo selected" alt="ロシア">
                <?php }else{ ?>
                <input type="checkbox" name="country[]" value="Russia">
                <img src="img/country/russia.jpg" class="img-responsive country-photo check" alt="ロシア">
                <?php } ?>
              </label>
            </div>
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
               <div class="form-group padding">
                 <label class="col-md-4 control-label" for="radios">性別</label>
                 <div class="col-md-6">
                 <?php if(!($user['travel_purpose'] == NULL)){ ?>
                   <div class="radio">
                     <label for="radios-0">
                       <?php if(strpos($user['gender'], '男性') !== false) { ?>
                       <input type="radio" name="gender" id="radios-0" value="男性" checked="checked">男性（選択済み）
                       <?php }else{ ?>
                       <input type="radio" name="gender" id="radios-0" value="男性">男性
                       <?php } ?>
                     </label>
                   </div>
                   <div class="radio">
                     <label for="radios-1">
                       <?php if(strpos($user['gender'], '女性') !== false) { ?>
                       <input type="radio" name="gender" id="radios-1" value="女性" checked="checked">女性（選択済み）
                       <?php }else{ ?>
                       <input type="radio" name="gender" id="radios-1" value="女性">女性
                       <?php } ?>
                     </label>
                   </div>
                 <?php }else{ ?>
                   <div class="radio">
                     <label for="radios-0">
                       <input type="radio" name="gender" id="radios-0" value="男性">男性
                     </label>
                   </div>
                   <div class="radio">
                     <label for="radios-1">
                       <input type="radio" name="gender" id="radios-1" value="女性">女性
                     </label>
                   </div>
                 <?php } ?>
                 </div>
               </div>

               <!-- Select Basic -->
               <div class="form-group padding">
                 <label class="col-md-4 control-label" for="selectbasic">年齢</label>
                 <div class="col-md-6">
                   <select id="selectbasic" name="age" class="form-control">
                     <?php if(($user['age'] == NULL)){ ?>
                     <option value="" >年齢を選択してください</option>
                     <?php } ?>
                     <?php if(!($user['age'] == NULL)){ ?>
                     <option value="<?php echo $user['age'] ?>"><?php echo $user['age'] ?>(選択済み)</option>
                     <?php } ?>
                     <option value="">-</option>
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
               <div class="form-group padding">
                 <label class="col-md-4 control-label" for="selectbasic">居住地</label>
                 <div class="col-md-6">
                   <select id="selectbasic" name="address" class="form-control">
                     <?php if(($user['address'] == NULL)){ ?>
                     <option value="">居住地を選択してください</option>
                     <?php } ?>
                     <?php if(!($user['address'] == NULL)){ ?>
                     <option value="<?php echo $user['address'] ?>"><?php echo $user['address'] ?>(選択済み)</option>
                     <?php } ?>
                     <option value="">-</option>
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
               <div class="form-group padding">
                 <label class="col-md-4 control-label" for="selectbasic">年収</label>
                 <div class="col-md-6">
                   <select id="selectbasic" name="income" class="form-control">
                     <?php if(($user['income'] == NULL)){ ?>
                     <option value="">年収を選択してください</option>
                     <?php } ?>
                     <?php if(!($user['income'] == NULL)){ ?>
                     <option value="<?php echo $user['income'] ?>"><?php echo $user['income'] ?>(選択済み)</option>
                     <?php } ?>
                     <option value="">-</option>
                     <option value="300万円未満">300万円未満</option>
                     <option value="300万円〜500万円">300万円〜500万円</option>
                     <option value="500万円〜700万円">500万円〜700万円未満</option>
                     <option value="700万円〜1000万円">700万円〜1000万円</option>
                     <option value="1000万円以上">1000万円以上</option>
                   </select>
                 </div>
               </div>

               <!-- Multiple Checkboxes -->
               <div class="form-group padding">
                 <label class="col-md-4 control-label" for="checkboxes">海外旅行先の決め手</label>
                 <div class="col-md-6">
                   <?php if(!($user['travel_purpose'] == NULL)){ ?> <!-- 過去に旅行の決め手を選んでいる場合の処理-->
                   <div class="checkbox">
                     <label for="checkboxes-0">
                       <?php if(strpos($user['travel_purpose'], '自然') !== false) { ?>
                       <input type="checkbox" name="travel_purpose[]" id="checkboxes-0" value="自然" checked="checked">自然
                       <?php }else{ ?>
                       <input type="checkbox" name="travel_purpose[]" id="checkboxes-0" value="自然">自然
                       <?php } ?>
                     </label>
                   </div>
                   <div class="checkbox">
                     <label for="checkboxes-1">
                       <?php if(strpos($user['travel_purpose'], '歴史的建造物') !== false) { ?>
                       <input type="checkbox" name="travel_purpose[]" id="checkboxes-1" value="歴史的建造物" checked="checked">歴史的建造物
                       <?php }else{ ?>
                       <input type="checkbox" name="travel_purpose[]" id="checkboxes-1" value="歴史的建造物">歴史的建造物
                       <?php } ?>
                     </label>
                   </div>
                   <div class="checkbox">
                     <label for="checkboxes-2">
                       <?php if(strpos($user['travel_purpose'], 'リゾート・ビーチ') !== false) { ?>
                       <input type="checkbox" name="travel_purpose[]" id="checkboxes-0" value="リゾート・ビーチ" checked="checked">リゾート・ビーチ
                       <?php }else{ ?>
                       <input type="checkbox" name="travel_purpose[]" id="checkboxes-0" value="リゾート・ビーチ">リゾート・ビーチ
                       <?php } ?>
                     </label>
                   </div>
                   <div class="checkbox">
                     <label for="checkboxes-2">
                       <?php if(strpos($user['travel_purpose'], 'ショッピング') !== false) { ?>
                       <input type="checkbox" name="travel_purpose[]" id="checkboxes-0" value="ショッピング" checked="checked">ショッピング
                       <?php }else{ ?>
                       <input type="checkbox" name="travel_purpose[]" id="checkboxes-0" value="ショッピング">ショッピング
                       <?php } ?>
                     </label>
                   </div>
                   <div class="checkbox">
                     <label for="checkboxes-2">
                       <?php if(strpos($user['travel_purpose'], 'グルメ') !== false) { ?>
                       <input type="checkbox" name="travel_purpose[]" id="checkboxes-0" value="グルメ" checked="checked">グルメ
                       <?php }else{ ?>
                       <input type="checkbox" name="travel_purpose[]" id="checkboxes-0" value="グルメ">グルメ
                       <?php } ?>
                     </label>
                   </div>
                    <div class="checkbox">
                     <label for="checkboxes-2">
                       <?php if(strpos($user['travel_purpose'], '異文化体験') !== false) { ?>
                       <input type="checkbox" name="travel_purpose[]" id="checkboxes-0" value="異文化体験" checked="checked">異文化体験
                       <?php }else{ ?>
                       <input type="checkbox" name="travel_purpose[]" id="checkboxes-0" value="異文化体験">異文化体験
                       <?php } ?>
                     </label>
                     <div class="checkbox">
                     <label for="checkboxes-2">
                       <?php if(strpos($user['travel_purpose'], 'イベント') !== false) { ?>
                       <input type="checkbox" name="travel_purpose[]" id="checkboxes-0" value="イベント" checked="checked">イベント
                       <?php }else{ ?>
                       <input type="checkbox" name="travel_purpose[]" id="checkboxes-0" value="イベント">イベント
                       <?php } ?>
                     </label>
                   </div>
                   <div class="checkbox">
                     <label for="checkboxes-2">
                       <?php if(strpos($user['travel_purpose'], 'テーマパーク') !== false) { ?>
                       <input type="checkbox" name="travel_purpose[]" id="checkboxes-0" value="テーマパーク" checked="checked">テーマパーク
                       <?php }else{ ?>
                       <input type="checkbox" name="travel_purpose[]" id="checkboxes-0" value="テーマパーク">テーマパーク
                       <?php } ?>
                     </label>
                   </div>
                    <div class="checkbox">
                     <label for="checkboxes-2">
                       <?php if(strpos($user['travel_purpose'], 'スポーツやアクティビティ') !== false) { ?>
                       <input type="checkbox" name="travel_purpose[]" id="checkboxes-0" value="スポーツやアクティビティ" checked="checked">スポーツやアクティビティ
                       <?php }else{ ?>
                       <input type="checkbox" name="travel_purpose[]" id="checkboxes-0" value="スポーツやアクティビティ">スポーツやアクティビティ
                       <?php } ?>
                     </label>
                   </div>
                    <div class="checkbox">
                     <label for="checkboxes-2">
                       <?php if(strpos($user['travel_purpose'], '現地の人との交流') !== false) { ?>
                       <input type="checkbox" name="travel_purpose[]" id="checkboxes-0" value="現地の人との交流" checked="checked">現地の人との交流
                       <?php }else{ ?>
                       <input type="checkbox" name="travel_purpose[]" id="checkboxes-0" value="現地の人との交流">現地の人との交流
                       <?php } ?>
                     </label>
                   </div>
                    <div class="checkbox">
                     <label for="checkboxes-2">
                       <?php if(strpos($user['travel_purpose'], 'エステ・美容') !== false) { ?>
                       <input type="checkbox" name="travel_purpose[]" id="checkboxes-0" value="エステ・美容" checked="checked">エステ・美容
                       <?php }else{ ?>
                       <input type="checkbox" name="travel_purpose[]" id="checkboxes-0" value="エステ・美容">エステ・美容
                       <?php } ?>
                     </label>
                   </div>
                   <?php }else{ ?> <!-- 過去に旅行の決め手を選んでいる場合の処理終了-->
                   <div class="checkbox">
                     <label for="checkboxes-0">
                       <input type="checkbox" name="travel_purpose[]" id="checkboxes-0" value="自然">自然
                     </label>
                   </div>
                   <div class="checkbox">
                     <label for="checkboxes-1">
                       <input type="checkbox" name="travel_purpose[]" id="checkboxes-1" value="歴史的建造物">歴史的建造物
                     </label>
                   </div>
                   <div class="checkbox">
                     <label for="checkboxes-2">
                       <input type="checkbox" name="travel_purpose[]" id="checkboxes-0" value="リゾート・ビーチ">リゾート・ビーチ
                     </label>
                   </div>
                   <div class="checkbox">
                     <label for="checkboxes-2">
                       <input type="checkbox" name="travel_purpose[]" id="checkboxes-0" value="ショッピング">ショッピング
                     </label>
                   </div>
                   <div class="checkbox">
                     <label for="checkboxes-2">
                       <input type="checkbox" name="travel_purpose[]" id="checkboxes-0" value="グルメ">グルメ
                     </label>
                   </div>
                    <div class="checkbox">
                     <label for="checkboxes-2">
                       <input type="checkbox" name="travel_purpose[]" id="checkboxes-0" value="異文化体験">異文化体験
                     </label>
                     <div class="checkbox">
                     <label for="checkboxes-2">
                       <input type="checkbox" name="travel_purpose[]" id="checkboxes-0" value="イベント">イベント
                     </label>
                   </div>
                 <div class="checkbox">
                   <label for="checkboxes-2">
                     <input type="checkbox" name="travel_purpose[]" id="checkboxes-0" value="テーマパーク">テーマパーク
                   </label>
                 </div>
                  <div class="checkbox">
                   <label for="checkboxes-2">
                     <input type="checkbox" name="travel_purpose[]" id="checkboxes-0" value="スポーツやアクティビティ">スポーツやアクティビティ
                   </label>
                 </div>
                  <div class="checkbox">
                   <label for="checkboxes-2">
                     <input type="checkbox" name="travel_purpose[]" id="checkboxes-0" value="現地の人との交流">現地の人との交流
                   </label>
                 </div>
                  <div class="checkbox">
                   <label for="checkboxes-2">
                     <input type="checkbox" name="travel_purpose[]" id="checkboxes-0" value="エステ・美容">エステ・美容
                   </label>
                 </div>
                 <?php } ?>
                 </div>
                 </div>
               </div>

               <!-- Select Basic -->
               <div class="form-group padding">
                 <label class="col-md-4 control-label" for="selectbasic">海外旅行の平均的な予算</label>
                 <div class="col-md-6">
                   <select id="selectbasic" name="travel_budget" class="form-control">
                     <?php if(($user['travel_budget'] == NULL)){ ?>
                     <option value="">海外旅行の予算を選択してください</option>
                     <?php } ?>
                     <?php if(!($user['travel_budget'] == NULL)){ ?>
                     <option value="<?php echo $user['travel_budget'] ?>"><?php echo $user['travel_budget'] ?>(選択済み)</option>
                     <?php } ?>
                     <option value="">-</option>
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
               <div class="form-group padding">
                 <label class="col-md-4 control-label" for="selectbasic">海外旅行の平均的な期間</label>
                 <div class="col-md-6">
                   <select id="selectbasic" name="travel_period" class="form-control">
                     <?php if(($user['travel_period'] == NULL)){ ?>
                     <option value="">海外旅行の期間を選択してください</option>
                     <?php } ?>
                     <?php if(!($user['travel_period'] == NULL)){ ?>
                     <option value="<?php echo $user['travel_period'] ?>"><?php echo $user['travel_period'] ?>(選択済み)</option>
                     <?php } ?>
                     <option value="">-</option>
                     <option value="3日以内">3日以内</option>
                     <option value="3~5日以内">3~5日間</option>
                     <option value="5~7日以内">5日~7日</option>
                     <option value="7~9日以内">7~9日間</option>
                     <option value="9日~">9日~</option>
                   </select>
                 </div>
               </div>

               <!-- Select Basic -->
               <div class="form-group padding">
                 <label class="col-md-4 control-label" for="selectbasic">これまでに訪れた国の数</label>
                 <div class="col-md-6">
                   <select id="selectbasic" name="travel_country" class="form-control">
                     <?php if(($user['travel_country'] == NULL)){ ?>
                     <option value="">これまでに訪れた国の数を選択してください</option>
                     <?php } ?>
                     <?php if(!($user['travel_country'] == NULL)){ ?>
                     <option value="<?php echo $user['travel_country'] ?>"><?php echo $user['travel_country'] ?>(選択済み)</option>
                     <?php } ?>
                     <option value="">-</option>
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
                 <div class="col-md-6">
                   <select id="selectbasic" name="travel_time" class="form-control">
                     <?php if(($user['travel_time'] == NULL)){ ?>
                     <option value="">過去1年間の海外旅行の回数を選択してください</option>
                     <?php } ?>
                     <?php if(!($user['travel_time'] == NULL)){ ?>
                     <option value="<?php echo $user['travel_time'] ?>"><?php echo $user['travel_time'] ?>(選択済み)</option>
                     <?php } ?>
                     <option value="">-</option>
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
               <div class="form-group padding">
                 <label class="col-md-4 control-label" for="selectbasic">Fly Highを知ったキッカケ</label>
                 <div class="col-md-6">
                   <select id="selectbasic" name="know_flyhigh" class="form-control">
                     <?php if(($user['know_flyhigh'] == NULL)){ ?>
                     <option value="">Fly Highを知ったキッカケを選択してください</option>
                     <?php } ?>
                     <?php if(!($user['know_flyhigh'] == NULL)){ ?>
                     <option value="<?php echo $user['know_flyhigh'] ?>"><?php echo $user['know_flyhigh'] ?>(選択済み)</option>
                     <?php } ?>
                     <option value="">-</option>
                     <option value="友人・知人">友人・知人</option>
                     <option value="開発メンバー">開発メンバー</option>
                     <option value="検索サイト">検索サイト</option>
                     <option value="他サイトでの紹介">他サイトでの紹介</option>
                     <option value="その他">その他</option>
                   </select>
                 </div>
               </div>

               <!-- Textarea -->
               <div class="form-group padding">
                 <label class="col-md-4 control-label" for="textarea">サイトへのご要望</label>
                 <div class="col-md-6">
                   <textarea class="form-control" id="textarea" name="demand" placeholder="要望を入力してください"></textarea>
                 </div>
               </div>
               </fieldset>
           </div>
       </div>

       <br><br><br>
      <div class="text-center update">

        <button type="submit" class="btn btn-default">更新する<span class="angle">&nbsp;&raquo;</span></button>

      </div>
      <div class="text-center">
      <a href="index.php"><button type="button" class="btn btn-default"><span class="angle">&laquo;&nbsp;</span>TOPへ</button></a>
      <a href="mypage.php"><button type="button" class="btn btn-default"><span class="angle">&laquo;&nbsp;</span>mypageへ</button></a>
      </div>

      <div class="text-center agree">
      Fly Highを退会する場合は<a href="unsubscribe.php">こちら</a>をクリック
      </div>

  </div>

  </div>
</div>
</form>

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
<!-- <script type="text/javascript" src="js/contact_me.js"></script> -->
<script type="text/javascript" src="js/signup.js"></script>

<!-- Javascripts
    ================================================== -->
<script type="text/javascript" src="js/main.js"></script>
</body>
</html>