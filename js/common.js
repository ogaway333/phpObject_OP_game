$(function () {

  var bgm = new Audio('bgm/battle.mp3');
  var spinSE = new Audio('bgm/spin.mp3');
  var startSE = new Audio('bgm/start.mp3');
  var stopSE = new Audio('bgm/stop.mp3');
  var attackSE = new Audio('bgm/attack.mp3');
  var blockSE = new Audio('bgm/block.mp3');
  var heelSE = new Audio('bgm/heel.mp3');
  var skillSE = new Audio('bgm/skill.mp3');

  bgm.volume = 0.2;
  spinSE.volume = 0.3;
  attackSE.volume = 0.5;
  blockSE.volume = 0.5;
  heelSE.volume = 0.5;
  skillSE.volume = 0.5;
  bgm.loop = true;
  spinSE.loop = true;



  var $controlPanel = $('.control_screen');
  var $battlePanel = $('.battle_screen');
  var $gameScreen = $('.game_screen');
  var $startScreen = $('.start_screen');

  //コントロールパネルの高さの調整
  $controlPanel.attr({ 'style': 'height:' + ($gameScreen.height() - $battlePanel.height()) + 'px;' });


  //カウントダウン
  var countTime = null;
  var count = 60;
  var countDown = function () {
    count--;
    $('.countdown').text(count);
  }

  //ajax送信後の画面更新
  var updateState = function (data) {
    var PlayerHp = $(data).find('.js-playerHp').text();
    var PlayerBlock = $(data).find('.js-playerBlock').text();
    var PlayerGold = $(data).find('.js-playerGold').text();
    var PlayerKill = $(data).find('.js-playerKill').text();
    var EnemyHp = $(data).find('.js-enemyHp').text();
    var EnemyBlock = $(data).find('.js-enemyBlock').text();
    var monsterImg = $(data).find('.monster').children().attr('src');
    var chara1face = $(data).find('.js-chara1').attr('src');
    var chara2face = $(data).find('.js-chara2').attr('src');
    var chara3face = $(data).find('.js-chara3').attr('src');

    $('.monster').children().attr('src', monsterImg);

    $('.js-chara1').attr('src', chara1face);
    $('.js-chara2').attr('src', chara2face);
    $('.js-chara3').attr('src', chara3face);

    $('.js-playerHp').text(PlayerHp);
    $('.js-playerBlock').text(PlayerBlock);
    $('.js-playerGold').text(PlayerGold);
    $('.js-playerKill').text(PlayerKill);
    $('.js-enemyHp').text(EnemyHp);
    $('.js-enemyBlock').text(EnemyBlock);
    if ($(data).find('#js-end').attr('id')) {
      window.location.href = "result.php";
    }
  }

  //行動後の更新
  var action = function (action) {
    switch (action) {
      case 'attack':
        attackSE.play();

        break;
      case 'block':
        blockSE.play();
        break;
      case 'heel':
        heelSE.play();
        break;
      case 'skill1':
        skillSE.play();
        break;
      case 'skill2':
        skillSE.play();
        break;
      default:
        break;
    }
  }

  var $chara1Box = $('.js-chara1').parent();
  var $chara2Box = $('.js-chara2').parent();
  var $chara3Box = $('.js-chara3').parent();

  var charaAct = function ($charaBox) {
    $charaBox.animate({
      bottom: "10px",
      left: "0px"
    }, {
      duration: 'fast'
    });
    $('.monster').animate({
      top: "90%"
    }, {
      duration: 'fast'
    }).animate({
      top: "80%"
    });
  }

  var charaActClear = function () {
    $chara1Box.animate({
      bottom: "0px",
      left: "0px"
    }, {
      duration: 'fast'
    });
    $chara2Box.animate({
      bottom: "0px",
      left: "0px"
    }, {
      duration: 'fast'
    });
    $chara3Box.animate({
      bottom: "0px",
      left: "0px"
    }, {
      duration: 'fast'
    });
  }

  //スタート画面の遷移
  $(document).on('click', '.start_screen', function () {
    bgm.play();
    $startScreen.data('startFlg', true);
    var startFlg = $startScreen.data('startFlg');
    $.ajax({
      type: "POST",
      url: "index.php",
      data: {
        startFlg: startFlg
      }
    }).done(function (data) {
      console.log('Ajax OK');
      $startScreen.hide();
      updateState(data);
      countTime = setInterval(function () {
        countDown();
        if (count === 0) {
          clearInterval(countTime);
          $.post('result.php', 'end=true');
          window.location.href = "result.php";

        }
      }, 1000);
    }).fail(function (msg) {
      console.log('Ajax Error');
    });
  });

  //行動イメージのランダム切替
  var $randoms = [$('.random_box .js-random:first'), $('.random_box .js-random:nth-child(2)'), $('.random_box .js-random:last')];
  var $randomBoxs = ['.stop_box .stop_button:first.js-stop', '.stop_box .stop_button:nth-child(2).js-stop', '.stop_box .stop_button:last.js-stop'];
  var timer0 = null;
  var timer1 = null;
  var timer2 = null;
  //全て止めた後にスロット音を止めるための変数
  var stopCount = 0;

  var randomChange = function (randomNum) {
    switch (randomNum) {
      case 0:
        var keys = Object.keys(chara1Images);
        var imageNum = Math.floor(Math.random() * Object.keys(chara1Images).length);
        $randoms[randomNum].children().attr('src', chara1Images[keys[imageNum]]);
        $randoms[randomNum].children().data('chara1Act', keys[imageNum]);

        break;
      case 1:
        var keys = Object.keys(chara2Images);
        var imageNum = Math.floor(Math.random() * Object.keys(chara2Images).length);
        $randoms[randomNum].children().attr('src', chara2Images[keys[imageNum]]);
        $randoms[randomNum].children().data('chara2Act', keys[imageNum]);
        break;
      case 2:
        var keys = Object.keys(chara3Images);
        var imageNum = Math.floor(Math.random() * Object.keys(chara3Images).length);
        $randoms[randomNum].children().attr('src', chara3Images[keys[imageNum]]);
        $randoms[randomNum].children().data('chara3Act', keys[imageNum]);
        break;
      default:
        break;
    }
  }

  $(document).on('click', '.js-start', function () {
    startSE.play();
    spinSE.play();
    stopCount = 0;
    timer0 = setInterval(function () { randomChange(0) }, 50);
    timer1 = setInterval(function () { randomChange(1) }, 50);
    timer2 = setInterval(function () { randomChange(2) }, 50);
    $(this).toggleClass('js-start').attr('style', 'opacity:0.5');
    $('.stop_button').toggleClass('js-stop').attr('style', 'opacity:1.0');
  });



  $(document).on('click', $randomBoxs[0], function () {
    clearInterval(timer0);
    stopSE.currentTime = 0;
    stopSE.play();
    console.log('click1');
    stopCount++;
    $(this).removeClass('js-stop').attr('style', 'opacity:0.5');
    var chara1Act = $randoms[0].children().data('chara1Act');
    console.log(chara1Act);
    action(chara1Act);
    charaAct($chara1Box);

    $.ajax({
      type: "POST",
      url: "index.php",
      data: {
        chara1Act: chara1Act
      }
    }).done(function (data) {
      updateState(data);

      console.log('Ajax Success');

    }).fail(function (msg) {
      console.log('Ajax Error');
    });
    if (stopCount === 3) {
      spinSE.pause();
      stopCount = 0;
      charaActClear();
      $('.start_button').toggleClass('js-start').attr('style', 'opacity:1.0');
    }
  });

  $(document).on('click', $randomBoxs[1], function () {
    clearInterval(timer1);
    stopSE.currentTime = 0;
    stopSE.play();
    stopCount++;
    console.log('click2');
    $(this).removeClass('js-stop').attr('style', 'opacity:0.5');
    var chara2Act = $randoms[1].children().data('chara2Act');
    action(chara2Act);
    charaAct($chara2Box);
    $.ajax({
      type: "POST",
      url: "index.php",
      data: {
        chara2Act: chara2Act
      }
    }).done(function (data) {
      updateState(data);
      console.log('Ajax Success');
    }).fail(function (msg) {
      console.log('Ajax Error');
    });
    if (stopCount === 3) {
      spinSE.pause();
      stopCount = 0;
      charaActClear();
      $('.start_button').toggleClass('js-start').attr('style', 'opacity:1.0');
    }
  });

  $(document).on('click', $randomBoxs[2], function () {
    clearInterval(timer2);
    stopSE.currentTime = 0;
    stopSE.play();
    stopCount++;
    console.log('click3');
    $(this).removeClass('js-stop').attr('style', 'opacity:0.5');
    var chara3Act = $randoms[2].children().data('chara3Act');
    action(chara3Act);
    charaAct($chara3Box);
    $.ajax({
      type: "POST",
      url: "index.php",
      data: {
        chara3Act: chara3Act
      }
    }).done(function (data) {
      updateState(data);
      console.log('Ajax Success');
    }).fail(function (msg) {
      console.log('Ajax Error');
    });
    if (stopCount === 3) {
      spinSE.pause();
      stopCount = 0;
      charaActClear();
      $('.start_button').toggleClass('js-start').attr('style', 'opacity:1.0');
    }
  });



});
