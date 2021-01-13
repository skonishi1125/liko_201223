<?php
session_start();

//セッション情報の削除
$_SESSION = array();
if (ini_get("session.use_cookies")) {
  $params = session_get_cookie_params();
  setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
}
session_destroy();


//クッキーの削除
// setcookie('sessionid', '', time()-3600, '/');

// setcookie('test', $test, time() + 3600, '/');
// $test = 'aaa';
// setcookie('test', $test, time() + 3600, '/');


// unset($_COOKIE['sessionid']);

//なぜか2回読み込まないと飛ばない理由を探る
//login.phpに飛んだ時にどこからcookie[test]を拾ってきているのか確認する

setcookie('email', '', time() - 3600, '/liko_201223/web');
setcookie('password', '', time() - 3600, '/liko_201223/web');


header('Location: http://localhost:8888/liko_201223/web/login.php');
exit();

if ($_COOKIE['test'] == 'aaa') {
  header('Location: http://localhost:8888/liko_201223/join/web/index.php');
  exit();
  echo 'aaaがcookieに保管されています';
}
echo "\n" . 'うおお';

?>