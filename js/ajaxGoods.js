$(function() {
  console.log('接続テスト');

  $('.contents-cancelGoodBtn').click(function() {
    var $likediv =$(this).parent("div");
    ccGB_postid = $(this).data('postid');
    ccGB_memberid = $(this).data('memberid');
    $ccGB_goodNumberSpace = $likediv.find('.ccGB_goodNumberSpace');
    $caGB_goodNumberSpace = $likediv.find('.caGB_goodNumberSpace');
    $ccGB_btn = $likediv.find('.contents-cancelGoodBtn');
    $caGB_btn = $likediv.find('.contents-addGoodBtn');

    console.log(ccGB_postid);
    
    $.post('../app/subGoods.php', {
      postid: ccGB_postid,
      memberid: ccGB_memberid,
    }, function(data){
      // $(this).find("span").html(data);
      // 1.親のdivの中のspanを探す 親=$likediv. 子はccGBとcaGBの2人
      // 上やめた クリックしたaの中の各クラスにデータセット

      $ccGB_goodNumberSpace.html(data);
      $caGB_goodNumberSpace.html(data);
      $ccGB_btn.toggleClass('d-none');
      $caGB_btn.toggleClass('d-none');
    });
  });

  $('.contents-addGoodBtn').click(function() {
    var $likediv =$(this).parent("div");
    caGB_postid = $(this).data('postid');
    caGB_memberid = $(this).data('memberid');
    $ccGB_goodNumberSpace = $likediv.find('.ccGB_goodNumberSpace');
    $caGB_goodNumberSpace = $likediv.find('.caGB_goodNumberSpace');
    $ccGB_btn = $likediv.find('.contents-cancelGoodBtn');
    $caGB_btn = $likediv.find('.contents-addGoodBtn');

    console.log(caGB_postid);

    $.post('../app/addGoods.php', {
      postid: caGB_postid,
      memberid: caGB_memberid,
    }, function(data){
      $ccGB_goodNumberSpace.html(data);
      $caGB_goodNumberSpace.html(data);
      $ccGB_btn.toggleClass('d-none');
      $caGB_btn.toggleClass('d-none');
    });
  });

    // $('.ccGB_goodNumberSpace').html(data);
    // $('.caGB_goodNumberSpace').html(data);

  // 今
  // 全てのコンテンツ投稿のいいねが共有された状態
  // これを個別にしたいわけ

});