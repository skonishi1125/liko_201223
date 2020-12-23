<?php
// require('../app/functions.php');

include('../app/_parts/_header.php');

?>

<!-- HTML
--------------------------------------->
<header class="container-fluid">
  <div class="row header-bar">

    <div class="header-barLogo">
      <a href="index.php">
        <img src="../img/yellowLogo.png" alt="Liko" class="header-barLogo ml-4 py-1">
      </a>
    </div>

    <ul class="header-barButtons">
      <li>
        <a href="index.php" class="btn btn-primary btn-sm"><i class="fas fa-user-plus"></i>登録する</a>
      </li>
      <li>
        <a class="btn btn-primary btn-sm" href=""><i class="fas fa-sign-in-alt"></i>ログイン</a>
      </li>
      <li>
        <a class="btn btn-success btn-sm" href=""><i class="fas fa-sign-in-alt"></i>お試しログイン</a>
      </li>
    </ul>

  </div> <!-- row header-bar -->

  <div class="row header-wrapper">
    <div class="header-wrapperLogo">
      <img src="../img/whiteLogo.png" alt="Liko">
      <p>スキを共有しましょう</p>
    </div>
  </div>

  <div class="row header-wrapperRegister">

    <form class="mt-2 ml-3" action="" method="post" enctype="multipart/form-data">

      <h5 class="py-2"><b>登録しよう</b></h5>

      <!-- ユーザー名 -->
      <div class="form-group">
        <label for="user"><b>ユーザー名</b></label>
        <input id="user" type="text" class="form-control" placeholder="test">
      </div>

      <!-- メールアドレス -->
      <div class="form-group">
        <label for="email"><b>メールアドレス</b></label>
        <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="sample@gmail.com">
        <small id="emailHelp" class="form-text text-muted mb-2">ログイン情報としてのみ利用します。</small>

      <!-- パスワード -->
      <div class="form-group">
        <label for="password"><b>パスワード</b></label>
        <input name="password" type="password" class="form-control" id="password" aria-describedby="passHelp" placeholder="****">
        <small id="passHelp" class="form-text text-muted">4文字以上としてください。</small>
      </div>

      <!-- アイコン画像 -->
      <div class="form-group">
        <span class="badge badge-primary">任意</span>
        <label for="image"><b>アイコン画像を選択</b></label>
        <input name="image" type="file" class="form-control-file" id="image" aria-describedby="imageHelp">
        <small id="imageHelp" class="form-text text-muted">
          登録後に再設定が可能です。<br>
          未記入の場合、デフォルト画像が設定されます。<br>
          画像の拡張子は「.jpg」「.png」「.gif」が設定可能です。
        </small>
      </div>

      <button type="submit" class="btn btn-primary btn-sm float-right">入力内容を確認する</button>

    </div>

    </form>

  </div> <!-- row header-wrapperRegister -->
</header>

<section class="container intro-container pb-5">
  <div class="intro-centerBar pt-3"></div>
  <h4 class="my-3"><b>Likoとは</b></h4>

  <div class="row">
    
    <div class="col-md-8">
      <img src="../img/intro1.png" alt="intro1">
    </div>

    <div class="col-md-4 intro-containerMessages">
      <p>Likoでは様々な人たちが「スキ」だと感じたことについての投稿を確認できます。</p>
      <p>自分の好きなものを投稿して、感想を語り合うことも可能です。</p>
      <p>好きな場所や動画、食べ物だけでなくキャラクターや有名人など、投稿する内容はユーザーの自由です。<br>プチブログのような使い方も。</p>
    </div>

  </div>

</section>

