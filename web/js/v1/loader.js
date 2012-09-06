window.onload = function () { 
  var head = document.getElementsByTagName("head")[0];
  // adds css
  var css = document.createElement('link');
  css.type = 'text/css';
  css.rel = 'stylesheet';
  css.href = '//spreadly.local/css/v1/button.css';
  head.appendChild(css);
  // adds button.js
  var s = document.createElement('script');
  s.type = 'text/javascript';
  s.src = '//spreadly.local/js/v1/button.js';
  head.appendChild(s);
};