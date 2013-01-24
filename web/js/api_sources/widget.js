function spreadly_init_widgets() {
  var widgets = spreadly_get_elements_by_class_name(document,'spreadly-widget');
  for (var i = 0; i < widgets.length; i++) {
    spreadly_init_widget(widgets[i]);
  }
}

function spreadly_init_widget(element) {
  element.text = "";
  element.innerHTML = "";
  
  element.insertAdjacentHTML('beforeEnd', '<iframe src="http://##YIID_WIDGET_HOST##/api/widget?url='+window.location.href+'" style="width:520px; height: 230px; border:0;" frameborder="0" scrolling="no" marginheight="0"></iframe>');
}

spreadly_init_widgets();