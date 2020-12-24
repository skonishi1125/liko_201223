<?php
session_start();
require('../app/dbconnect.php');
require('../app/functions.php');

// 
// ログイン確認
// 
if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time() ) {
  $_SESSION['time'] = time();
  $members = $db->prepare('SELECT * FROM members WHERE id=?');
  $members->execute(array($_SESSION['id']));

  $member = $members->fetch();
  // loginでmemberを識別するidをsessionに入れることで、他のファイルでも使用できるようにする
} else {
  header('Location: http://localhost:8888/liko_201223/web/login.php');
  exit();
}




include('../app/_parts/_header.php');

?>

<header class="indexHeader-bar">
  <img src="../join/img/whiteLogo.png" alt="liko" class="indexHeader-logo">
</header>















<div class="pt-5">
  <p><?php echo h($member['name']) ?>さん、こんにちは。</p>
  <a href="../app/logout.php">とりあえずログアウトする・・・！</a>
</div>


<?php
include('../app/_parts/_footer.php');

?>