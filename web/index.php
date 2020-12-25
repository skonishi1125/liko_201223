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
          <input name="search" type="text" class="searchBox">
          <input type="submit" value="&#xf002;" class="fas searchIcon">
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
      <p class="userName"><?php echo h($member['name']); ?></p>
      <a class="openCommentModal btn btn-primary" role="button">投稿する</a>
    </div>
  
  </nav> <!-- leftFix-contents -->

  <!-- 
    エラーアラート
   -->

  <nav class="alert alert-danger alert-dismissible fade show col-md-10 offset-md-2 mt-3 error-wrapperLength" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    <h5 class="alert-heading">エラー見出し</h5>
    <hr>
    <p>エラーの内容です</p>
  </nav>

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

  <main class="tweet-wrapper col-md-10 offset-md-2">
    <article class="container-fluid tweetContents">

      <!-- ユーザー名、post ID、投稿時間 -->
      <section class="container-fluid tweetContents-user">

        <div class="row">
          <div class="col-md-2">
            <img class="img-thumbnail" src="../member_picture/user.png">
          </div>

          <div class="col-md-10">
            <nobr class="userName">かあビス</nobr>
            <a class="res-phone" href="view.php?id=">Post ID:[100]</a>
            <br>
            <nobr class="createTime res-phone">[2020-12-13 20:17:53]</nobr>
          </div>
        </div>

      </section>
      
      <!-- 投稿内容 -->

      <section class="col-md-12 tweetContents-post">
        <h4 class="pb-1 mb-2">タイトル</h4>

        <div class="col-md-12">
          <p>投稿メッセージです！！！！投稿メッセージです！！！！投稿メッセージです！！！！投稿メッセージです！！！！投稿メッセージです！！！！投稿メッセージです！！！！投稿メッセージです！！！！投稿メッセージです！！！！投稿メッセージです！！！！投稿メッセージです！！！！投稿メッセージです！！！！投稿メッセージです！！！！投稿メッセージです！！！！投稿メッセージです！！！！投稿メッセージです！！！！投稿メッセージです！！！！</p>
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
            <button class="btn btn-outline-danger btn-sm">
              <i class="good fas fa-heart"></i> 100
            </button>
            <button class="btn btn-outline-primary btn-sm ml-1">
              <i class="fas fa-trash"></i>
            </button>

          </div>
        </div>

      </section>


    </article><!-- tweetContents -->
  </main><!-- tweet-wrapper -->




  

  <!-- 
   ユーザー投稿（画像ありver)
   -->

   <main class="tweet-wrapper col-md-10 offset-md-2">
    <article class="container-fluid tweetContents">

      <!-- ユーザー名、post ID、投稿時間 -->
      <section class="container-fluid tweetContents-user">

        <div class="row">
          <div class="col-md-2">
            <img class="img-thumbnail" src="../member_picture/user.png">
          </div>

          <div class="col-md-10">
            <nobr class="userName">かあビス</nobr>
            <a class="res-phone" href="view.php?id=">Post ID:[100]</a>
            <br>
            <nobr class="createTime res-phone">[2020-12-13 20:17:53]</nobr>
          </div>
        </div>

      </section>
      
      <!-- 投稿内容 -->

      <section class="col-md-12 tweetContents-post">
        <h4 class="pb-1 mb-2">タイトル</h4>

        <div class="col-md-12">
          <p>投稿メッセージです！！！！投稿メッセージです！！！！投稿メッセージです！！！！投稿メッセージです！！！！投稿メッセージです！！！！投稿メッセージです！！！！投稿メッセージです！！！！投稿メッセージです！！！！投稿メッセージです！！！！投稿メッセージです！！！！投稿メッセージです！！！！投稿メッセージです！！！！投稿メッセージです！！！！投稿メッセージです！！！！投稿メッセージです！！！！投稿メッセージです！！！！</p>
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
            <button class="btn btn-outline-danger btn-sm">
              <i class="good fas fa-heart"></i> 100
            </button>
            <button class="btn btn-outline-primary btn-sm ml-1">
              <i class="fas fa-trash"></i>
            </button>

          </div>
        </div>

      </section>


    </article><!-- tweetContents -->
  </main><!-- tweet-wrapper -->


</div> <!-- container-fluid -->





<?php
include('../app/_parts/_footer.php');

?>