<?php
session_start();
require('../app/functions.php');

if ($_SESSION['thanks'] != 'true') {
  header('Location: http://localhost:8888/liko_201223/join/web/index.php');
  exit();
}

unset($_SESSION['thanks']);

include('../app/_parts/_header.php');

?>

<!-- HTML
--------------------------------------->

<section class="container check-wrapper mb-5">
  <h5 class="py-3 check-wrapperTitle">登録が完了しました。</h5>

  <div class="thanksText">
    <p>登録ありがとうございます。 Likoを是非お楽しみください！</p>
    <a class="btn btn-primary btn-sm mb-3" role="button" href="../../web/">
      <i class="fas fa-sign-in-alt mr-2"></i>ログイン画面へ
    </a>
  </div>
 
</section>


<?php
include('../app/_parts/_footer.php');
?>