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
  protected $img;
  protected $hp;
  protected $minAttack;
  protected $maxAttack;
  // コンストラクタ
  public function __construct($name, $img, $hp, $minAttack, $maxAttack){
    $this -> name = $name;
    $this -> img = $img;
    $this -> hp = $hp;
    $this -> minAttack = $minAttack;
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
    Judge::set($this->getName().'の攻撃');
    $attackPoint = mt_rand($this->minAttack, $this->maxAttack);
    // 4分の1の確率で必殺ビート
    if (!mt_rand(0, 3)) {
      Judge::set('必殺ビートが飛び出した！！');
      $attackPoint *= 1.5;
    }
    Judge::set($attackPoint.'ポイントのダメージ');
    $opponent -> setHp($opponent->getHp() - $attackPoint);
  }
}

// 日本人クラス
class Japan extends Human{
  protected $experience;
  protected $minHealing;
  protected $maxHealing;

  public function __construct($name, $img, $hp, $minAttack, $maxAttack, $experience, $minHealing, $maxHealing){
    parent::__construct($name, $img, $hp, $minAttack, $maxAttack);
    $this -> experience = $experience;
    $this -> minHealing = $minHealing;
    $this -> maxHealing = $maxHealing;
  }
  public function setExperience($num){
    $this -> experience = $num;
  }
  public function getExperience(){
    return $this -> experience;
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
    Judge::set($healPoint.'ポイント回復');
    $healer->setHp($healer->getHp() + $healPoint);
  }
}

// 外国人クラス
// 倒した場合の経験値を追加
class World extends Human{
  protected $level;
  public function __construct($name, $img, $hp, $minAttack, $maxAttack, $level){
    parent::__construct($name, $img, $hp, $minAttack, $maxAttack);
    $this -> level = $level;
  }
  public function getLevel(){
    return $this -> level;
  }
}

// レジェンドクラス
class Legend extends World{
  protected $legendBeat;
  public function __construct($name, $img, $hp, $minAttack, $maxAttack, $level, $legendBeat){
    parent::__construct($name, $img, $hp, $minAttack, $maxAttack, $level);
    $this -> legendBeat = $legendBeat;
  }
  // 攻撃クラスオーバーライド
  public function attack($opponent){
    // 5分の1の確率で伝説のビート
    if (empty(mt_rand(0, 4))) {
      Judge::set($this->getName().'の伝説のビートだ！！！！！');
      $attackPoint = $this -> legendBeat;
      Judge::set($attackPoint.'ポイントのダメージ');
      $opponent -> setHp($opponent->getHp() - $attackPoint);
    }else {
      parent::attack($opponent);
    }
  }
}

interface InterfaceJudge {
  static function set($str);
  static function clear();
}


// 進行役クラス
class Judge implements InterfaceJudge {
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

// 日本インスタンス $beatBoxersJ[] = new Japan($name, $img, $hp, $minAttack, $maxAttack, $experience, $minHealing, $maxHealing);
$beatBoxersJ[] = new Japan('SHOW-GO', '/img/japan.png', 400, 120, 200, 1, 100, 150);
$beatBoxersJ[] = new Japan('HIKAKIN', '/img/japan.png', 700, 50, 80, 20, 1, 50);
$beatBoxersJ[] = new Japan('so-so', '/img/japan.png', 500, 80, 130, 50, 1, 80);
$beatBoxersJ[] = new Japan('Rofu', '/img/japan.png', 800, 100, 150, 20, 1, 50);
$beatBoxersJ[] = new Japan('SARUKANI', '/img/japan.png', 1000, 80, 100, 1, 150, 200);
$beatBoxersJ[] = new Japan('4th GAS', '/img/japan.png', 1000, 130, 230, 1, 50, 100);
// 世界インスタンス $beatBoxersJ[] = new World($name, $img, $hp, $minAttack, $maxAttack, $level);
$beatBoxersW[] = new World('Gene Shinozaki', '/img/world.png', 200, 30, 50, 1);
$beatBoxersW[] = new World("RIVER'", '/img/world.png', 150, 30, 50, 1);
$beatBoxersW[] = new World('Robin', '/img/world.png', 100, 30, 50, 1);
$beatBoxersW[] = new World('Rhythmind', '/img/world.png', 180, 40, 60, 1);
$beatBoxersW[] = new World('Middle School', '/img/world.png', 210, 30, 60, 1);
$beatBoxersW[] = new World('Rogue Wave', '/img/world.png', 200, 30, 70, 1);
$beatBoxersW[] = new World('TheBeatboxHouse', '/img/world.png', 250, 40, 60, 1);

// レジェンドインスタンス  　$beatBoxersW[] = new Legend($name, $img, $hp, $minAttack, $maxAttack, $level, $legendBeat);
$beatBoxersW[] = new Legend('D-low', '/img/world.png', 350, 80, 100, 2, 150);
$beatBoxersW[] = new Legend('CodFish', '/img/world.png', 300, 60, 80, 2, 130);
$beatBoxersW[] = new Legend('SARO', '/img/world.png', 350, 60, 90, 2, 130);
$beatBoxersW[] = new Legend('SPIDER HORCE', '/img/world.png', 400, 70, 120, 2, 150);
$beatBoxersW[] = new Legend('Berywam', '/img/world.png', 420, 50, 120, 2, 150);



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
function start(){
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
  $resetFlg = (!empty($_POST['reset'])) ? true : false;

  // スタートおよびリスタート
  if ($startFlg) {
    start();
  }

  // 攻撃もしくは回復
  if ($attackFlg || $healingFlg) {
    // 攻撃する場合
    if ($attackFlg) {
      $_SESSION['japan'] -> attack($_SESSION['world']);
      // 敵のHPが0以下になったら次に進む
      if ($_SESSION['world']->getHp() <= 0) {
        Judge::set($_SESSION['japan']->getName().'の勝利！');
        $_SESSION['knockDownCount'] += 1;
        createWorld();
        return;

      }
    // 回復する場合
    }elseif ($healingFlg) {
      // Japanの回復ターン
      $_SESSION['japan'] -> healing($_SESSION['japan']);
    }

    // その後Worldのターン、JapanのHPが0になったらゲームオーバー
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

  // リセット
  if ($resetFlg) {
    session_destroy();
  }
}


 ?>
