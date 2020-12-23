'use strict';

{
  function toggleIcon(plus, minus) {
    document.getElementById(plus).classList.toggle('circle');
    document.getElementById(plus).classList.toggle('skelton');
    document.getElementById(minus).classList.toggle('circle');
    document.getElementById(minus).classList.toggle('skelton');
  }

  // +と-を入れ替える処理
  document.getElementById('toggleIcon1').addEventListener('click', () => {
    toggleIcon('plus1','minus1');
  });

  document.getElementById('toggleIcon2').addEventListener('click', () => {
    toggleIcon('plus2','minus2');
  });
  
  document.getElementById('toggleIcon3').addEventListener('click', () => {
    toggleIcon('plus3','minus3');
  });

}







$(document).ready(function(){


});