<section class="intro-container pb-5 intro-containerBg">
  <div class="intro-centerBar pt-3 border-white"></div>
  <h4 class="my-3"><b>できること</b></h4>

  <div class="container">
    
    <div class="row">
      
      <div class="col-md-4 intro-containerMessages">
        <p>自分の好みの投稿に「いいね！」したり、コメントをつけることができます。</p>
        <p>また、自分と同じものが好きな人を探すことができる検索機能、プロフィールアイコンの変更機能なども。</p>
        <br>
        <p>自分の好きなものについて、ユーザーと語り合いましょう！</p>
      </div>
  
      <div class="col-md-8">
        <img src="../img/intro2.png" alt="intro1">
      </div>

    </div>

  </div>

</section>

<section class="container intro-container pb-5">
  <div class="intro-centerBar pt-3"></div>
  <h4 class="my-3"><b>FAQ</b></h4>

  <div class="row">

    <div class="col-md-12 intro-containerFAQ">

      <h5 class="py-3" id="test">
        <b class="ml-3">このサイトについて</b>
        <i class="fas fa-plus mr-3" id="FAQplus"></i>
        <i class="fas fa-minus mr-3 skelton" id="FAQminus"></i>
      </h5>

      <div class="intro-containerFAQAnswer mt-4" id="answer">
        <p>ポートフォリオ用のSNSサイトとなります。</p>
        <p>突然メンテナンスを行ったり、サービスが停止することがございます。ご了承ください。</p>
      </div>

    </div>

  </div>

</section>

<!-- sampleというidの中でくくりができる -->
<section id="sample">

  <div class="intro-containerFAQ">
    <h5 data-toggle="collapse" href="#collapseContent01" role="button" aria-expanded="false" aria-controls="collapseContent01" id="test2" class="py-2">
      <b class="ml-3">このサイトについて</b>
      <i class="fas fa-plus mr-3 plus" id="FAQplus2"></i>
      <i class="fas fa-minus mr-3 skelton minus" id="FAQminus2"></i>
    </h5>
    <div class="collapse" id="collapseContent01">
      <div class="card card-body my-4">コンテンツその１</div>
    </div>
  </div>



  <div class="intro-containerFAQ">
    <h5 data-toggle="collapse" href="#collapseContent02" role="button" aria-expanded="false" aria-controls="collapseContent02" id="test2" class="py-2">
      <b class="ml-3">エラー発生時</b>
      <i class="fas fa-plus mr-3 plus"></i>
      <i class="fas fa-minus mr-3 skelton minus"></i>
    </h5>
    <div class="collapse" id="collapseContent02">
      <div class="card card-body my-4">コンテンツその2</div>
    </div>
  </div>


  
  
  <!-- <div class="intro-containerFAQ">
    <p>
      <a class="btn btn-primary" data-toggle="collapse" href="#collapseContent02" role="button" aria-expanded="false" aria-controls="collapseContent02">ボタン2</a>
    </p>
    <div class="collapse" id="collapseContent02" data-parent="#sample">
      <div class="card card-body">コンテンツその2</div>
    </div>
  </div>
  
  <div class="intro-containerFAQ">
    <p>
      <a class="btn btn-primary" data-toggle="collapse" href="#collapseContent03" role="button" aria-expanded="false" aria-controls="collapseContent03">ボタン3</a>
    </p>
    <div class="collapse" id="collapseContent03" data-parent="#sample">
      <div class="card card-body">コンテンツその3</div>
    </div>
  </div> -->

</section>








<section class="container intro-container pb-5">
  <div class="intro-centerBar pt-3"></div>
  <h4 class="my-3"><b>はじめてみよう</b></h4>

  <div class="row">

  </div>
  
</section>

<section class="container intro-container pb-5">
  <div class="intro-centerBar pt-3"></div>
  <h4 class="my-3"><b>製作者プロフィール</b></h4>

  <div class="row">
    
  </div>

  <button class="btn btn-primary">Topへ戻る</button>
  
</section>

<footer class="py-2">
  <div class="footer-logo">
    <img src="../img/whiteLogo.png" alt="liko" class="mt-2">
  </div>
  <div class="footer-container">
    <p>2020-2021 ©︎Satoru Konishi.</p>
  </div>
</footer>



<?php
include('../app/_parts/_footer.php');
?>