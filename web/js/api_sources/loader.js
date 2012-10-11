(function(w, d, s) {
  var head = d.getElementsByTagName("head")[0];
  // adds css
  var css = d.createElement('link');
  css.type = 'text/css'; css.rel = 'stylesheet';
  css.href = '##YIID_BUTTON_HOST##/css/v1/button.css';
  head.appendChild(css);

  function go(){
    var js, fjs = d.getElementsByTagName(s)[0], load = function(url, id) {
	    if (d.getElementById(id)) {return;}
	    js = d.createElement(s); js.src = url; js.id = id;
	    fjs.parentNode.insertBefore(js, fjs);
	  };
    load('##YIID_BUTTON_HOST##/js/v1/button.js', 'spreadly_button');
    load('##YIID_BUTTON_HOST##/js/v1/advertisement.js', 'spreadly_ads');
    load('##YIID_BUTTON_HOST##/css/v1/button.css', 'spreadly_css');
  }
  if (w.addEventListener) { w.addEventListener("load", go, false); }
  else if (w.attachEvent) { w.attachEvent("onload",go); }
} (window, document, 'script'));