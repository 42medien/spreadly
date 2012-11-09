function spreadly_check_button_visibility() {
  if (spreadly_checkvisible(spreadly_get_elements_by_class_name(document,'spreadly-button')[0])) {
    setTimeout(spreadly_show_ad, 1000);
  }
  window.onscroll = function() {
    if (spreadly_checkvisible(spreadly_get_elements_by_class_name(document,'spreadly-button')[0])) {
      setTimeout(spreadly_show_ad, 1000);
    }
  };
}

function spreadly_show_ad() {
  if (document.getElementById('spreadly-advertisement-container') == null) {
    var elm = spreadly_get_elements_by_class_name(document,'spreadly-button')[0];
    var url = elm.href;
    var position = elm.getAttribute("data-adlayer-position");
    var html_positon = "";
    var width = spreadly_ad_height;
    var height = spreadly_ad_width;
    
    if (position == "bottom") {
      position = "bottom";
      html_positon = "afterEnd";
    } else {
      position = "top";
      html_positon = "beforeBegin";
    }
    
    elm.insertAdjacentHTML(html_positon, '<div id="spreadly-advertisement-container"><div class="spreadly-advertisement spreadly-advertisement-'+position+'"><div><iframe src="http://##YIID_WIDGET_HOST##/api/demo_ad?url='+encodeURIComponent(url)+'" style="width:'+width+'px; height:'+height+'px;"></iframe><small class="spreadly-advertisement-disclaimer"><a href="http://spreadly.com" target="blank">Spreadly Advertisement</a>&nbsp;</small><small class="spreadly-advertisement-close"><a href="#" onclick="spreadly_close_advertisement(); return false;">close</a></small></div></div></div>');
  }  
}

function spreadly_pos_y(elm) {
  var test = elm, top = 0;

  while(!!test && test.tagName.toLowerCase() !== "body") {
    top += test.offsetTop;
    test = test.offsetParent;
  }

  return top;
}

function spreadly_viewport_height() {
  var de = document.documentElement;

  if(!!window.innerWidth) {
    return window.innerHeight;
  } else if( de && !isNaN(de.clientHeight) ) {
    return de.clientHeight;
  }
  return 0;
}

function spreadly_scroll_y() {
  if( window.pageYOffset ) {
    return window.pageYOffset;
  }
  return Math.max(document.documentElement.scrollTop, document.body.scrollTop);
}

function spreadly_checkvisible( elm ) {
  var vp = spreadly_viewport_height(), // Viewport Height
      st = spreadly_scroll_y(), // Scroll Top
      y = spreadly_pos_y(elm);
  return ((y < (vp + st)) && (y > st));
}

function spreadly_close_advertisement() {
  spreadly_set_cookie('spreadly_ad_layer', 'hide', 1440);
  holder = document.getElementById('spreadly-advertisement-container');
  while(holder.hasChildNodes()){
  	holder.removeChild(holder.lastChild);
  }
  return false;
}

if (!spreadly_check_cookie('spreadly_ad_layer')) {
  spreadly_check_button_visibility();
}