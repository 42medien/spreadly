window.onload = function (){ 
  var head = document.getElementsByTagName("head")[0];
  // adds css
  var css = document.createElement('link');
  css.type = 'text/css';
  css.rel = 'stylesheet';
  css.href = '//spreadly.local/css/v1/button.css';
  head.appendChild(css);
  // checks if jquery is already in use
  if (typeof jQuery == 'undefined') {
    var j = document.createElement('script');
    j.type = 'text/javascript';
    j.src = '//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js';
    head.appendChild(j);
  }
  // adds button.js
  var s = document.createElement('script');
  s.type = 'text/javascript';
  s.src = '//spreadly.local/js/v1/button.js';
  head.appendChild(s);
};