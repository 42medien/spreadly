(function($){

  jQuery.fn.combo = function(pParams){

    var lListItems = undefined;
    lListItems = pParams.listitems;
    ComboInput.init(this);
    ComboList.init(lListItems);
    
    this.each(function(el) {
    });
    
    //return this;
    
  };   
  
  var ComboInput = {
      aInputObject: {},
      aInputId: '',
      init: function(pThis){
        ComboInput.aInputObject = pThis;    
        ComboInput.aInputId = jQuery(ComboInput.aInputObject).attr('id');
      },
      
      insertItem: function(pItem){
        jQuery(ComboInput.aInputObject).val(jQuery(ComboInput.aInputObject).val()+pItem+',');
      },
      
      removeItem: function(pItem) {
        var lVal = jQuery(ComboInput.aInputObject).val();
        
        //lVal.replace(pItem, '');
        jQuery(ComboInput.aInputObject).val(lVal.replace(new RegExp(pItem+',?',"gi"), ''));
      }
    };
    
  var ComboList = {
    
    aListObject: {},
    aListId: '',
    
    init: function(pListItems) {  
      ComboList.aListObject = jQuery('#'+ComboInput.aInputId+'-list'); 
      ComboList.aListId = jQuery(ComboList.aListObject).attr('id');
      if(pListItems !== undefined) {
        ComboList.addItemsByList(pListItems);
      } else {
        ComboList.addItemsByRemote();
      }
    },
      
    addItemsByList: function(pListItems) {
      console.log('[ComboList][addItemsByList]');
      var lItemsArray, lHtmlList='';
      
      lItemsArray = ComboUtils.explode(',', pListItems);
      for(var i=0; i<lItemsArray.length; i++){
        lHtmlList += '<li>'+lItemsArray[i]+'</li>';
      }
      jQuery(ComboList.aListObject).append(lHtmlList);
      ComboList.showList();
    },
    
    addItemsByRemote: function() {
      
    },
    
    showList: function() {
      console.log('[ComboList][showList]');        
      jQuery(ComboList.aListObject).show();
    }
      
  };
    
    var ComboUtils = {
      /**
       * splits an given string by given delimiter and returns the two parts as an array
       * @param string pDelimiter
       * @param string pString
       * @return array lCleanedArray
       */
      explode: function(pDelimiter, pString) {
        var lArray = pString.split(pDelimiter);
        var lCleanedArray = new Array();
        var lCounter = 0;

        for(var i = 0; i < lArray.length; i++) {
          var lCleaned = lArray[i].replace (/^\s+/, '').replace (/\s+$/, '');
          lCleaned = lCleaned.replace (new RegExp(pDelimiter, "i"), '');
          if(lCleaned != '') {
            lCleanedArray[lCounter] = lCleaned;
            lCounter++;
          }
        }
        return lCleanedArray;
      }
    };
  
  
})(jQuery);




 
  
  
 
