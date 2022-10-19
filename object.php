<?php
ini_set('log_errors', 'on');
ini_set('error_log', 'error.log');
session_start();
// 変数の定義
$beatBoxersJ = array();
$beatBoxersW = array();

// 抽象クラス（人）
abstract class Human {
  // プロパティ
  protected $name;
  protected $hp;
  protected $minAttack;
  protected $maxAttack;
  // コンストラクタ
  public function __construct($name, $img, $hp, $minAttack, $maxAttack){
    $this -> name = $name;
    $this -> img = $img;
    $this -> hp = $hp;
    $this -> minAtaack = $minAttack;
    $this -> maxAttack = $maxAttack;
  }
  // セッター・ゲッター
  public function setName($str){
    $this -> name = $str;
  }
  public function getName(){
    return $this -> name;
  }
  public function getImg(){
    return $this -> img;
  }
  public function setHp($num){
    $this -> hp = $num;
  }
  public function getHp(){
    return $this -> hp;
  }

  // 攻撃メソッド
  public function attack($opponent){
    Judge::set($this->getName().'のビート');
    $attackPoint = mt_rand($this->minAttack(), $this->maxAttack());
    // 4分の1の確率で必殺ビート
    if (!mt_rand(0, 3)) {
      Judge::set('必殺ビートが飛び出した！！');
      $attackPoint *= 1.5;
    }
    Judge::set($attackPoint.'ポイントの判定');
    $opponent -> setHp($opponent->getHp() - $attackPoint);
  }
}

// 日本人クラス
class Japan extends Human{
  protected $minHealing;
  protected $maxHealing;

  public function __construct($name, $img, $hp, $minAttack, $maxAttack, $minHealing, $maxHealing){
    parent::__construct($name, $img, $hp, $minAttack, $maxAttack);
    $this -> minHealing = $minHealing;
    $this -> maxHealing = $maxHealing;
  }
  // 回復メソッド
  public function healing($healer){
    Judge::set($healer->getName().'は水を飲んだ');
    $healPoint = mt_rand($this->minHealing, $this->maxHealing);
    // 5分の1の確率で大きく回復
    if (!mt_rand(0,4)) {
      Judge::set('のどの調子がかなり良くなった！！');
      $healPoint *= 2;
    }
    Judge::set($healPoint.'ポイント分の体力を回復した');
    $healer->setHp($healer->getHp() + $healPoint);
  }
}

// 外国人クラス
class World extends Human{}
// レジェンドクラス
class Legend extends World{
  protected $legendBeat;
  public function __construct($name, $img, $hp, $minAttack, $maxAttack, $legendBeat){
    parent::__construct($name, $img, $hp, $minAttack, $maxAttack);
    $this -> legendBeat = $legendBeat;
  }
  // 攻撃クラスオーバーライド
  public function attack($opponent){
    // 5分の1の確率で伝説のビート
    if (!empty(mt_rand(0, 4))) {
      Judge::set($this->getName().'の伝説のビートだ！！！！！');
      $attackPoint = $this -> legendBeat;
      Judge::set($attackPoint.'ポイントの判定');
      $opponent -> setHp($opponent->getHp() - $attackPoint);
    }else {
      parent::attack($opponent);
    }
  }
}

// 進行役クラス
class Judge {
  static function set($str){
    if (empty($_SESSION['judge'])) {
      $_SESSION['judge'] = '';
    }
    $_SESSION['judge'] .= $str.'<br>';
  }

  static function clear(){
    $_SESSION['judge'] = '';
  }
}

