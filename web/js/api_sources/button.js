/*
 * @nocombine test 
 */

function spreadly_init_buttons() {
  var buttons = document.getElementsByClassName('spreadly-button');
  for (var i = 0; i < buttons.length; i++) {
    spreadly_init_images(buttons[i]);
    spreadly_init_click_handler(buttons[i]);
  }
}
  
function spreadly_init_images(link) {
  link.text = "";
  link.innerHTML = "";
  link.insertAdjacentHTML('afterBegin', '<img src="##YIID_BUTTON_HOST##/img/button/28/std.png" alt="" class="spreadly-service-icon" />');
  link.insertAdjacentHTML('beforeEnd', '<img src="##YIID_BUTTON_HOST##/img/button/28/sl.png" alt="" class="spreadly-service-icon" />');
  link.insertAdjacentHTML('beforeEnd', '<iframe src="##YIID_BUTTON_HOST##/w/like/statistics.php" style="width: 0px; height: 0px; border:0;" frameborder="0" scrolling="no" marginheight="0" allowTransparency="true"></iframe>');
}
  
function spreadly_init_click_handler(link) {
  link.onclick = function () { spreadly_open_layer(link.href); return false; };
}
  
function spreadly_open_layer(url) {
  spreadly_insert_iframe(url);
  document.getElementById('spreadly-overlay').style.visibility = 'visible';
  return false;
}
    
function spreadly_insert_iframe(url) {
  document.getElementById("spreadly-iframe").insertAdjacentHTML('afterbegin', '<div class="spreadly-close-button" onclick="spreadly_close_layer(); return false;"><div class="spreadly-close-icon"></div></div><iframe src="http://##YIID_WIDGET_HOST##/?url='+url+'&iframe=1" style="width: 600px; height: 600px; border:0;" frameborder="0" scrolling="no" marginheight="0" allowTransparency="true"></iframe>');
  return false;
}

function spreadly_close_layer() {
  document.getElementById('spreadly-overlay').style.visibility = 'hidden';
  holder = document.getElementById('spreadly-iframe');
  while(holder.hasChildNodes()){
  	holder.removeChild(holder.lastChild);
  }
  return false;
}

function spreadly_init() {
  document.getElementsByTagName("body")[0].insertAdjacentHTML('beforeEnd', '<div id="spreadly-overlay" style="visibility: hidden;"><div id="spreadly-iframe"></div></div>');
  spreadly_init_buttons();
}

spreadly_init();