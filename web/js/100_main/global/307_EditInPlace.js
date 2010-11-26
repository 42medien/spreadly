var EditInPlace = {
  
  aData:{},
  aElement: {},
  aContent: '',
  
  byClick: function(){
    jQuery('.editinplaceclick').live('click', function() {
      var lElement = jQuery(this);
      EditInPlace.init(lElement);
      return false;
    }); 
  },
  

  init: function(pElement){
    EditInPlace.close();
    EditInPlace.aElement = pElement;
    EditInPlace.aContent = jQuery(EditInPlace.aElement).html();
    EditInPlace.initData();
    EditInPlace.initFormField();
    EditInPlace.initCallback();
  
  },
  
  initData: function(){
    EditInPlace.aData = jQuery.parseJSON(jQuery(EditInPlace.aElement).attr('data-obj'));
  },
  
  initFormField: function(){
    if(EditInPlace.aData.type == 'text'){
      EditInPlace.setTextField(EditInPlace.aElement);
    }      
  },
  
  initCallback: function(){
    if(EditInPlace.aData.callback != "undefined"){
      var lCallback = EditInPlace.aData.callback;
      //explode the string between the dot
      var lArray = lCallback.split('.');
      //if the so called function exists
      if(typeof window[lArray[0]][lArray[1]] == 'function') {
        //call it and write the result to local var
        window[lArray[0]][lArray[1]]();  
      } 
    }
  },
  
  setTextField: function(){
    var lText = jQuery(EditInPlace.aElement).text();
    var lHtml = '<input type="text" value="'+lText+'" id="editinplace-input" name="editinplace-text" />';
    lHtml += '<img src="/img/global/chart.png"';
    jQuery(EditInPlace.aElement).empty();
    jQuery(EditInPlace.aElement).append(lHtml);
  },
  
  close: function(){
    if(jQuery('#editinplace-input').is('*')){
      jQuery(EditInPlace.aElement).empty();
      jQuery(EditInPlace.aElement).append(EditInPlace.aContent);
    }
  }
};