<?php

ini_set('log_errors','on');  //ログを取るか
ini_set('error_log','php.log');  //ログの出力ファイルを指定
require('class.php');
session_start(); //セッション使う
// モンスター達格納用
$monsters = array();
// パーティー格納用
$party = array();

//勇者の行動画像
$actionImg1= array(
  'attack' => 'img/attack.png',
  'block' => 'img/block.png',
  'heel' => 'img/heel.png',
  'skill1' => 'img/braveSkill1.png',
  'skill2' => 'img/braveSkill2.png'
 );

 //魔法使いの行動画像
 $actionImg2= array(
  'attack' => 'img/attack.png',
  'block' => 'img/block.png',
  'heel' => 'img/heel.png',
  'skill1' => 'img/wizardSkill1.png',
  'skill2' => 'img/wizardSkill2.png'
 );

 //剣士の行動画像
 $actionImg3= array(
  'attack' => 'img/attack.png',
  'block' => 'img/block.png',
  'heel' => 'img/heel.png',
  'skill1' => 'img/swordSkill1.png',
  'skill2' => 'img/swordSkill2.png'
 );


$json_array1 = json_encode($actionImg1);
$json_array2 = json_encode($actionImg2);
$json_array3 = json_encode($actionImg3);


// インスタンス生成

//$name, $hp, $ap, $bp, $rp, $charaImg, $actionImg
$party[] = new Brave('勇者', 50, 20, 5, 10, "img/brave.png", $actionImg1);
$party[] = new Wizard('魔法使い', 20, 15, 8, 20, "img/wizard.png", $actionImg2);
$party[] = new Sword('剣士', 50, 25, 10, 5, "img/sword.png", $actionImg3);


//$name, $hp, $ap, $bpRise, $rp, $charaImg, $gold
$monsters[] = new Monster('スライム', 10, 20, 3, 1, "img/slime.png", 500);
$monsters[] = new Monster('ラビット', 50, 25, 5, 8, "img/rabbit.png", 800);
$monsters[] = new Monster('凶暴な獣', 80, 30, 8, 2, "img/tiger.png", 1500);
$monsters[] = new Monster('ケルベロス', 55, 40, 10, 5, "img/cerberus.png", 3000);

$monsters[] = new Monster('バード', 20, 25, 3, 1, "img/bird.png", 900);
$monsters[] = new Monster('シャドウ', 30, 25, 5, 8, "img/shadow.png", 3500);
$monsters[] = new Monster('悪魔', 60, 50, 8, 2, "img/demon.png", 4000);
$monsters[] = new Monster('ペンギン', 55, 20, 10, 5, "img/penguin.png", 5000);

$monsters[] = new Monster('天使', 100, 10, 1, 1, "img/angel.png", 10000);

//$hpTotal, $bpTotal, $goldTotal
$player = new Player($party[0]->getHp()+$party[1]->getHp()+$party[2]->getHp(), 0, 0);


function createMonster(){
  global $monsters;
  $monster =  $monsters[mt_rand(0, 8)];
  $_SESSION['monster'] =  $monster;
}

function createParty(){
  global $party;
  $_SESSION['chara1'] =  $party[0];
  $_SESSION['chara2'] =  $party[1];
  $_SESSION['chara3'] =  $party[2];
}

function createPlayer(){
  global $player;
  $_SESSION['player'] =  $player;
}

function init(){
  createPlayer();
  createparty();
  createMonster();
}


if(!empty($_POST)){
  if(!empty($_POST['startFlg'])) {
    $_SESSION['startFlg'] = $_POST['startFlg'];
    init();
  }
  error_log(print_r($_SESSION,true));
  if($_SESSION['startFlg']) {
    if(!empty($_POST['chara1Act'])) {
      error_log(print_r($_POST['chara1Act'],true));
      if($_POST['chara1Act'] === 'attack') {
        $_SESSION['chara1']->attack($_SESSION['monster']);
        error_log(print_r($_SESSION['monster'],true));
      }
      if($_POST['chara1Act'] === 'block') {
        $_SESSION['chara1']->bpUp($_SESSION['player']);
        error_log(print_r($_SESSION['player'],true));
      }
      if($_POST['chara1Act'] === 'heel') {
        $_SESSION['chara1']->heel($_SESSION['player']);
        error_log(print_r($_SESSION['player'],true));
      }
      if($_POST['chara1Act'] === 'skill1') {
        $_SESSION['chara1']->skill1($_SESSION['monster']);
        error_log(print_r($_SESSION['monster'],true));
      }
      if($_POST['chara1Act'] === 'skill2') {
        $_SESSION['chara1']->skill2($_SESSION['monster']);
        error_log(print_r($_SESSION['monster'],true));
      }
      $_SESSION['monster']->selectAct($_SESSION['player'], $_SESSION['monster']);
    }

    if(!empty($_POST['chara2Act'])) {
      error_log(print_r($_POST['chara2Act'],true));
      if($_POST['chara2Act'] === 'attack') {
        $_SESSION['chara2']->attack($_SESSION['monster']);
        error_log(print_r($_SESSION['monster'],true));
      }
      if($_POST['chara2Act'] === 'block') {
        $_SESSION['chara2']->bpUp($_SESSION['player']);
        error_log(print_r($_SESSION['player'],true));
      }
      if($_POST['chara2Act'] === 'heel') {
        $_SESSION['chara2']->heel($_SESSION['player']);
        error_log(print_r($_SESSION['player'],true));
      }
      if($_POST['chara2Act'] === 'skill1') {
        $_SESSION['chara2']->skill1($_SESSION['player']);
        error_log(print_r($_SESSION['player'],true));
      }
      if($_POST['chara2Act'] === 'skill2') {
        $_SESSION['chara2']->skill2($_SESSION['monster']);
        error_log(print_r($_SESSION['monster'],true));
      }
      $_SESSION['monster']->selectAct($_SESSION['player'], $_SESSION['monster']);
    }

    if(!empty($_POST['chara3Act'])) {
      error_log(print_r($_POST['chara3Act'],true));
      if($_POST['chara3Act'] === 'attack') {
        $_SESSION['chara3']->attack($_SESSION['monster']);
        error_log(print_r($_SESSION['monster'],true));
      }
      if($_POST['chara3Act'] === 'block') {
        $_SESSION['chara3']->bpUp($_SESSION['player']);
        error_log(print_r($_SESSION['player'],true));
      }
      if($_POST['chara3Act'] === 'heel') {
        $_SESSION['chara3']->heel($_SESSION['player']);
        error_log(print_r($_SESSION['player'],true));
      }
      if($_POST['chara3Act'] === 'skill1') {
        $_SESSION['chara3']->skill1($_SESSION['monster']);
        error_log(print_r($_SESSION['monster'],true));
      }
      if($_POST['chara3Act'] === 'skill2') {
        $_SESSION['chara3']->skill2($_SESSION['player']);
        error_log(print_r($_SESSION['player'],true));
      }
      $_SESSION['monster']->selectAct($_SESSION['player'], $_SESSION['monster']);
    }
    // hpが0以下になったら、別のモンスターを出現させる
    if($_SESSION['monster']->getHp() <= 0){
      $_SESSION['player']->setGoldTotal($_SESSION['player']->getGoldTotal() + $_SESSION['monster']->getGold());
      $_SESSION['player']->setKill($_SESSION['player']->getKill()+1);
      createMonster();
    }
    // プレイヤーのhpが0以下になったらresultページへ移動
    if($_SESSION['player']->getHpTotal() <= 0){
      $_SESSION['end']=true;
    }
  }
}else{
  $_SESSION = array();
}




