<?php 
session_start();
require('../app/dbconnect.php');

if(isset($_SESSION['id'])){
  $id = $_REQUEST['id'];

  //投稿の確認
  $messages = $db->prepare('SELECT * FROM posts WHERE id=?');
  $messages->execute(array($id));
  $message = $messages->fetch();

  if($message['member_id'] == $_SESSION['id']){
    //削除
    $del = $db->prepare('DELETE FROM posts WHERE id=?');
    $del->execute(array($id));
  }
}

header('Location: http://localhost:8888/liko_201223/web/index.php');
exit();

?>