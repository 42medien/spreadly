/** 
 * @author http://www.unwrongest.com/projects/limit/ 
 * ATTENTION: don't update. did some fixes for ie in it (KM)
 * 
 **/
(function($){ 
     $.fn.extend({  
         limit: function(limit,element) {
      
      var interval, f;
      var self = $(this);
          
      $(this).focus(function(){
        interval = window.setInterval(substring,100);
      });
      
      $(this).blur(function(){
        clearInterval(interval);
        substring();
      });
      
      substringFunction = "function substring(){ var myval = $(self).val(); var mylength = myval.length; if(mylength > limit){$(self).val($(self).val().substring(0,limit));}";
      if(typeof element != 'undefined') {
        substringFunction += "if($(element).html() != limit-mylength){$(element).html((limit-mylength<=0)?'0':limit-mylength);}"
      }
      substringFunction += "}";
      
      eval(substringFunction);
      
      
      
      substring();
      
        } 
    }); 
})(jQuery);