?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
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
  <?php if(empty($_SESSION)): ?>
  <div class="start_screen">
    <h1 class='state-font title-h1'>DemonsRush</h1>
    <span class='state-font'>Start</span>
  </div>
  <?php endif; ?>
   <div class="battle_screen" id='<?php if(!empty($_SESSION['end'])) echo 'js-end'; ?>'>
   <div class="state-cover">
   <div class="countdown state-font"></div>
    <div class="mystate">
      <div class="state-font state-Player js-playerHp">HP <?php if(!empty($_SESSION['player']))  echo $_SESSION['player']->getHpTotal(); ?>/<?php if(!empty($_SESSION['player']))  echo $_SESSION['player']->getHpMax(); ?></div>
      <div class="state-font state-Player js-playerBlock">BLOCK <?php if(!empty($_SESSION['player']))  echo $_SESSION['player']->getBpTotal(); ?></div>
      <div class="state-font state-Player js-playerGold">GOLD <?php if(!empty($_SESSION['player']))  echo $_SESSION['player']->getGoldTotal(); ?></div>
      <div class="state-font state-Player js-playerKill">KILL <?php if(!empty($_SESSION['player']))  echo $_SESSION['player']->getKill(); ?></div>
    </div>
    <div class="enemystate">
      <div class="state-font state-enemy js-enemyHp">HP <?php if(!empty($_SESSION['monster']))  echo $_SESSION['monster']->getHp(); ?>/<?php if(!empty($_SESSION['monster']))  echo $_SESSION['monster']->getHpMax(); ?></div>
      <div class="state-font state-enemy js-enemyBlock">BLOCK <?php if(!empty($_SESSION['monster']))  echo $_SESSION['monster']->getBp(); ?></div>
    </div>
   </div>
    <div class="monster">
      <img src='<?php if(!empty($_SESSION['monster']))  echo $_SESSION['monster']->getCharaImg(); ?>' alt="">
    </div>
   </div>
   <div class="control_screen">
   <div class="party">
    <p><img class="js-chara1" src='<?php if(!empty($_SESSION['chara1']))  echo $_SESSION['chara1']->getCharaImg(); ?>' alt=""></p>
    <p><img class="js-chara2" src='<?php if(!empty($_SESSION['chara2']))  echo $_SESSION['chara2']->getCharaImg(); ?>' alt=""></p>
    <p><img class="js-chara3" src='<?php if(!empty($_SESSION['chara3']))  echo $_SESSION['chara3']->getCharaImg(); ?>' alt=""></p>
   </div>

   <div class="random_box">
    <p class="js-random"><img src=""></p>
    <p class="js-random"><img src=""></p>
    <p class="js-random"><img src=""></p>
   </div>
   <div class="stop_box">
    <button class="stop_button" style="opacity:0.5"></button>
    <button class="stop_button" style="opacity:0.5"></button>
    <button class="stop_button" style="opacity:0.5"></button>
   </div>
    <p class="start_button js-start"><img src="img/start.png" alt=""></p>
   </div>
  </main>

<script
  src="https://code.jquery.com/jquery-2.2.4.js"
  integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI="
  crossorigin="anonymous"></script>
  <script>
  //phpからjsに値渡し
  var chara1Images = <?php echo $json_array1; ?>;
  var chara2Images = <?php echo $json_array2; ?>;
  var chara3Images = <?php echo $json_array3; ?>;
  </script>
<script type="text/javascript" src="js/common.js?<?php echo date('Ymd-Hi'); ?>"></script>
  </body>
</html>
