<?php
require('../app/functions.php');

include('../app/_parts/_header.php');

?>

<!-- HTML
--------------------------------------->

<section class="container check-wrapper">
  <h5 class="py-3 check-wrapperTitle">登録内容の確認</h5>

  <div class="check-form">
    <form action="" enctype="multipart/form-data" method="post">
      <input name="action" type="hidden" value="submit">
      <h5 class="py-3">ハンドルネーム</h5>
      <p><?php echo h($_SESSION['join']['name']); ?></p>
      <h5 class="py-3">メールアドレス</h5>
      <p><?php echo h($_SESSION['join']['email']); ?></p>
      <h5 class="py-3">パスワード</h5>
      <p>表示されません(暗号化されて格納されます)。</p>
      <h5 class="py-3">アイコン画像</h5><?php if($_SESSION['join']['image'] != $_SESSION['join']['time'].$defHash) :?><img class="iconImg" src="../member_picture/<?php echo h($_SESSION['join']['image']); ?>">
      <p><br>
      アイコンは画像の中心から切り抜かれます。</p><?php else: ?>
      <p>設定されていません。<br>
      デフォルトのアイコンが自動で設定されます。</p><?php endif; ?>
      <div class="check-buttons pb-3">
        <a class="btn btn-outline-primary btn-sm mr-5" role="button" href="index.php?action=rewrite">
          書き直す
        </a>
        <button class="btn btn-primary btn-sm" type="submit">登録する</button>
      </div>
    </form>
  </div>

</section>



<?php
include('../app/_parts/_footer.php');
?>