/*
 * @nocombine test 
 */

function spreadly_init_buttons() {
  var buttons = spreadly_get_elements_by_class_name(document,'spreadly-button');
  for (var i = 0; i < buttons.length; i++) {
    spreadly_init_images(buttons[i]);
    spreadly_init_click_handler(buttons[i]);
  }
}
  
function spreadly_init_images(link) {
  link.text = "";
  link.innerHTML = "";
  var services = ["fb", "tw", "li"];
  var data_services = link.getAttribute("data-services");
  var data_counter = link.getAttribute("data-counter");
  var available_services = {"facebook":"fb","twitter":"tw","linkedin":"li","tumblr":"tm","xing":"xg","flattr":"ft"};
  
  if (data_services == "none") {
    services = [];
  } else if (data_services) {
    var data_services = data_services.split(",");
    
    if (typeof(data_services)=='object' && (data_services instanceof Array)) {
      services = [];
      for( var i=0; i<data_services.length; i++ ) {
        if (available_services.hasOwnProperty(data_services[i])) {
          services[services.length] = available_services[data_services[i]];
        }
      }
    }
  }
  
  for (var i=0; i<services.length; i++) {
    link.insertAdjacentHTML('beforeEnd', '<img src="##YIID_BUTTON_HOST##/img/button/28/'+services[i]+'.png" alt="" class="spreadly-service-icon" />');
  }
  
  link.insertAdjacentHTML('beforeEnd', '<img src="##YIID_BUTTON_HOST##/img/button/28/sl.png" alt="" class="spreadly-service-icon" />');

  if (data_counter == "none" || data_counter == null) {
    link.insertAdjacentHTML('beforeEnd', '<iframe src="##YIID_BUTTON_HOST##/w/like/statistics.php" style="width: 0px; height: 0px; border:0;" frameborder="0" scrolling="no" marginheight="0" allowTransparency="true"></iframe>');
  } else {
    link.insertAdjacentHTML('beforeEnd', '<iframe src="##YIID_BUTTON_HOST##/w/like/counter.php" style="width: 50px; height: 22px; border:0;" frameborder="0" scrolling="no" marginheight="0" allowTransparency="true"></iframe>');
  }
}
  
function spreadly_init_click_handler(link) {
  link.onclick = function () { spreadly_open_layer(link.href); return false; };
  return false;
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

function spreadly_get_elements_by_class_name(node,classname) {
	if (node.getElementsByClassName)
		return node.getElementsByClassName(classname);
	else {
    var a = [],
    re = new RegExp('\\b' + classname + '\\b'),
    els = node.getElementsByTagName("a"),
    l = els.length,
    i;

    for (i = 0; i < l; i += 1) {
      if (re.test(els[i].className)) {
        a.push(els[i]);
      }
    }
    return a;
  }
}

function spreadly_set_cookie(name, value, lifetime) {
  var date = new Date();
  date.setTime(date.getTime() + (lifetime*60*1000));
  document.cookie = name + '=' + encodeURIComponent(value) + '; path=/; expires=' + date.toGMTString() + ';';
}

function spreadly_get_cookie(name) {
  var all = document.cookie;
  if (all === "") {
    return null;
  }
  var list = all.split("; ");
  for (var i = 0; i < list.length; i++) {
    var cookie = list[i];
    var p = cookie.indexOf("=");
    var n = cookie.substring(0,p);
    var v = cookie.substring(p+1);
    
    if (n == name) {
      return decodeURIComponent(v);
    }
  }
  return null;
}

function spreadly_check_cookie(name) {
  if (spreadly_get_cookie(name)) {
    return true;
  } else {
    return false;
  }
}

function spreadly_delete_cookie(name) {
  spreadly_set_cookie(name, "", -1);
}

spreadly_init();