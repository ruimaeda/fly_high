<?php
  session_start();

  //DBへ接続
  require('dbconnect.php');

  var_dump($_POST['country']);//送信ボタンを押したら表示される
  var_dump($_POST['style']);//送信ボタンを押したら表示される

  //フォームからデータがPOST送信された時の処理（ok）
  if(!empty($_POST)){

    // //contact_me.jsをコメントアウトしたら表示された！(ok)
    // echo('<pre>');
    // var_dump($_POST);
    // echo('</pre>');


    //入力されたemailから会員情報を取得できたら、「すでに登録されています」を表示する
    $sql = sprintf('SELECT `email` FROM `users` WHERE `email` = "%s"',
    mysqli_real_escape_string($db,$_POST['email'])
    );

    //SQLを実行
    $user_emails = mysqli_query($db,$sql) or die(mysqli_error($db));
    $user_email = mysqli_fetch_assoc($user_emails);


    // データは取れてきている！(ok)
    // echo('<pre>');
    // var_dump($user_email);
    // echo('</pre>');


    $email=htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');

    //エラー項目の確認（ブランクの場合についてはjsで表示済）
    //エラー項目の確認：email（＠マークがない場合をエラーにする）(ok)
    if ($email !== "" && strpos($email, "@") === FALSE){
      $error['email'] = "wrong";
    }

    //エラー項目の確認：:email（すでに登録されています処理=DBを使う）(ok)
    if ($_POST['email'] == $user_email['email']) {
      $error['email']='already';
    }


    //エラー項目の確認：pass(文字長６文字以上)(ok)
    if (strlen($_POST['password'])<6) {
      $error['password']='length';
    }
    //エラー項目の確認：確認用pass(ok)
    if ($_POST['re_password'] !== $_POST['password']) {
      $error['re_password']='not_same';
    }


    // //エラー項目の確認:style＆国（スタイルか国の何か１つが選ばれていること）？？
    // //POST送信
    // if($_POST['style']=='' && $_POST['country']){
    //   $error['country']='blank';
    // }





    // エラーがない場合セッションに値を保存(ok)
    if(empty($error)){
      $_SESSION['signup'] = $_POST;

      // //ここも表示された！
      // echo('<pre>');
      // var_dump($_POST);
      // echo('</pre>');


      //checkに遷移(ok)
      header('Location: check.php');

    }
  }

  //書き直しで戻ってきた時の表示処理
  if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'rewrite'){
    $_POST = $_SESSION['signup'];
    $error['rewrite'] = true;//←これどういう意味やったっけ？
  }


?>




<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Fly High</title>
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
      <a class="navbar-brand page-scroll" href="#page-top"> <img class="header-logo" src="img/flyhigh_logo_white.png" width="27px" height="27px"> Fly High</a> </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
      <ul class="nav navbar-nav">
        <!-- Hidden li included to remove active class from about link when scrolled up past about section -->
        <li class="hidden"> <a href=""></a> </li>
        <li> <a class="page-scroll" href="#style">Style</a> </li>
        <li> <a class="page-scroll" href="#country">Country</a> </li>
      </ul>
    </div>
    <!-- /.navbar-collapse -->
  </div>
  <!-- /.container -->
</nav>


