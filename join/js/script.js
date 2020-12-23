'use strict';

{

  document.getElementById('test').addEventListener('click', () => {
    document.getElementById('FAQplus').classList.toggle('circle');
    // document.getElementById('FAQplus').classList.toggle('d-none');
    document.getElementById('FAQplus').classList.toggle('skelton');

    document.getElementById('FAQminus').classList.toggle('circle');
    // document.getElementById('FAQminus').classList.toggle('d-none');
    document.getElementById('FAQminus').classList.toggle('skelton');

    // document.getElementById('answer').classList.toggle('d-none');

  });

}

{

  $('.toggle-btn').click(function() {
    $('.collapse').collapse('toggle');
  });

}

{
  // QAテスト！

  function toggleIcon(plus, minus) {
    document.getElementById(plus).classList.toggle('circle');
    document.getElementById(plus).classList.toggle('skelton');

    document.getElementById(minus).classList.toggle('circle');
    document.getElementById(minus).classList.toggle('skelton');

  }


  document.getElementById('test2').addEventListener('click', () => {
    toggleIcon('FAQplus2','FAQminus2');

    // document.getElementsByClassName('plus').classList.toggle('circle');
    // document.getElementsByClassName('plus').classList.toggle('skelton');
    
    // document.getElementsByClassName('minus').toggle('circle');
    // document.getElementsByClassName('minus').toggle('skelton');

    //クラスをつけて回せるようにする or 3つ全部idをつけて同じ処理 or 処理をfunctionにする★


    // document.getElementById('FAQplus2').classList.toggle('circle');
    // document.getElementById('FAQplus2').classList.toggle('skelton');

    // document.getElementById('FAQminus2').classList.toggle('circle');
    // document.getElementById('FAQminus2').classList.toggle('skelton');


  });

}







$(document).ready(function(){


});