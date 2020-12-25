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


/* 
-----
投稿をDBに格納する
-----
*/

if (!empty($_POST)) {
  //画像の有無判定
  $postPicName = $_FILES['postpic']['name'];
  $videoURL = substr($_POST['video'], 0, 23);
  $mobileURL = substr($_POST['video'], 0, 21);
  $videoID = substr($_POST['video'], -13);
  $v = substr(h($post['video']), -11);
  //https://www.youtube.com

  if (!empty($videoURL)) {
    if ($videoURL != 'https://www.youtube.com' && $mobileURL != 'https://m.youtube.com') {
      $error['video'] = 'type';
    }
    if (substr($videoID,0,2) != 'v=') {
      $error['video'] = 'type';
    }
  }

  if (empty($_POST['message'])) {
    $error['message'] = 'blank';
  }

  //どっちも入っていた場合の処理
  if ($_POST['message'] != '' && !empty($postPicName)) {
    //拡張子チェック
    if (!empty($postPicName)) {
      $ext = substr($postPicName, -4);
      if ($ext == 'jpeg' || $ext == 'JPEG'){
        $ext = '.' . $ext;
      }
      if ($ext != '.jpg' && $ext !='.png' && $ext !='.PNG' && $ext !='.JPG' && $ext !='.gif' && $ext != '.JPEG' && $ext != '.jpeg'){
          $error['postpic'] = 'type';
      }
    }

    if (empty($error)) {
      $postImgTime = date('YmdHis');
      $postPicName = $postImgTime . sha1($postPicName) . $ext;

      move_uploaded_file($_FILES['postpic']['tmp_name'], '../post_picture/' . $postPicName);

        //動画の紹介があった場合
      if (!empty($_POST['video']) ) {
        $message = $db->prepare('INSERT INTO posts SET title=?,member_id=?, message=?, post_pic=?, video=?, reply_post_id=?, created=NOW()');

        if ($_POST['reply_post_id'] == 0) {
          $message->execute(array(
            $_POST['title'], $member['id'], $_POST['message'], $postPicName, $_POST['video'], 0
          ));
        } else {
          $message->execute(array(
            $_POST['title'], $member['id'], $_POST['message'], $postPicName, $_POST['video'], $_POST['reply_post_id'],
          ));
        }
      } else {
        $message = $db->prepare('INSERT INTO posts SET title=?,member_id=?, message=?, post_pic=?, reply_post_id=?, created=NOW()');
        if ($_POST['reply_post_id'] == 0){
          $message->execute(array(
            $_POST['title'], $member['id'], $_POST['message'], $postPicName, 0
          ));
        } else {
          $message->execute(array(
            $_POST['title'], $member['id'], $_POST['message'], $postPicName, $_POST['reply_post_id'],
          ));
        }
      }

      /*----------------投稿画像のリサイズ-----------------*/
      $imageName = $postPicName;
      list($width, $height, $type, $attr) = getimagesize('../post_picture/'.$imageName);

      $newWidth = 1000;//新しい横幅
      $newHeight = 1000;//新しい縦幅

      fitContain(1000, $width, $height, $newWidth, $newHeight);

      /*--------Exif--------------*/
      //exif読み取り
      $exif_data = exif_read_data('../post_picture/'.h($imageName));

      //画像リサイズ
      if ($ext == '.gif'){
        $baseImage = imagecreatefromgif('../post_picture/'.h($imageName));
        $image = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($image, $baseImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        imagegif($image, '../post_picture/'.h($imageName));

      } else if ($ext == '.png' || $ext == '.PNG'){
        $baseImage = imagecreatefrompng('../post_picture/'.h($imageName));
        $image = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($image, $baseImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        imagepng($image, '../post_picture/'.h($imageName));

      } else if ($ext == '.jpg' || $ext == '.jpeg' || $ext == '.JPG' || $ext == '.JPEG'){
        $baseImage = imagecreatefromjpeg('../post_picture/'.h($imageName));
        $image = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($image, $baseImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        imagejpeg($image, '../post_picture/'.h($imageName));
        //exif読み取り
        imageOrientation('../post_picture/'.h($imageName), $exif_data['Orientation']);
      }

      header('Location: http://localhost:8888/liko_201223/web/index.php');
      exit();

    } /* enpty($error) */
  } // どっちも入っていた場合の処理


  //メッセージだけが入っていた場合の処理
  if  ($_POST['message'] != '') {
    if (empty($error)) {
      if (!empty($_POST['video']) ) {
        $message = $db->prepare('INSERT INTO posts SET title=?, member_id=?, message=?, video=?, reply_post_id=?, created = NOW()');

        if ($_POST['reply_post_id'] == ''){
          $message->execute(array(
            $_POST['title'], $member['id'], $_POST['message'], $_POST['video'], 0
          ));
        } else {
          $message->execute(array(
            $_POST['title'], $member['id'], $_POST['message'], $_POST['video'], $_POST['reply_post_id']
          ));
        }

      } else {
        $message = $db->prepare('INSERT INTO posts SET title=?, member_id=?, message=?, reply_post_id=?, created = NOW()');

        if ($_POST['reply_post_id'] == '') {
          $message->execute(array(
            $_POST['title'], $member['id'], $_POST['message'], 0
          ));
        } else {
          $message->execute(array(
            $_POST['title'], $member['id'], $_POST['message'], $_POST['reply_post_id'],
          ));
        }

      }
      header('Location: http://localhost:8888/liko_201223/web/index.php');
      exit();
    } /* enpty($error) */
  } // メッセージだけが入っていた場合の処理


  //画像が入っていた場合の処理
  if (!empty($postPicName)) {
    //拡張子チェック
    if (!empty($postPicName)) {
      $ext = substr($postPicName, -4);
      if ($ext == 'jpeg' || $ext == 'JPEG') {
        $ext = '.' . $ext;
      }
      if ($ext != '.jpg' && $ext !='.png' && $ext !='.PNG' && $ext !='.JPG' && $ext !='.gif' && $ext != '.JPEG' && $ext != '.jpeg') {
        $error['postpic'] = 'type';
      }
    }

    if (empty($error)) {
      //画像ファイルの名前をわからなくする処理
      $postImgTime = date('YmdHis');
      $postPicName = $postImgTime . sha1($postPicName) . $ext;
      move_uploaded_file($_FILES['postpic']['tmp_name'], '../post_picture/' . $postPicName);
      if ($videoURL == 'https://www.youtube.com'){
        $message = $db->prepare('INSERT INTO posts SET title=?, member_id=?, post_pic=?, video=?, reply_post_id=?, created=NOW()');
        if ($_POST['reply_post_id'] == '') {
          $message->execute(array(
            $_POST['title'], $member['id'], $postPicName, $_POST['video'], 0
          ));
        } else {
          $message->execute(array(
            $_POST['title'], $member['id'], $postPicName, $_POST['video'], $_POST['reply_post_id'],
          ));
        }

    } else {
      $message = $db->prepare('INSERT INTO posts SET title=?, member_id=?, post_pic=?, reply_post_id=?, created=NOW()');
      if ($_POST['reply_post_id'] == '') {
        $message->execute(array(
          $_POST['title'], $member['id'], $postPicName, 0,
        ));
      } else {
        $message->execute(array(
          $_POST['title'], $member['id'], $postPicName, $_POST['reply_post_id'],
        ));
      }
    }

    /*----------------投稿画像のリサイズ-----------------*/
    $imageName = $postPicName;
    list($width, $height, $type, $attr) = getimagesize('../post_picture/'.$imageName);

    $newWidth = 1000;//新しい横幅
    $newHeight = 1000;//新しい縦幅

    fitContain(1000, $width, $height, $newWidth, $newHeight);


      //画像リサイズ
    if ($ext == '.gif') {
      $baseImage = imagecreatefromgif('../post_picture/'.h($imageName));
      $image = imagecreatetruecolor($newWidth, $newHeight);
      imagecopyresampled($image, $baseImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
      imagegif($image, '../post_picture/'.h($imageName));

    } else if ($ext == '.png' || $ext == '.PNG'){
      $baseImage = imagecreatefrompng('../post_picture/'.h($imageName));
      $image = imagecreatetruecolor($newWidth, $newHeight);
      imagecopyresampled($image, $baseImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
      imagepng($image, '../post_picture/'.h($imageName));

    } else if ($ext == '.jpg' || $ext == '.jpeg'|| $ext == '.JPG' || $ext == '.JPEG'){
      $baseImage = imagecreatefromjpeg('../post_picture/'.h($imageName));
      $image = imagecreatetruecolor($newWidth, $newHeight);
      imagecopyresampled($image, $baseImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
      imagejpeg($image, '../post_picture/'.h($imageName));
      //exif読み取り
      imageOrientation('../post_picture/'.h($imageName), $exif_data['Orientation']);
    }

      header('Location: http://localhost:8888/liko_201223/web/index.php');
      exit();
    }
  } /* empty($error) */
} // 画像が入っていた時の処理



/*
----
投稿取得
----
*/

//ページ分け
$page = $_REQUEST['page'];
if ($page == ''){
  $page = 1;
}
//-の数対策
$page = max($page, 1);

$counts = $db->query('SELECT COUNT(*) AS cnt FROM posts');
$cnt = $counts->fetch();
$maxPage = ceil($cnt['cnt'] / 10);
$page = min($page, $maxPage);
$start = ($page - 1) * 10;

if ($start < 0){
  $start = 0;
}


$posts = $db->prepare('SELECT m.name, m.picture, p.* FROM members m, posts p WHERE m.id = p.member_id ORDER BY p.created DESC  LIMIT ?, 10');
$posts->bindParam(1, $start, PDO::PARAM_INT);
$posts->execute();


//返信
if (isset($_REQUEST['res'])){
  $response = $db->prepare('SELECT m.name, m.picture, p.* FROM members m, posts p WHERE m.id = p.member_id AND p.id=? ORDER BY p.created DESC');
  $response->execute(array($_REQUEST['res']));
  $table = $response->fetch();
  $message = '>>@' . $table['name']. '[' . $table['id'] . '] ';
}

$goodPosts = $db->prepare('SELECT post_id FROM goods WHERE member_id=?');
$goodPosts->bindParam(1, $member['id'], PDO::PARAM_INT);
$goodPosts->execute();


//いいねボタンが押された時の処理
//初期goodを最初に取得しておく
$origins = $db->prepare('SELECT good FROM posts WHERE id=?');
$origins->execute(array(
  $_REQUEST['good']
));
$origin = $origins->fetch();
$defGood = $origin['good'];

if (isset($_REQUEST['good'])) {
  $good = $db->prepare('UPDATE posts SET good=?, modified=NOW() WHERE id=?');
  $defGood = $defGood + 1;
  echo $retGood = $good->execute(array(
    $defGood,
    $_REQUEST['good'],
  ));

  //いいねテーブルへの格納
  $goodState = $db->prepare('INSERT INTO goods SET member_id=?, post_id=?,created=NOW()');
  echo $goodRet = $goodState->execute(array(
    $member['id'],
    $_REQUEST['good'],
  ));

  //echo $goodRetを使わない場合はこちらを採用する　$goodRet = $goodState->fetch();

  header('Location: http://localhost:8888/liko_201223/web/index.php');
  exit();

}

//コメント(review機能)
if (isset($_POST['review'])) {
  if (!empty($_POST['review'])) {
    $reviews = $db->prepare('INSERT INTO reviews SET member_id=?, post_id=?, member_pic=?, comment=?, created=NOW()');
    $reviews->execute(array(
      $member['id'], $_POST['postid'], $member['picture'], $_POST['review'],
    ));

    header('Location: http://localhost:8888/liko_201223/web/index.php');
    exit();
    //これないと更新するたび増えていく
  }else{
    $error['review'] = 'blank';
  }
}

//search.phpで空コメントした場合のエラー
if ($_SESSION['review'] == 'blank'){
  $error['review'] = 'blank';
  unset($_SESSION['review']);
}

//アイコン用のext取得
$iconExt = substr($member['picture'],-4);


/* 
ヘッダーファイル読み込み
*/
include('../app/_parts/_header.php');

?>

<!-- 
  HTML
 -->

<header class="indexHeader-bar">
  <img src="../join/img/whiteLogo.png" alt="liko" class="indexHeader-logo">
</header>

<div class="container-fluid">
  <nav class="col-md-2 leftFix-contents">
  
    <div class="leftFix-configMenus">
      <a href="index.php"><i class="fas fa-home"></i>ホーム</a>
      <a href="userpage.php"><i class="fas fa-user-alt"></i>マイページ</a>
      <a href="changeIcon.php"><i class="fas fa-cog"></i>アイコンの変更</a>
      <a href="../app/logout.php"><i class="fas fa-sign-out-alt"></i>ログアウト</a>
  
      <div class="leftFix-menusBorder"></div>
  
      <div class="leftFix-searchForm">
        <p>投稿を検索する</p>
        <form class="searchForm" action="search.php" method="post">

          <!-- <input name="search" type="text" class="searchBox">
          <input type="submit" value="&#xf002;" class="fas searchIcon"> -->

          <div class="input-group">
            <input type="text" class="form-control searchBox" placeholder="Search for..." aria-label="キーワード" aria-describedby="basic-addon" name="search">
            <div class="input-group-append">
              <button class="btn btn-primary btn-sm p-0" type="submit"><i class="fas fa-search"></i></button>
            </div>
          </div>

        </form>
      </div>
  
    </div>
  
    <div class="leftFix-userPost">
    <?php 
      if($iconExt != 'jpeg' && $iconExt != '.png' && $iconExt != '.PNG'
      && $iconExt != 'JPEG' && $iconExt != '.gif' && $iconExt != '.jpg'
      && $iconExt != '.JPG' ):
    ?>
      <img class="iconImg img-thumbnail" src="../member_picture/user.png">
    <?php else: ?>
      <img class="iconImg img-thumbnail" src="../member_picture/<?php echo h($member['picture']); ?>">
    <?php endif; ?>
      <p><b><?php echo h($member['name']); ?></b></p>
      <a class="openCommentModal btn btn-primary" role="button">投稿する</a>
    </div>
  
  </nav> <!-- leftFix-contents -->


  <?php //いいね処理
  $i = 0;
  $goodArray = array();
  while ($goodPost = $goodPosts->fetch() ){
    $goodArray[$i] = $goodPost['post_id'];
    $i++;
  };
  ?>

  <!-- 
    エラーアラート
   -->

  <?php if (!empty($error)) : ?>
  <nav class="alert alert-danger alert-dismissible fade show col-md-10 offset-md-2 mt-3 error-wrapperLength" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    <h5 class="alert-heading">投稿にエラーがありました。</h5>
    <hr>
    <!-- メッセージ無記入エラー -->
    <?php if($error['message'] == 'blank' || $error['review'] == 'blank'): ?>
      <p>・無記入のままで投稿することはできません。</p>
    <?php endif; ?>
    <!-- 拡張子エラー -->
    <?php if($error['postpic'] == 'type'): ?>
      <p>・非対応の画像ファイルです。拡張子を確認ください。</p>
    <?php endif; ?>
    <!-- ビデオエラー -->
    <?php if($error['video'] == 'type'): ?>
      <p>・URLに誤りがあります。現状YouTube動画のみの対応となっています。</p>
      <p>　投稿例：https://www.youtube.com/watch?v=ABCDEFGHIJK</p>
      <p>　(URLの末尾がv=[動画のID]で終わるように投稿してください)</p>
    <?php endif; ?>
  </nav>
  <?php endif; ?>

  <!-- 
    ログインユーザーへの挨拶
   -->

  <nav class="userGreeting col-md-10 offset-md-2 pt-3">
    <div class="mobileUser-container">
      <?php 
      if($iconExt != 'jpeg' && $iconExt != '.png' && $iconExt != '.PNG'
      && $iconExt != 'JPEG' && $iconExt != '.gif' && $iconExt != '.jpg'
      && $iconExt != '.JPG' ): 
      ?>
        <img src="../member_picture/user.png" class="img-thumbnail mr-2">
      <?php else: ?>
        <img src="../member_picture/<?php echo h($member['picture']); ?>" class="img-thumbnail mr-2">
      <?php endif; ?>
      <span><b><?php echo $member['name'] ?></b>さん、こんにちは！</span>
    </div>
  </nav>


  <!-- 
   ユーザー投稿
   -->
  <?php foreach ($posts as $post) : ?>
  <?php if (empty($post['post_pic']) && empty($post['video']) ): ?>
  <main class="tweet-wrapper col-md-10 offset-md-2">
    <article class="container-fluid tweetContents">

      <!-- ユーザー名、post ID、投稿時間 -->
      <section class="container-fluid tweetContents-user">

        <div class="row">
          <div class="col-md-2 text-md-center">
          <?php 
            $iconExt = substr($post['picture'],-4);
            if ($iconExt != 'jpeg' && $iconExt != '.png' && $iconExt != '.PNG'
            && $iconExt != 'JPEG' && $iconExt != '.gif' && $iconExt != '.jpg'
            && $iconExt != '.JPG' ) : 
          ?>
            <img class="img-thumbnail" src="../member_picture/user.png">
            <?php else: ?>
              <img class="img-thumbnail" src="../member_picture/<?= h($post['picture']);?>">
            <?php endif; ?>
          </div>

          <div class="col-md-10">
            <span><b><?= h($post['name']); ?></b></span>
            <a href="view.php?id=<?= h($post['id']); ?>">Post ID:[<?= h($post['id']); ?>]</a>
            <br>
            <span><?= h($post['created']); ?></span>
          </div>
        </div>

      </section>
      
      <!-- 投稿内容 -->
      <section class="col-md-12 tweetContents-post">
        <?php if (!empty($post['title']) ) : ?>
        <h4 class="pb-1 mb-2"><?= h($post['title']); ?></h4>
        <?php endif; ?>

        <div class="col-md-12">
          <p><?= nl2br(makeLink(h($post['message']) ) ); ?></p>
          <div class="dotLine my-3 pt-3"></div>
        </div>
      </section>

      <!-- 投稿のリアクション -->

      <section class="container-fluid tweetContents-reaction pt-4">
        <h6 class="text-muted">投稿に対してリアクションしましょう</h6>

        <div class="row">
          <!-- コメントフォーム -->
          <div class="col-md-10">
            <form action="" method="post">
              <div class="form-group">
                <textarea name="review" id="commentForm" class="form-control" placeholder="コメントを記入する..."></textarea>
              </div>
              <button type="submit" class="btn btn-success btn-sm comment-postButton">コメントを送信</button>
            </form>
          </div>

          <div class="col-md-2">
            <!-- いいねボタン -->

            <?php $goodFlag = in_array($post['id'], $goodArray); ?>
            <?php if ($goodFlag) : ?>
              <a class="btn btn-danger btn-sm disabled" role="button" href="index.php?good=<?= h($post['id']); ?>">
                <i class="good fas fa-heart"></i> <?= h($post['good']); ?>
              </a>
            <?php else: ?>
              <a class="btn btn-outline-danger btn-sm" role="button" href="index.php?good=<?= h($post['id']); ?>">
                <i class="good fas fa-heart"></i> <?= h($post['good']); ?>
              </a>
            <?php endif; ?>

            <?php if ($_SESSION['id'] == $post['member_id']) : ?>
              <a class="btn btn-outline-primary btn-sm ml-1" role="button" href="delete.php?id=<?= h($post['id']); ?>">
                <i class="fas fa-trash"></i>
              </a>
            <?php endif; ?>

          </div>
        </div>

      </section>


    </article><!-- tweetContents -->
  </main><!-- tweet-wrapper -->

  <?php else: ?> <!-- if (empty($post['post_pic']) && empty($post['video']) ) -->

  <!-- 
   ユーザー投稿（画像ありver)
   -->
   <main class="tweet-wrapper col-md-10 offset-md-2">
    <article class="container-fluid tweetContents">

      <!-- ユーザー名、post ID、投稿時間 -->
      <section class="container-fluid tweetContents-user">

        <div class="row">
          <div class="col-md-2 text-md-center">
          <?php 
            $iconExt = substr($post['picture'],-4);
            if ($iconExt != 'jpeg' && $iconExt != '.png' && $iconExt != '.PNG'
            && $iconExt != 'JPEG' && $iconExt != '.gif' && $iconExt != '.jpg'
            && $iconExt != '.JPG' ) : 
          ?>
            <img class="img-thumbnail" src="../member_picture/user.png">
            <?php else: ?>
              <img class="img-thumbnail" src="../member_picture/<?= h($post['picture']);?>">
            <?php endif; ?>
          </div>

          <div class="col-md-10">
            <span><b><?= h($post['name']); ?></b></span>
            <a href="view.php?id=<?= h($post['id']); ?>">Post ID:[<?= h($post['id']); ?>]</a>
            <br>
            <span><?= h($post['created']); ?></span>
          </div>
        </div>

      </section>
      
      <!-- 投稿内容 -->

      <section class="col-md-12 tweetContents-post">
        <?php if (!empty($post['title']) ) : ?>
        <h4 class="pb-1 mb-2"><?= h($post['title']); ?></h4>
        <?php endif; ?>

        <div class="row">
          <!-- 投稿文章 -->
          <div class="col-md-6">
            <p><?= nl2br(makeLink(h($post['message']) ) ); ?></p>
            <div class="dotLine my-3 pt-3"></div>
          </div>

          <!-- 投稿コンテンツ -->
          <div class="col-md-6 tweetContents-media">
            <?php if (isset($post['video'])) : ?>
              <?php $v = substr($post['video'], -11); ?>
              <div class="embed-responsive embed-responsive-16by9">
                <iframe class="embed-responsive-item" src="<?= 'https://www.youtube.com/embed/'. h($v); ?>" allowfullscreen></iframe>
              </div>
            <?php endif; ?>

            <?php if (isset($post['post_pic']) ) : ?>
              <img src="../post_picture/<?= h($post['post_pic']); ?>" alt="postpicture" class="img-thumbnail">
            <?php endif; ?>
          </div>
        </div>

      </section>

      <!-- 投稿のリアクション -->

      <section class="container-fluid tweetContents-reaction pt-4">
        <h6 class="text-muted">投稿に対してリアクションしましょう</h6>

        <div class="row">
          <!-- コメントフォーム -->
          <div class="col-md-10">
            <form action="" method="post">
              <div class="form-group">
                <textarea name="review" id="commentForm" class="form-control" placeholder="コメントを記入する..."></textarea>
              </div>
              <button type="submit" class="btn btn-success btn-sm comment-postButton">コメントを送信</button>
            </form>
          </div>

          <div class="col-md-2">
            <!-- いいねボタン -->

            <?php $goodFlag = in_array($post['id'], $goodArray); ?>
            <?php if ($goodFlag) : ?>
              <a class="btn btn-danger btn-sm disabled" role="button" href="index.php?good=<?= h($post['id']); ?>">
                <i class="good fas fa-heart"></i> <?= h($post['good']); ?>
              </a>
            <?php else: ?>
              <a class="btn btn-outline-danger btn-sm" role="button" href="index.php?good=<?= h($post['id']); ?>">
                <i class="good fas fa-heart"></i> <?= h($post['good']); ?>
              </a>
            <?php endif; ?>

            <?php if ($_SESSION['id'] == $post['member_id']) : ?>
              <a class="btn btn-outline-primary btn-sm ml-1" role="button" href="delete.php?id=<?= h($post['id']); ?>">
                <i class="fas fa-trash"></i>
              </a>
            <?php endif; ?>

          </div>
        </div>

      </section>

    </article><!-- tweetContents -->
  </main><!-- tweet-wrapper -->

  <?php endif; ?> <!-- if (empty($post['post_pic']) && empty($post['video']) ) -->







  <!-- 
    投稿に対するコメント
   -->
  <?php
    $revPosts = $db->prepare('SELECT m.name, m.picture, r.* FROM members m, reviews r WHERE m.id = r.member_id AND post_id=?');
    $revPosts->execute(array($post['id']));
  ?>
  <?php foreach ($revPosts as $revPost) : ?>

  <main class="comment-wrapper container-fluid mt-4">
    <article class="col-md-9 offset-md-3 comment-border">
      <!-- コメント欄の吹き出し部分 --> 
      <div class="borderTriangle"></div>
      <div class="borderTriWhite"></div>

      <div class="row my-3">
        <div class="col-md-2 text-md-center">
          <img class="iconImg img-thumbnail" src="../member_picture/user.png">
        </div>

        <div class="col-md-10">
          <span class="font-weight-bold">Kirbis</span>
          <span>[2020-12-13 20:17:53]</span>
          <p>ダミーテキストです。ダミーテキストです。ダミーテキストです。ダミーテキストです。ダミーテキストです。ダミーテキストです。ダミーテキストです。ダミーテキストです。</p>
        </div>
      </div>

    </article>
  </main>
  <?php endforeach; ?> <!-- コメントに対してのforeach -->

  <?php endforeach; ?> <!-- 一つの投稿に対してのforeach -->






  <!-- 
    ページネーション
   -->

  <nav class="col-md-10 offset-md-2 page-wrapper" aria-label="ページネーション">
    <ul class="pagination">
      <?php if ($page > 1) : ?>
      <li class="page-item">
        <a class="page-link" href="index.php?page=<?= $page - 1 ?>">前</a>
      </li>
      <?php else: ?>
      <li class="page-item disabled">
        <a class="page-link">前</a>
      </li>
      <?php endif; ?>

      <li class="page-item">
        <a class="page-link" href="index.php">top</a>
      </li>

      <?php if ($page < $maxPage) : ?>
      <li class="page-item">
        <a class="page-link" href="index.php?page=<?= $page + 1 ?>">次</a>
      </li>
      <?php else: ?>
        <li class="page-item disabled">
          <a class="page-link">次</a>
        </li>
      <?php endif; ?>

    </ul>
  </nav>

  <!-- 
    フッタークレジット
   -->

  <footer class="col-md-10 offset-md-2 footer-credit mt-5">
    <p>©️2020-2021 skonishi.</p>
  </footer>


</div> <!-- container-fluid -->





<?php
include('../app/_parts/_footer.php');

?>