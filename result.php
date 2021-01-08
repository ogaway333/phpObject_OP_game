<?php

ini_set('log_errors','on');  //ログを取るか
ini_set('error_log','php.log');  //ログの出力ファイルを指定
require('class.php');
session_start(); //セッション使う

if(!empty($_POST)){
  $_SESSION['end']=$_POST['end'];

}

if(empty($_SESSION) || empty($_SESSION['end'])){
  header("Location:index.php");
}



?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta property="og:url" content="記事のURL" />
    <meta property="og:title" content="記事のタイトル" />
    <meta property="og:description" content="記事の要約（ディスクリプション）" />
    <meta property="og:image" content="画像のURL" /> <!--⑥-->
    <title>ホームページのタイトル</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=M+PLUS+Rounded+1c" rel="stylesheet">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/ress.css">
    <link rel="stylesheet" href="css/style.css?<?php echo date('Ymd-Hi'); ?>">
    <script src="https://kit.fontawesome.com/13cf318513.js" crossorigin="anonymous"></script>
  </head>
  <body>
  <main class="game_screen">
    <div class="result_panel">
      <h2 class="result-h2 state-font">RESULT</h2>
      <div class="result_text state-font">KILL:<?php if(!empty($_SESSION['player'])) echo $_SESSION['player']->getKill(); ?></div>
      <div class="result_text state-font">GOLD:<?php if(!empty($_SESSION['player'])) echo $_SESSION['player']->getGoldTotal(); ?></div>
      <a href="//twitter.com/share" class="twitter-share-button twitter-button" data-text="倒した敵の数:<?php echo $_SESSION['player']->getKill();?>&#010;稼いだゴールド:<?php echo $_SESSION['player']->getGoldTotal();?>&#010;" data-hashtags="DemonsRush" data-url="https://www.google.com/&#010;" data-lang="ja">
 Tweet</a>
      <button class="retry-button state-font" onclick="location.href='index.php'">RETRY</button>
    </div>

  </main>

<script
  src="https://code.jquery.com/jquery-2.2.4.js"
  integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI="
  crossorigin="anonymous"></script>
<script type="text/javascript" src="js/common.js?<?php echo date('Ymd-Hi'); ?>"></script>
<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
  </body>
</html>
