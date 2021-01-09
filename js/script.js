// メインのscript.js
'use strict';

// input要素でenterを押してもsubmitされないようにする処理
{
  $(function(){
    $("input"). keydown(function(e) {
      if ((e.which && e.which === 13) || (e.keyCode && e.keyCode === 13)) {
        return false;
      } else {
        return true;
      }
    });
  });

  console.log('これはmainのindex.phpなどに適用するjsです');

}

{
  // hoge = basePic hoge2 = hidePic hage = modalBg ho = movingCenter
  var basePic = document.getElementsByClassName('basePic');
  var modalBg = document.getElementById('modalBg');
  var hidePic = document.getElementsByClassName('hidePic');
  var body =  document.getElementById('mainBody');
  var objectFit = document.getElementsByClassName('objectFit');

  //
  // 画像クリック時の動作
  //
  for (var i = basePic.length - 1; i >= 0; i--) {
    basePic[i].addEventListener("click", function() {

      // 中心に画像を表示するクラスを付属
      this.classList.toggle('movingCenter');
      
      // modal-backgroundをdisplay blockに
      modalBg.classList.toggle('d-none');
      
      // スクロールを防ぐ
      body.classList.toggle('modal-open');
      
      // objectFitを外す
      this.classList.toggle('objectFit');
      
      // tweetContentsが崩れないよう、元の位置に画像を配置する
      for (var j = hidePic.length - 1; j >= 0; j--) {
        hidePic[j].classList.toggle('d-none');
      }


    });
  }

  //
  // modal-backgroundをクリック時の動作
  //

  modalBg.addEventListener("click", function() {

    // modal-backgroundを閉じる
    modalBg.classList.add('d-none');

    // bodyのoverflowを取る
    body.classList.remove('modal-open');

    for (var i = basePic.length - 1; i >= 0; i--) {
      basePic[i].classList.remove('movingCenter');
      hidePic[i].classList.add('d-none');

      // basePicへのobjectFitを有効にする
      basePic[i].classList.add('objectFit');
    }


  });

}