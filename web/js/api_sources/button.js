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
  link.insertAdjacentHTML('beforeEnd', '<iframe src="##YIID_BUTTON_HOST##/w/like/statistics.php" style="width: 0px; height: 0px; border:0;" frameborder="0" scrolling="no" marginheight="0" allowTransparency="true"></iframe>');
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

spreadly_init();