// 日本インスタンス $beatBoxersJ[] = new Japan($name, $img, $hp, $minAttack, $maxAttack, $minHealing, $maxHealing);
$beatBoxersJ[] = new Japan('SHOW-GO', '/img/japan.png', 400, 120, 200, 100, 150);
$beatBoxersJ[] = new Japan('HIKAKIN', '/img/japan.png', 700, 50, 80, 20, 50);
$beatBoxersJ[] = new Japan('so-so', '/img/japan.png', 500, 80, 130, 50, 80);
$beatBoxersJ[] = new Japan('Rofu', '/img/japan.png', 800, 100, 150, 20, 50);
$beatBoxersJ[] = new Japan('SARUKANI', '/img/japan.png', 1000, 80, 100, 150, 200);
$beatBoxersJ[] = new Japan('4th GAS', '/img/japan.png', 1000, 130, 230, 50, 100);
// 世界インスタンス $beatBoxersJ[] = new World($name, $img, $hp, $minAttack, $maxAttack);
$beatBoxersW[] = new World('Gene Shinozaki', '/img/world.png', $hp, $minAttack, $maxAttack);
$beatBoxersW[] = new World("RIVER'", '/img/world.png', $hp, $minAttack, $maxAttack);
$beatBoxersW[] = new World('Robin', '/img/world.png', $hp, $minAttack, $maxAttack);
$beatBoxersW[] = new World('Rhythmind', '/img/world.png', $hp, $minAttack, $maxAttack);
$beatBoxersW[] = new World('Middle School', '/img/world.png', $hp, $minAttack, $maxAttack);
$beatBoxersW[] = new World('Rogue Wave', '/img/world.png', $hp, $minAttack, $maxAttack);
$beatBoxersW[] = new World('The Beatbox House', '/img/world.png', $hp, $minAttack, $maxAttack);

// レジェンドインスタンス  　$beatBoxersW[] = new Legend($name, $img, $hp, $minAttack, $maxAttack, $legendBeat);
$beatBoxersW[] = new Legend('D-low', '/img/world.png', $hp, $minAttack, $maxAttack, $legendBeat);
$beatBoxersW[] = new Legend('CodFish', '/img/world.png', $hp, $minAttack, $maxAttack, $legendBeat);
$beatBoxersW[] = new Legend('SARO', '/img/world.png', $hp, $minAttack, $maxAttack, $legendBeat);
$beatBoxersW[] = new Legend('SPIDER HORCE', '/img/world.png', $hp, $minAttack, $maxAttack, $legendBeat);
$beatBoxersW[] = new Legend('Berywam', '/img/world.png', $hp, $minAttack, $maxAttack, $legendBeat);



// その他の関数
function createJapan(){
  global $beatBoxersJ;
  $representJ = $beatBoxersJ[mt_rand(0, 5)];
  Judge::set('チームジャパンからは'.$representJ->getName().'が参戦！');
  $_SESSION['japan'] = $representJ;
}
function createWorld(){
  Judge::clear();
  global $beatBoxersW;
  $representW = $beatBoxersW[mt_rand(0, 11)];
  Judge::set('相手は'.$representW->getName().'だ');
  $_SESSION['world'] = $representW;
}
function restart(){
  Judge::clear();
  $_SESSION['knockDownCount'] = 0;
  Judge::set('3, 2, 1, ビートボックス！！');
  createJapan();
  createWorld();
}
function gameOver(){
  $_SESSION = array();
}

// ==================================
// POST送信で処理スタート

if (!empty($_POST)) {
  $startFlg = (!empty($_POST['start'])) ? true : false ;
  $attackFlg = (!empty($_POST['attack'])) ? true : false ;
  $healingFlg = (!empty($_POST['healing'])) ? true : false ;
  $escapeFlg = (!empty($_POST['escape'])) ? true : false ;

  // スタートおよびリスタート
  if ($startFlg) {
    restart();
  }

  // 攻撃もしくは回復
  if ($attackFlg || $healingFlg) {
    if ($attackFlg) {
      // こちらのターン、相手が倒れたら次の相手
      $_SESSION['japan'] -> attack($_SESSION['world']);

      if ($_SESSION['world']->getHp() <= 0) {
        Judge::set($_SESSION['japan']->getName().'の勝利！');
        $_SESSION['knockDownCount'] += 1;
        createWorld();
      }
    }elseif ($healingFlg) {
      $_SESSION['japan'] -> healing($_SESSION['japan']);
    }
    // その後相手のターン、自分が倒れたらゲームオーバー
    $_SESSION['world'] -> attack($_SESSION['japan']);
    if ($_SESSION['japan']->getHp() <= 0) {
      gameOver();
    }
  }

  // 逃げる
  if ($escapeFlg) {
    Judge::set('棄権した');
    createWorld();
  }
}


 ?>
