/**
 * @nocombine statistics
 */

var EditInPlace = {
  
  aData:{},
  aElement: {},
  aCssId: '',
  aContent: '',
  aEvent: '',
  
  init: function(pEvent){
    //init the mouse-over-effects first
    EditInPlace.initEffects();
    //init the editinplace to a click
    if(pEvent == 'click') {
      EditInPlace.initByClick();      
    }
  },

  /**
   * show the edit-icon on mouseover
   * @author KM
   */  
  initEffects: function(){
    jQuery('.editinplaceclick').bind('mouseover.editicon', function() {
      jQuery(this).addClass('edit-img');
    });
    
    jQuery('.editinplaceclick').mouseout(function() {
      jQuery(this).removeClass('edit-img');
    });
  },   
  
  /**
   * bind the editinplace to a click
   * @author KM
   */
  initByClick: function(){
    debug.log("[EditInPlace][byClick]"); 
    jQuery('.editinplaceclick').unbind('click.editinplaceclick').bind('click.editinplaceclick', function() {
      var lElement = jQuery(this);
      EditInPlace.initEdit(lElement);
      return false;
    }); 
  },

  /**
   * inits the needed functions and vars to edit after event (click)
   * @author KM
   */  
  initEdit: function(pElement){
    debug.log("[EditInPlace][init]");
    //close first all opened edit-elements
    EditInPlace.close();
    //make the clicked element global
    EditInPlace.aElement = pElement;
    //get needed config from the data-attr of clicked element
    EditInPlace.aContent = jQuery(EditInPlace.aElement).html();
    //get the css-id of the clicked element
    EditInPlace.aCssId = jQuery(EditInPlace.aElement).attr('id');
    //parse the json of the data-attribute
    EditInPlace.initData();
    //show the needed form for editing
    EditInPlace.initFormField();
    //init a callback, if needed (specified in the data-attr of the clicked element)
    EditInPlace.initCallback();
    
    //EditInPlace.bindBodyClick();
  },
  
  initData: function(){
    debug.log("[EditInPlace][initData]");
    EditInPlace.aData = jQuery.parseJSON(jQuery(EditInPlace.aElement).attr('data-obj'));
  },
  
  /**
   * show the needed form for editing (currently: textfield or layer)
   * @author KM
   */    
  initFormField: function(){
    debug.log("[EditInPlace][initFormField]");
    //if edit-type = text: show a textfield
    if(EditInPlace.aData.type == 'text'){
      EditInPlace.setTextField(EditInPlace.aElement);
    } else if(EditInPlace.aData.type == 'layer') {
      //if edit-type = layer: show a layer
      jQuery.facebox({ ajax: EditInPlace.aData.action });
    } else {
      alert('Please specify an edit-type in the data-attr');
    }
  },

  /**
   * unbind hover and click-events for edit-elems (we need this, if a edit-field is shown)
   * @author KM
   */     
  unbindEffects: function(){
    //unbind the mouse-over edit-image
    jQuery(EditInPlace.aElement).removeClass('edit-img');    
    jQuery('#'+EditInPlace.aCssId).unbind('mouseover.editicon');
    //unbind the edit-click on a the opened edit-field
    jQuery('#'+EditInPlace.aCssId).unbind('click.editinplaceclick');  
  },
  
  /**
   * insert the textfield for editing
   * @author KM
   */   
  setTextField: function(){
    debug.log("[EditInPlace][setTextField]");  
    //take the current text inside of the elem to edit
    var lText = jQuery(EditInPlace.aElement).text();
    //make a new textfield and append the save-image to it
    //var lHtml = '<img src="/img/global/24x24/save.png" id="save-editin-place" />';
    var lHtml = '<label class="textfield-wht" id="editinplace-box"><span><input type="text" value="'+Utils.trim(lText)+'" id="editinplace_input" name="editinplace_input" class="wd100" /></span><img src="/img/global/24x24/save.png" id="save-editin-place" /></label>';
    //empty the edit-elem
    jQuery(EditInPlace.aElement).empty();
    // unbind the edit-effects
    EditInPlace.unbindEffects();
    //insert the textfield and the save-img into the edit-elem
    jQuery(lHtml).appendTo(EditInPlace.aElement);
    //and bind the save-event to the save-img
    EditInPlace.bindSaveClick();        
    EditInPlace.bindSaveKeypress();
  },
  
  /**
   * if the data-attr has a callback, we have to initialize it
   * @author KM
   */     
  initCallback: function(){
    debug.log("[EditInPlace][initCallback]"); 
    //does callback-method exist?
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
  
  /**
   * close all opened edit-fields
   * @author KM
   * @param string pContent
   */     
  close: function(pContent){
    debug.log("[EditInPlace][close]");  
    //check, if there is a edit field opend. if so: close all
    if(jQuery('#editinplace_input').is('*')){
      //if there is a given param pContent insert it into the edit-elem (this happens if the user saved a new value)
      if (pContent !== undefined) {
        //update given content
        jQuery(EditInPlace.aElement).empty();
        jQuery(EditInPlace.aElement).append(pContent);
      } else {
        //update with initial-content
        //update given content
        jQuery(EditInPlace.aElement).empty();
        jQuery(EditInPlace.aElement).append(EditInPlace.aContent);        
      }
    }
    //after closing init the effects and click event to the edit-elem
    EditInPlace.initEffects();
    EditInPlace.initByClick();
  },
  
  bindBodyClick: function() {
    debug.log("[EditInPlace][close]");  
    jQuery('body').bind('click', function(pEvent) {
        EditInPlace.close(EditInPlace.aContent);
      return false;
    });
  },
  
  /**
   * binds the events to save to the editor-elements
   * @author KM
   */   
  bindSaveClick: function(){
    debug.log("[EditInPlace][bindSaveClick]"); 
    //bind the click to the save-img in a opened edit-field
    jQuery('#save-editin-place').live('click', function(pEvent) {
      EditInPlace.doSave();
      return false;         
    });
  },
  
  /**
   * binds the events to save to the editor-elements
   * @author KM
   */   
  bindSaveKeypress: function(){
    debug.log("[EditInPlace][bindSaveKeypress]"); 
    jQuery('#editinplace_input').bind('keypress.savekeypress', function(pEvent){
      if(pEvent.keyCode == 13){
        EditInPlace.doSave();
      }
    });    
  },  
  
  /**
   * sends the request to the action specified in the data-attr of the edit-elem
   * @author KM
   */   
  doSave: function(){
    debug.log("[EditInPlace][doSave]");     
    var lValue = jQuery('#editinplace_input').val();
    var lParams = jQuery.parseJSON(EditInPlace.aData.params);
    //take the data from the data-attr
    var lData = {
        ei_kcuf: new Date().getTime(),
        input: lValue
    };
    jQuery.extend(lData, lParams);

    jQuery.ajax({
      type: "POST",
      url: EditInPlace.aData.action,
      dataType: "json",
      data: lData,        
      success: function (pResponse) {
        if(pResponse.success === true) {
          debug.log("[EditInPlace][successtrue]");  
          //if data are saved: insert the new content to the edit-elem and close the edit-field
          //EditInPlace.close(pResponse.content);
          EditInPlace.update(pResponse.cssid, pResponse.html);
          
        } else {
          //alert if there are validation-errors
          alert(pResponse.error);
          EditInPlace.close();
        }
      }
    });    
  },
  
  update: function(pCssId, pHtml) {
    debug.log('[editinplace][update]');
    //jQuery('#'+pCssId).empty();
    jQuery('#'+pCssId).replaceWith(pHtml);
    //after closing init the effects and click event to the edit-elem
    EditInPlace.initEffects();
    EditInPlace.initByClick();    
  }
};