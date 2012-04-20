var Spreadly = {
  initJS: function() {
      var lHead = document.getElementsByTagName("head")[0];
      var lScript = document.createElement('script');
      lScript.type = 'text/javascript';
      lScript.src = 'http://spreadly.local/js/100_main/include/buttonlist-dev.min.js';
      lScript.onload = Spreadly.initButton;
      lHead.appendChild(lScript);
    },
    
  initButton: function() {
    Spreadly.init();
  }
};

window.onload = function (){ 
  Spreadly.initJS();
};