<form id="form_signup" method="post" action="">
<!-- Header -->
<!-- <form method="post" action=""> -->
<div id="intro">
  <div class="intro-body bg">
    <div class="container box">
      <h1>Sign up</h1>
                <p class="lead">ユーザー情報を登録してください</p>
                <br><br><br>
        <div class="row">
            <div class="col-sm-offset-4 col-sm-4">
              <!-- <form method="post" action=""> -->
              <!-- <form id="form_signup" method="post" action=""> -->


                <!-- ニックネーム -->
                <div class="form-group">
                  <div class="input-group" data-validate="email">

                    <!-- 他項目(email)がブランク以外のエラーだった時、
                    入力していた文字を消えないようにする(ok) -->
                    <?php if (isset($_POST['nick_name'])): ?>
                      <input type="text" class="form-control" name="nick_name" id="nick_name" required  value="<?php echo htmlspecialchars($_POST['nick_name'], ENT_QUOTES, 'UTF-8'); ?>">
                      <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
                    <?php else: ?>
                      <input type="text" class="form-control" name="nick_name" id="nick_name" placeholder="お名前を入力してください" required>
                      <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
                    <?php endif; ?>

                  </div>
                </div>



                <!-- メールアドレス -->
                <div class="form-group">
                  <div class="input-group" data-validate="email">

                    <!-- 他項目(password)がブランク以外のエラーだった時、
                    入力していた文字を消えないようにする(ok) -->
                    <?php if (isset($_POST['email'])): ?>
                       <input type="text" class="form-control" name="email" id="email" required value="<?php echo htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8'); ?>">
                       <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
                    <?php else: ?>
                      <input type="text" class="form-control" name="email" id="email" placeholder="メールアドレスを入力してください" required>
                      <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
                    <?php endif; ?>
                  </div>
                  <!-- ＠マークない場合の表示(ok) -->
                  <?php if(isset($error['email']) && $error['email']=='wrong'){ ?>
                    <p class="error">* メールアドレスに@が含まれていません。</p>
                  <?php } ?>
                  <!-- すでに登録されている時の表示(ok) -->
                  <?php if(isset($error['email']) && $error['email']=='already'){ ?>
                    <p class="error">* このメールアドレスはすでに登録されています。</p>
                  <?php } ?>
                </div>




                <!-- パスワード -->
                <div class="form-group">
                  <div class="input-group" data-validate="email">
                      <input type="password" class="form-control" name="password" id="password" placeholder="パスワードを入力してください" required>
                      <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
                  </div>
                  <!-- 字数エラーの処理(ok) -->
                  <?php if(isset($error['password']) && $error['password']=='length'){ ?>
                    <p class="error">* passwordは6文字以上で入力してください</p>
                  <?php } ?>
                </div>

                <!-- 確認用パスワード -->
                <div class="form-group">
                  <div class="input-group" data-validate="email">
                    <input type="password" class="form-control" name="re_password" id="re_password" placeholder="パスワードをもう一度入力してください" required>
                    <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
                  </div>
                  <!-- パスワード確認の処理(ok) -->
                  <?php if(isset($error['re_password']) && $error['re_password']=='not_same'){ ?>
                    <p class="error">* passwordが違います</p>
                  <?php } ?>
                </div>
              <!-- </form> -->
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
                <input type="checkbox" name="style[]" value="alone">
                <img src="img/style/icon_alone.png" class="img-responsive style-photo check" alt="ひとり旅">
              </label>
              <p id="country-name">ひとり旅</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
          <div class="portfolio-item">
              <label>
                <input type="checkbox" name="style[]" value="couple">
                <img src="img/style/icon_couple.png" class="img-responsive style-photo check" alt="カップル">
              </label>
              <p id="country-name">カップル・夫婦</p>
          </div>
        </div>
       <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
          <div class="portfolio-item">
              <label>
                <input type="checkbox" name="style[]" value="family">
                <img src="img/style/icon_family.png" class="img-responsive style-photo check" alt="家族旅行">
              </label>
              <p id="country-name">家族旅行</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
          <div class="portfolio-item">
              <label>
                <input type="checkbox" name="style[]" value="food">
                <img src="img/style/icon_food.png" class="img-responsive style-photo check" alt="グルメ">
              </label>
              <p id="country-name">グルメ</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
          <div class="portfolio-item">
              <label>
                <input type="checkbox" name="style[]" value="resort">
                <img src="img/style/icon_resort.png" class="img-responsive style-photo check" alt="リゾート">
              </label>
              <p id="country-name">リゾート</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
          <div class="portfolio-item">
              <label>
                <input type="checkbox" name="style[]" value="nature">
                <img src="img/style/icon_nature.png" class="img-responsive style-photo check" alt="自然">
              </label>
              <p id="country-name">自然</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
          <div class="portfolio-item">
              <label>
                <input type="checkbox" name="style[]" value="ruins">
                <img src="img/style/icon_ruins.png" class="img-responsive style-photo check" alt="遺跡">
              </label>
              <p id="country-name">遺跡</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
          <div class="portfolio-item">
              <label>
                <input type="checkbox" name="style[]" value="shopping">
                <img src="img/style/icon_shopping.png" class="img-responsive style-photo check" alt="ショッピング">
              </label>
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
                <input type="checkbox" name="country[]" value="Ireland">
                <img src="img/country/ireland.jpg" class="img-responsive country-photo check" alt="アイルランド">
              </label>
            </div>
            <p id="country-name">アイルランド</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 north_america">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <input type="checkbox" name="country[]" value="UnitedStates">
                <img src="img/country/usa.jpg" class="img-responsive country-photo check" alt="アメリカ">
              </label>
            </div>
            <p id="country-name">アメリカ</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <input type="checkbox" name="country[]" value="UnitedArabEmirates">
                <img src="img/country/uae.jpg" class="img-responsive country-photo check" alt="アラブ首長国連邦">
              </label>
            </div>
            <p id="country-name">アラブ首長国連邦</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 europe">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <input type="checkbox" name="country[]" value="UnitedKingdom">
                <img src="img/country/uk.jpg" class="img-responsive country-photo check" alt="イギリス">
              </label>
            </div>
            <p id="country-name">イギリス</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 europe">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <input type="checkbox" name="country[]" value="Italy">
                <img src="img/country/italy.jpg" class="img-responsive country-photo check" alt="イタリア">
              </label>
            </div>
            <p id="country-name">イタリア</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <input type="checkbox" name="country[]" value="India">
                <img src="img/country/india.jpg" class="img-responsive country-photo check" alt="インド">
              </label>
            </div>
            <p id="country-name">インド</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <input type="checkbox" name="country[]" value="Indonesia">
                <img src="img/country/indonesia.jpg" class="img-responsive country-photo check" alt="インドネシア">
              </label>
              </div>
              <p id="country-name">インドネシア</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 oceania">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <input type="checkbox" name="country[]" value="Australia">
                <img src="img/country/australia.jpg" class="img-responsive country-photo check" alt="オーストラリア">
              </label>
            </div>
            <p id="country-name">オーストラリア</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 europe">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <input type="checkbox" name="country[]" value="Netherlands">
                <img src="img/country/netherland.jpg" class="img-responsive country-photo check" alt="オランダ">
              </label>
            </div>
            <p id="country-name">オランダ</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <input type="checkbox" name="country[]" value="Qatar">
                <img src="img/country/qatar.jpg" class="img-responsive country-photo check" alt="カタール">
              </label>
            </div>
            <p id="country-name">カタール</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 north_america">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <input type="checkbox" name="country[]" value="Canada">
                <img src="img/country/canada.jpg" class="img-responsive country-photo check" alt="カナダ">
              </label>
            </div>
            <p id="country-name">カナダ</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <input type="checkbox" name="country[]" value="Korea">
                <img src="img/country/korea.jpg" class="img-responsive country-photo check" alt="韓国">
              </label>
            </div>
            <p id="country-name">韓国</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <input type="checkbox" name="country[]" value="Cambodia">
                <img src="img/country/cambodia.jpg" class="img-responsive country-photo check" alt="カンボジア">
              </label>
            </div>
            <p id="country-name">カンボジア</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 oceania">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <input type="checkbox" name="country[]" value="Guam">
                <img src="img/country/guam.jpg" class="img-responsive country-photo check" alt="グアム">
              </label>
            </div>
            <p id="country-name">グアム</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 oceania">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <input type="checkbox" name="country[]" value="Saipan">
                <img src="img/country/saipan.jpg" class="img-responsive country-photo check" alt="サイパン">
              </label>
            </div>
            <p id="country-name">サイパン</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <input type="checkbox" name="country[]" value="Singapore">
                <img src="img/country/singapore.jpg" class="img-responsive country-photo check" alt="シンガポール">
              </label>
            </div>
            <p id="country-name">シンガポール</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 europe">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <input type="checkbox" name="country[]" value="Spain">
                <img src="img/country/spain.jpg" class="img-responsive country-photo check" alt="スペイン">
              </label>
            </div>
            <p id="country-name">スペイン</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <input type="checkbox" name="country[]" value="Thailand">
                <img src="img/country/thailand.jpg" class="img-responsive country-photo check" alt="タイ">
              </label>
            </div>
            <p id="country-name">タイ</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <input type="checkbox" name="country[]" value="Taiwan">
                <img src="img/country/taiwan.jpg" class="img-responsive country-photo check" alt="台湾">
              </label>
            </div>
            <p id="country-name">台湾</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <input type="checkbox" name="country[]" value="China">
                <img src="img/country/china.jpg" class="img-responsive country-photo check" alt="中国">
              </label>
            </div>
            <p id="country-name">中国</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <input type="checkbox" name="country[]" value="Turkey">
                <img src="img/country/turkey.jpg" class="img-responsive country-photo check" alt="トルコ">
              </label>
            </div>
            <p id="country-name">トルコ</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 oceania">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <input type="checkbox" name="country[]" value="NewCaledonia">
                <img src="img/country/newcaledonia.jpg" class="img-responsive country-photo check" alt="ニューカレドニア">
              </label>
            </div>
            <p id="country-name">ニューカレドニア</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 oceania">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <input type="checkbox" name="country[]" value="NewZealand">
                <img src="img/country/newzealand.jpg" class="img-responsive country-photo check" alt="ニュージーランド">
              </label>
            </div>
            <p id="country-name">ニュージーランド</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 oceania">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <input type="checkbox" name="country[]" value="Hawaii">
                <img src="img/country/hawaii.jpg" class="img-responsive country-photo check" alt="ハワイ">
              </label>
            </div>
            <p id="country-name">ハワイ</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <input type="checkbox" name="country[]" value="Philippines">
                <img src="img/country/elnido.jpg" class="img-responsive country-photo check" alt="フィリピン">
              </label>
            </div>
            <p id="country-name">フィリピン</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 europe">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <input type="checkbox" name="country[]" value="Finland">
                <img src="img/country/finland.jpg" class="img-responsive country-photo check" alt="フィンランド">
              </label>
            </div>
            <p id="country-name">フィンランド</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 europe">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <input type="checkbox" name="country[]" value="France">
                <img src="img/country/france.jpg" class="img-responsive country-photo check" alt="フランス">
              </label>
            </div>
            <p id="country-name">フランス</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <input type="checkbox" name="country[]" value="VietNam">
                <img src="img/country/vietnam.jpg" class="img-responsive country-photo check" alt="ベトナム">
              </label>
            </div>
            <p id="country-name">ベトナム</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <input type="checkbox" name="country[]" value="HongKong">
                <img src="img/country/hongkong.jpg" class="img-responsive country-photo check" alt="香港">
              </label>
            </div>
            <p id="country-name">香港・マカオ</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 asia">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <input type="checkbox" name="country[]" value="Malaysia">
                <img src="img/country/malaysia.jpg" class="img-responsive country-photo check" alt="マレーシア">
              </label>
            </div>
            <p id="country-name">マレーシア</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 north_america">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <input type="checkbox" name="country[]" value="Mexico">
                <img src="img/country/mexico.jpg" class="img-responsive country-photo check" alt="メキシコ">
              </label>
            </div>
            <p id="country-name">メキシコ</p>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 europe">
          <div class="portfolio-item">
            <div class="hover-bg">
              <label>
                <input type="checkbox" name="country[]" value="Russia">
                <img src="img/country/russia.jpg" class="img-responsive country-photo check" alt="ロシア">
              </label>
            </div>
            <p id="country-name">ロシア</p>
          </div>
        </div>
      </div>
      <!-- ボタンsectionのdivを作るためにコメントアウト！ -->
      <!-- <div class="text-center">
        <button type="submit" class="btn btn-default">TOPページに戻る</button>
        <button type="submit" class="btn btn-default">ユーザー登録する</button>
      </div>
      <div class="text-center agree">
      アカウントを作成することで、Fly Highの<a hreaf="">利用規約</a>と<a hreaf="">プライバシーポリシー</a>に同意するものとします。
      </div>
      <div class="text-center agree">
      <div class="clearfix"></div>
      <hr>
      もしかして、すでにアカウントをお持ちですか？
      </div>
      <div class="text-center agree">
        <button type="submit" class="btn btn-default">ログインする</button>
      </div> -->
    </div>
  </div>
</div>



<!-- ボタンsectionのdivを作り、新しくid=buttonを付ける -->
<!-- <form method="post" action=""> -->
<div id="button">
  <div class="container">
    <div class="text-center">
      <a href="index.php" type="submit" class="btn btn-default">TOPページに戻る</a>
      <!-- <button type="submit" class="btn btn-default">ユーザー登録する</button> -->
      <button form="form_signup" type="submit" class="btn btn-default">ユーザー登録する</button>
    </div>
    <div class="text-center agree">
      アカウントを作成することで、Fly Highの<a href="terms.php">利用規約</a>と<a href="policy.php">プライバシーポリシー</a>に同意するものとします。
    </div>
    <div class="text-center agree">
      <div class="clearfix"></div>
      <hr>
      もしかして、すでにアカウントをお持ちですか？
    </div>
    <div class="text-center agree">
      <a href="login.php" type="submit" class="btn btn-default">ログインする</a>
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