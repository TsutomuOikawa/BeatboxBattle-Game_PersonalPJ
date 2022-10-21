<?php require('object.php'); ?>

<!DOCTYPE html>
<html lang="ja" >
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <title>BeatBoxBattle</title>
  </head>

  <body class="page-wrapper">
    <header class="page_title">
      BeatBoxBattle Tour in Japan
    </header>
    <div class="page_contents page_contents-wrapper">

      <div class="side">
        <?php for ($i=0; $i < 2; $i++): ?>
        <img src="img/speaker.png" class="sideImg" alt="スピーカー">
        <?php endfor; ?>
      </div>

      <main class="stage <?php echo (!isset($_SESSION['knockDownCount'])) ?'stage--before' :'stage--after'; ?>">
        <div class="stage-wrapper">

        <?php if(!$_SESSION): ?>
          <h2 class="stage_title">〜HumanBeatBoxのバトルへようこそ〜</h2>
          <div class="stage_contents contents--center">
            <div class="field">
              <p class="field_introText">
                世界のビートボクサーが日本に集結！<br>
                チームJapan VS チームWorld<br>
                ビートボックスバトルが幕を開ける！
              </p>
              <form class="field_action" method="post">
                <input type="submit" class="btn btn--center" name="start" value="スタート">
              </form>
            </div>
          </div>

        <?php elseif ($_SESSION['knockDownCount'] < 7) : ?>
          <h2 class="stage_title">
            <span style="width:300px; text-align:right;"><?php echo $_SESSION['japan']->getName(); ?></span>
            <span style="width:100px;">vs</span>
            <span style="width:300px; text-align:left;"><?php echo $_SESSION['world']->getName(); ?></span>
          </h2>
          <p class="stage_knockDownCount">現在の連勝記録：<?php echo $_SESSION['knockDownCount']; ?></p>
          <div class="stage_contents contents--between">
            <div class="field field--player">
              <img src="#" class="field_img" alt="">
              <p>自分：<?php echo $_SESSION['japan']->getName(); ?></p>
              <p>残りのHP：<?php echo $_SESSION['japan']->getHp(); ; ?></p>
              <form class="field_action" method="post">
                <input type="submit" class="btn btn--center" name="attack" value="演奏する">
                <input type="submit" class="btn btn--center" name="healing" value="水を飲む">
                <input type="submit" class="btn btn--center" name="escape" value="逃げる">
                <input type="submit" class="btn btn--center" name="start" value="はじめから">
              </form>
            </div>

            <div class="judge">
              <?php echo $_SESSION['judge']; ?>
            </div>

            <div class="field field--player">
              <img src="#" class="field_img" alt="">
              <p>相手：<?php echo $_SESSION['world']->getName() ; ?></p>
              <p>残りのHP：<?php echo $_SESSION['world']->getHp(); ?></p>

            </div>
          </div>

        <?php else: ?>
          <h2 class="stage_title">〜congratulations〜</h2>
          <div class="stage_contents contents--center">
            <div class="field">
              <p class="field_introText">
                名だたるビートボクサーに勝利した！<br>
              </p>
              <form class="field_action" method="post">
                <input type="submit" class="btn btn--center" name="reset" value="トップにもどる">
              </form>
            </div>
          </div>

        <?php endif; ?>
        </div>
      </main>

      <div class="side">
        <?php for ($i=0; $i < 2; $i++): ?>
        <img src="img/speaker.png" class="sideImg" alt="スピーカー">
        <?php endfor; ?>
      </div>
    </div>

    <footer>

    </footer>


  </body>
</html>
