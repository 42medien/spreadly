(function() {
  var head = document.getElementsByTagName("head")[0];
  // adds css
  var css = document.createElement('link');
  css.type = 'text/css';
  css.rel = 'stylesheet';
  css.href = '##YIID_BUTTON_HOST##/css/v1/button.css';
  head.appendChild(css);
  // adds button.js
  var s = document.createElement('script');
  s.type = 'text/javascript';
  s.src = '##YIID_BUTTON_HOST##/js/v1/button.js';
  head.appendChild(s);
  
  var a = document.createElement('script');
  a.type = 'text/javascript';
  a.src = '##YIID_BUTTON_HOST##/js/v1/advertisement.js';
  head.appendChild(a);
})();