<?php

// 抽象クラス（生き物クラス）
abstract class Creature{
  protected $name;
  protected $hp;
  protected $ap;
  protected $bp;
  protected $rp;
  protected $charaImg;
  public function setName($str){
    $this->name = $str;
  }
  public function getName(){
    return $this->name;
  }
  public function setHp($str){
    $this->hp = $str;
  }
  public function getHp(){
    return $this->hp;
  }
  public function setBp($str){
    $this->bp = $str;
  }
  public function getBp(){
    return $this->bp;
  }
  public function setRp($str){
    $this->rp = $str;
  }
  public function getRp(){
    return $this->rp;
  }

  public function getCharaImg(){
    return $this->charaImg;
  }

  abstract public function skill1($targetObj);
  abstract public function skill2($targetObj);

  abstract public function attack($targetObj);
  abstract public function heel($targetObj);

  abstract public function bpUp($targetObj);
}


//プレイヤークラス
class Player {
  protected $hpTotal;
  protected $hpMax;
  protected $bpTotal;
  protected $bpMin;
  protected $goldTotal;
  protected $kill;

  public function getHpTotal(){
    return $this->hpTotal;
  }
  public function setHpTotal($hpTotal){
    $this->hpTotal = $hpTotal;
  }
  public function getHpMax(){
    return $this->hpMax;
  }
  public function getBpTotal(){
    return $this->bpTotal;
  }
  public function setBpTotal($bpTotal){
    $this->bpTotal = $bpTotal;
  }
  public function getBpMin(){
    return $this->bpMin;
  }
  public function getGoldTotal(){
    return $this->goldTotal;
  }
  public function setGoldTotal($goldTotal){
    $this->goldTotal = $goldTotal;
  }
  public function getKill(){
    return $this->kill;
  }
  public function setKill($kill){
    $this->kill = $kill;
  }
  public function __construct($hpTotal, $bpTotal, $goldTotal) {
    $this->hpTotal = $hpTotal;
    $this->hpMax = $hpTotal;
    $this->bpTotal = $bpTotal;
    $this->bpMin = 0;
    $this->goldTotal = $goldTotal;
    $this->kill = 0;
  }
}


//モンスタークラス
class Monster extends Creature{
  protected $hpMax;
  protected $bpRise;
  protected $gold;
  protected $bpMin;

  public function __construct($name, $hp, $ap, $bpRise, $rp, $charaImg, $gold) {
    $this->name = $name;
    $this->hp = $hp;
    $this->hpMax = $hp;
    $this->ap = $ap;
    $this->bpRise = $bpRise;
    $this->bp = 0;
    $this->bpMin = 0;
    $this->rp = $rp;
    $this->charaImg = $charaImg;
    $this->gold = $gold;
  }
  public function getHpMax(){
    return $this->hpMax;
  }
  public function getBpMin(){
    return $this->bpMin;
  }
  public function getBpRise(){
    return $this->bpRise;
  }

  public function getGold(){
    return $this->gold;
  }

  public function attack($targetObj){
    if(($targetObj->getBpTotal() -  $this->ap) <= $targetObj->getBpMin()){

      $targetObj->setHpTotal(($targetObj->getHpTotal() + $targetObj->getBpTotal()) - $this->ap);
      $targetObj->setBpTotal($targetObj->getBpMin());
      if($targetObj->getHpTotal() < 0){
        $targetObj->setHpTotal(0);
      }
    }else{
      $targetObj->setBpTotal(($targetObj->getBpTotal()) - $this->ap);
    }
  }

  public function heel($targetObj){
    if(($targetObj->getHp() + $this->rp) > $targetObj->getHpMax()){
      $targetObj->SetHp($targetObj->getHpMax());
    }else{
      $targetObj->SetHp($targetObj->getHp() + $this->rp);
    }
  }

  public function bpUp($targetObj){
    $targetObj->setBp($targetObj->getBpRise() + $this->bp);
  }

  public function skill1($targetObj){


  }
  public function skill2($targetObj){

  }

