/**
 * @combine likepopup
 */

var StaticLike = {
  
  aAction: "/api/like",
  aCase: "like",
    
  init: function() {
    debug.log('[StaticLike][init]');
    StaticLike.doSend();
  
  },
  
  doSend: function() {
    debug.log('[StaticLike][doSend]');    
    jQuery('#static-like-button, #static-dislike-button').live('click.staticlike', function(pEvent) { 
      
      OnLoadGrafic.showGrafic();
      var lTarget = null;
      var lTargetId = null;
      lTarget = pEvent.target;
      lTargetId = jQuery(lTarget).attr('id');
      if(lTargetId == 'static-dislike-button') {
        StaticLike.aAction = '/api/dislike';
        StaticLike.aCase = 'dislike';
      }
      
      jQuery('.popup_button').hide();
      
      var lServs = StaticLike.getServices();

      //var lNew = Utils.implode(',', lServs);
      var options = {
          url:       StaticLike.aAction,
          data: { ei_kcuf: new Date().getTime(), serv: Utils.implode(',', lServs) },
          type:      'GET',
          dataType:  'json',
          success:   function(pResponse) {
            jQuery('.popup_button').show();
            StaticLike.showSuccess(pResponse); 
          }
      };
      jQuery('#static-like-form').ajaxSubmit(options);    
    });

  },
  
  getServices: function() {
    var lServs = [];
    var lSerialize = jQuery('#static-like-form').serializeArray(); 
    for(var i=0; i<lSerialize.length; i++) {
      if(jQuery('#'+lSerialize[i].name).hasClass('serv-check')) {
        lServs.push(jQuery(lSerialize[i]).val());
      }        
    }
    
    return lServs;
  },
  
  showSuccess: function(pResponse) {
    debug.log('[StaticLike][showSuccess]');
    if(pResponse.success == true) {
      if(pResponse.statictype == 'deal') {
        StaticLike.markLiked();
        DealCoupon.markLiked(pResponse.html);
      } else {
        if(StaticLike.aCase == 'like') {
          StaticLike.markLiked();
          DealCoupon.markLiked();
        } else {
          StaticLike.markDisliked();
        }
      }
    } else {
      jQuery('.error').remove();
      jQuery('#static-like-form').prepend('<p class="error">'+i18n.get(pResponse.message)+'</p>');
    }
    OnLoadGrafic.hideGrafic();
  },
  
  markLiked: function() {
    jQuery('#static-like-form').remove();
    jQuery('#static-liked').show();
  },
  
  markDisliked: function() {
    jQuery('#static-like-form').remove();
    jQuery('#static-disliked').show();    
  }
};

var DealCoupon = {
  markLiked: function(pHtml) {
    jQuery('#so_right_view').after(pHtml);
  }    
    
};