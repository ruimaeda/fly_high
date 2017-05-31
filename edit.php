<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Modus</title>
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
      <a class="navbar-brand page-scroll" href="#page-top"> <i class="fa fa-paper-plane-o"></i> Modus</a> </div>
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
<div id="intro">
  <div class="intro-body bg">
    <div class="container box">
      <h1>Edit</h1>
                <p class="lead">ご登録いただいた情報を変更できます</p>
                <br><br><br>
        <div class="row">
            <div class="col-sm-offset-4 col-sm-4">
              <form method="post">
                <div class="form-group">
                  <div class="input-group" data-validate="email">
                    <input type="text" class="form-control" name="validate-email" id="validate-email" placeholder="お名前を入力してください" required>
                    <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group" data-validate="email">
                    <input type="text" class="form-control" name="validate-email" id="validate-email" placeholder="メールアドレスを入力してください" required>
                    <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group" data-validate="email">
                    <input type="text" class="form-control" name="validate-email" id="validate-email" placeholder="パスワードを入力してください" required>
                    <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group" data-validate="email">
                    <input type="text" class="form-control" name="validate-email" id="validate-email" placeholder="パスワードをもう一度入力してください" required>
                    <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
                  </div>
                </div>
                </form>
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
              <img src="img/style/icon_alone.png" class="img-responsive style-photo check" alt="Project Title">
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
<!-- Additional Question Section -->
<div id="add-question">
  <div class="container">
    <div class="section-title text-center">
       <h2>Additional Questions</h2>
       <hr>
       <p>もしよければ、あなたの情報をもっと教えてください</p>
    </div>
       <div class="row">
               <form class="form-horizontal">
               <fieldset class="questions">

               <!-- Multiple Radios -->
               <div class="form-group">
                 <label class="col-md-4 control-label" for="radios">性別</label>
                 <div class="col-md-4">
                 <div class="radio">
                   <label for="radios-0">
                     <input type="radio" name="radios" id="radios-0" value="1" checked="checked">
                     男性
                   </label>
                 </div>
                 <div class="radio">
                   <label for="radios-1">
                     <input type="radio" name="radios" id="radios-1" value="2">
                     女性
                   </label>
                 </div>
                 </div>
               </div>

               <!-- Select Basic -->
               <div class="form-group">
                 <label class="col-md-4 control-label" for="selectbasic">年齢</label>
                 <div class="col-md-4">
                   <select id="selectbasic" name="selectbasic" class="form-control">
                     <option value="1">10代</option>
                     <option value="2">20代</option>
                   </select>
                 </div>
               </div>

               <!-- Select Basic -->
               <div class="form-group">
                 <label class="col-md-4 control-label" for="selectbasic">居住地</label>
                 <div class="col-md-4">
                   <select id="selectbasic" name="selectbasic" class="form-control">
                     <option value="1">北海道</option>
                     <option value="2">青森</option>
                   </select>
                 </div>
               </div>

               <!-- Select Basic -->
               <div class="form-group">
                 <label class="col-md-4 control-label" for="selectbasic">年収</label>
                 <div class="col-md-4">
                   <select id="selectbasic" name="selectbasic" class="form-control">
                     <option value="1">300万円未満</option>
                     <option value="2">300万円〜500万円</option>
                   </select>
                 </div>
               </div>

               <!-- Multiple Checkboxes -->
               <div class="form-group">
                 <label class="col-md-4 control-label" for="checkboxes">海外旅行先の決め手</label>
                 <div class="col-md-4">
                 <div class="checkbox">
                   <label for="checkboxes-0">
                     <input type="checkbox" name="checkboxes" id="checkboxes-0" value="1">
                     自然
                   </label>
                 </div>
                 <div class="checkbox">
                   <label for="checkboxes-1">
                     <input type="checkbox" name="checkboxes" id="checkboxes-1" value="2">
                     歴史的建造物
                   </label>
                 </div>
                 </div>
               </div>

               <!-- Select Basic -->
               <div class="form-group">
                 <label class="col-md-4 control-label" for="selectbasic">海外旅行の平均的な予算</label>
                 <div class="col-md-4">
                   <select id="selectbasic" name="selectbasic" class="form-control">
                     <option value="1">〜5万円</option>
                     <option value="2">5万円〜10万円</option>
                   </select>
                 </div>
               </div>

               <!-- Select Basic -->
               <div class="form-group">
                 <label class="col-md-4 control-label" for="selectbasic">海外旅行の平均的な期間</label>
                 <div class="col-md-4">
                   <select id="selectbasic" name="selectbasic" class="form-control">
                     <option value="1">3日以内</option>
                     <option value="2">3~5日間</option>
                   </select>
                 </div>
               </div>

               <!-- Select Basic -->
               <div class="form-group">
                 <label class="col-md-4 control-label" for="selectbasic">これまでに訪れた国の数</label>
                 <div class="col-md-4">
                   <select id="selectbasic" name="selectbasic" class="form-control">
                     <option value="1">0ヶ国</option>
                     <option value="2">1ヶ国</option>
                   </select>
                 </div>
               </div>

               <!-- Select Basic -->
               <div class="form-group">
                 <label class="col-md-4 control-label" for="selectbasic">過去1年間の海外旅行の回数</label>
                 <div class="col-md-4">
                   <select id="selectbasic" name="selectbasic" class="form-control">
                     <option value="1">0回</option>
                     <option value="2">1回</option>
                   </select>
                 </div>
               </div>

               <!-- Select Basic -->
               <div class="form-group">
                 <label class="col-md-4 control-label" for="selectbasic">Fly Highを知ったキッカケ</label>
                 <div class="col-md-4">
                   <select id="selectbasic" name="selectbasic" class="form-control">
                     <option value="1">検索サイト</option>
                     <option value="2">ソーシャルメディア</option>
                   </select>
                 </div>
               </div>

               <!-- Textarea -->
               <div class="form-group">
                 <label class="col-md-4 control-label" for="textarea">サイトへのご要望</label>
                 <div class="col-md-4">
                   <textarea class="form-control" id="textarea" name="textarea">要望を入力してください</textarea>
                 </div>
               </div>

               </fieldset>
               </form>
           </div>
       </div>
       <br><br><br>
      <div class="text-center">
        <button type="submit" class="btn btn-default">TOPページに戻る</button>
        <button type="submit" class="btn btn-default">情報を更新する</button>
        <button type="submit" class="btn btn-default">マイページに戻る</button>
      </div>
      <div class="text-center agree">
      Fly Highを退会する場合は<a hreaf="">こちら</a>をクリック
      </div>
</div>

  </div>
</div>
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
<script type="text/javascript" src="js/contact_me.js"></script>
<script type="text/javascript" src="js/signup.js"></script>

<!-- Javascripts
    ================================================== -->
<script type="text/javascript" src="js/main.js"></script>
</body>
</html>