  public function selectAct($playerObj, $monsterObj){
    $act = mt_rand(0, 2);
    switch ($act) {
      case 0:
        $this->attack($playerObj);
        break;
      case 1:
        $this->bpUp($monsterObj);
        break;
      case 2:
        $this->heel($monsterObj);
        break;
      default:
        break;
    }
  }

}


//人クラス
abstract class Human extends Creature{
  protected $actionImg=array();
  public function __construct($name, $hp, $ap, $bp, $rp, $charaImg, $actionImg) {
    $this->name = $name;
    $this->hp = $hp;
    $this->ap = $ap;
    $this->bp = $bp;
    $this->rp = $rp;
    $this->charaImg = $charaImg;
    $this->actionImg = $actionImg;

  }
  public function attack($targetObj){
    if(($targetObj->getBp() -  $this->ap) <= $targetObj->getBpMin()){
      $targetObj->setHp(($targetObj->getHp() + $targetObj->getBp()) - $this->ap);
      $targetObj->setBp($targetObj->getBpMin());
      if($targetObj->getHp() < 0){
        $targetObj->setHp(0);
      }

    }else{
      $targetObj->setBp(($targetObj->getBp()) - $this->ap);
    }
  }

  public function bpUp($targetObj){
    $targetObj->setBpTotal($targetObj->getBpTotal() + $this->bp);
  }

  public function heel($targetObj){
    if(($targetObj->getHpTotal() + $this->rp) > $targetObj->getHpMax()){
      $targetObj->SetHpTotal($targetObj->getHpMax());
    }else{
      $targetObj->SetHpTotal($targetObj->getHpTotal() + $this->rp);
    }
  }
}

//勇者クラス
class Brave extends Human{

  public function skill1($targetObj){
    if(($targetObj->getBp() -  $this->ap*3) <= $targetObj->getBpMin()){
      $targetObj->setHp(($targetObj->getHp() + $targetObj->getBp()) - $this->ap*3);
      $targetObj->setBp($targetObj->getBpMin());
      if($targetObj->getHp() < 0){
        $targetObj->setHp(0);
      }

    }else{
      $targetObj->setBp(($targetObj->getBp()) - $this->ap*3);
    }
  }
  public function skill2($targetObj){
    if(($targetObj->getBp() -  $this->ap*2) <= $targetObj->getBpMin()){
      $targetObj->setHp(($targetObj->getHp() + $targetObj->getBp()) - $this->ap*2);
      $targetObj->setBp($targetObj->getBpMin());
      if($targetObj->getHp() < 0){
        $targetObj->setHp(0);
      }

    }else{
      $targetObj->setBp(($targetObj->getBp()) - $this->ap*2);
    }
  }

}

//剣士クラス
class Sword extends Human{

  public function skill1($targetObj){
    if(($targetObj->getBp() -  $this->ap*2) <= $targetObj->getBpMin()){
      $targetObj->setHp(($targetObj->getHp() + $targetObj->getBp()) - $this->ap*2);
      $targetObj->setBp($targetObj->getBpMin());
      if($targetObj->getHp() < 0){
        $targetObj->setHp(0);
      }

    }else{
      $targetObj->setBp(($targetObj->getBp()) - $this->ap*2);
    }
  }
  public function skill2($targetObj){
    $targetObj->setBpTotal($targetObj->getBpTotal() + $this->bp*2);
  }

}

//魔法使いクラス
class Wizard extends Human{

  public function skill1($targetObj){
    if(($targetObj->getHpTotal() + $this->rp*2) > $targetObj->getHpMax()){
      $targetObj->SetHpTotal($targetObj->getHpMax());
    }else{
      $targetObj->SetHpTotal($targetObj->getHpTotal() + $this->rp*2);
    }
  }
  public function skill2($targetObj){
    if(($targetObj->getBp() -  $this->ap*2) <= $targetObj->getBpMin()){
      $targetObj->setHp(($targetObj->getHp() + $targetObj->getBp()) - $this->ap*2);
      $targetObj->setBp($targetObj->getBpMin());
      if($targetObj->getHp() < 0){
        $targetObj->setHp(0);
      }

    }else{
      $targetObj->setBp(($targetObj->getBp()) - $this->ap*2);
    }
  }

}



?>
