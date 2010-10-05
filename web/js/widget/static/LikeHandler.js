/**
 * @nocombine likepopup
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
      var lTarget = pEvent.target;
      var lTargetId = jQuery(lTarget).attr('id');
      if(lTargetId == 'static-dislike-button') {
        StaticLike.aAction = '/api/dislike';
        StaticLike.aCase = 'dislike';
      }
      
      var lServs = StaticLike.getServices();

      //var lNew = Utils.implode(',', lServs);
      var options = {
          url:       StaticLike.aAction,
          data: { ei_kcuf: new Date().getTime(), serv: Utils.implode(',', lServs) },
          type:      'GET',
          dataType:  'json',
          success:   StaticLike.showSuccess
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
      if(StaticLike.aCase == 'like') {
        StaticLike.markLiked();
      } else {
        StaticLike.markDisliked();
      }
    } else {
      jQuery('.error').remove();
      jQuery('#static-like-form').prepend('<p class="error">'+i18n.get('NO_SERVICES_ERROR')+'</p>');
    }
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