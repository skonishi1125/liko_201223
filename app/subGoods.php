<?php
session_start();
require('dbconnect.php');
require('functions.php');

// 
// ログイン確認
// 
require('../app/_parts/_checkLogin.php');

$postid = $_POST['postid'];
$memberid = $_POST['memberid'];

//いいねの初期数値を記録
$defs= $db->prepare('SELECT good FROM posts WHERE id=?');
$defs->execute( array($postid) );
$def = $defs->fetch();
$defGood = $def['good'];

//posts DBにいいね追加後の値を格納する
$postsDBs = $db->prepare('UPDATE posts SET good=?, modified=NOW() WHERE id=?');
$defGood -= 1;
$postsDB = $postsDBs->execute(array( $defGood, $postid, ));
// echoを挟むと、「1」という表記が出てくる
// echo $postsDB = $postsDBs->execute(array( $defGood, $postid, ));


//いいね更新後の値を格納する
$updates = $db->prepare('SELECT good FROM posts WHERE id=?');
$updates->execute( array($postid) );
$update = $updates->fetch();
$updateGood = $update['good'];

//goods DBから、どの投稿にどのメンバーがいいねしたかの情報を削除する
$goodsDBs = $db->prepare('DELETE FROM goods WHERE member_id=? AND post_id=?');
$goodsDBs->execute(array( $memberid, $postid, ));
// echo $goodsDB = $goodsDBs->execute(array( $member['id'], $postid, ));

echo $updateGood;






// いったんコメント

// //どのURLからいいね!ボタンを押したか(index, userpage等)
// $url = $_SESSION['currentURI'];

// //どの投稿に対して処理をするか
// $postid = $_GET['good'];

// // echo $postid . " " . $url;

// //いいねの初期数値を記録
// $defaults = $db->prepare('SELECT good FROM posts WHERE id=?');
// $defaults->execute( array($postid) );
// $default = $defaults->fetch();
// $defaultGood = $default['good'];

// // echo ' 元々のいいねの数:' . $defaultGood . ' ';

// //posts DBにいいね取り消し後の値を格納する
// $postsDBs = $db->prepare('UPDATE posts SET good=?, modified=NOW() WHERE id=?');
// $defaultGood -= 1;
// echo $postsDB = $postsDBs->execute(array( $defaultGood, $postid, ));

// //goods DBから、どの投稿にどのメンバーがいいねしたかの情報を削除する
// $goodsDBs = $db->prepare('DELETE FROM goods WHERE member_id=? AND post_id=?');
// $goodsDBs->execute(array( $member['id'], $postid, ));


// // 元いたURLに戻る
// header('Location: ' . $url);
// exit();


?>