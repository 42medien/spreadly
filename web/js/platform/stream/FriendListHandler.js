/**
 * @combine platform
 */
/**
 * class to handle the behaviour of the friendbox
 * @author KM
 */

var FriendBox = {
  /**
   * inits the functionalities of the friend-box beaviour
   * @author KM
   */
  init: function() {
    debug.log("[FriendBox][init]");          
    FriendStreamFilter.init();
    FriendStreamInputFilter.init();
    FriendStream.init();
    FriendStreamCounter.init();
    FilterHeadline.init();
  },
  
  /**
   * resets the friendsbox (state: active)
   * @author KM
   */
  reset: function() {
    debug.log("[FriendBox][reset]");         
    FriendStreamFilter.resetCss();
    FriendStreamInputFilter.reset();
    FriendStream.reset();
    FriendStreamCounter.reset();    
  }
};


/**
 * active/a-z filter-behavior
 * @author KM
 */
var FriendStreamFilter = {
  
  aAllLink: {},
  aActiveLink: {},
  aAllLinkId: '',
  aActiveLinkId: '',
  
  /**
   * inits the vars and events for clicking the filters
   * @author KM
   */
  init: function() {
    debug.log("[FriendStreamFilter][init]");        
    FriendStreamFilter.aAllLink = jQuery('#friends_all');
    FriendStreamFilter.aAllLinkId = jQuery(FriendStreamFilter.aAllLink).attr('id');
    FriendStreamFilter.aActiveLink = jQuery('#friends_active');  
    FriendStreamFilter.aActiveLinkId = jQuery(FriendStreamFilter.aActiveLink).attr('id');  
    
    FriendStreamFilter.bindClick();
  },
  
  /**
   * handles the click for filters
   * @author KM
   */
  bindClick: function() {
    debug.log("[FriendStreamFilter][bindClick]");          
    jQuery('#'+FriendStreamFilter.aAllLinkId+', #'+FriendStreamFilter.aActiveLinkId).live('click', function() {
      //toggle the lists
      FriendStream.toggle(this.id, true);
      //reset the stream
      GlobalRequest.initOnClick(this, {"action":"StreamSubFilter.getAction", "callback":"Stream.show"})
      //reset the counter
      FriendStreamCounter.reset();
      //reset textfield
      FriendStreamInputFilter.reset();
      //reset the highlighting of filters
      StreamSubFilter.resetCss();
      //reset the headlines
      FilterHeadline.updateCss('active_friends_headline');
      //reset the filters
      FriendStreamFilter.updateCss(this.id);
      
      return false;
    });      
  },
  
  /**
   * updates the css after a click
   * @author KM
   * @param string pElemId
   */
  updateCss: function(pElemId) {
    debug.log("[FriendStreamFilter][updateCss]");        
    jQuery.each(jQuery('#friend-filter-area .friend-filter-link'), function(i, val) {
      jQuery(this).removeClass('friend_filter_link_active');
    });  
    
    jQuery('#'+pElemId).addClass('friend_filter_link_active');    
  },
  
  /**
   * resets the css of the filters
   * @author KM
   */
  resetCss: function() {
    debug.log("[FriendStreamFilter][resetCss]");            
    jQuery.each(jQuery('#friend-filter-area .friend-filter-link'), function(i, val) {
      jQuery(this).removeClass('friend_filter_link_active');
    });  
    jQuery(FriendStreamFilter.aActiveLink).addClass('friend_filter_link_active'); 
  }
};

/**
 * handles the events and css of the headlines on the top of communities and friends
 * @author KM
 */
var FilterHeadline = {

  /**
   * init
   * @author KM
   */
  init: function() {
    debug.log("[FilterHeadline][init]");    
    FilterHeadline.reset();
  },
  
  /**
   * resets the boxes and the headlines onclick on box-headlines
   */
  reset: function() {
    debug.log("[FilterHeadline][reset]");     
    jQuery('#photo_filter_box .reset-filter').live('click', function() {
      //reset the stream
      GlobalRequest.initOnClick(this, {"action":"StreamSubFilter.getAction", "callback":"Stream.show"})
      //reset the counter
      FriendBox.reset();
      //reset the highlighting of filters
      StreamSubFilter.resetCss();
      var lParentId = jQuery(this).parent('p.filter_headline').attr('id'); 
      FilterHeadline.updateCss(lParentId);
      return false;
    });      
  },
  
  /**
   * updates the css of the headlines
   * @author KM
   * @param string pCssId
   */
  updateCss: function(pCssId) {
    debug.log("[FilterHeadline][updateCss]");         
    FilterHeadline.resetCss();    
    jQuery('#'+pCssId).addClass('filter_headline_active');
    jQuery('#'+pCssId+' .filter_chosen_icon').show();    
  },
  
  /**
   * updates the css of the headlines
   * @author KM
   */
  resetCss: function() {
    debug.log("[FilterHeadline][resetCss]");      
    jQuery('#photo_filter_box .filter_headline').removeClass('filter_headline_active');
    jQuery('#photo_filter_box .filter_chosen_icon').hide();    
  }
};

/**
 * Handles the functionality of the input-field
 * @author KM
 */
var FriendStreamInputFilter = {
  aInput: '',
  
  init: function() {
    debug.log("[FriendStreamInputFilter][init]");     
    FriendStreamInputFilter.resetCss();
    if (typeof(document.friendlistfilterform) !=  "undefined"){
      document.friendlistfilterform.reset();
    }
    
    FriendStreamInputFilter.aInput = jQuery('#input-friend-filter');
    FriendStreamInputFilter.initAutocomplete();
    jQuery(FriendStreamInputFilter.aInput).toggleValue();
    
    /*
    jQuery(FriendStreamInputFilter.aInput).blur(function(pEvent) {
      pEvent.bubbles = false;
      debug.log(pEvent.fromElement);
      FriendStreamInputFilter.reset();
      FriendStream.reset();      
    });*/

    /*
    jQuery(FriendStreamInputFilter.aInput).inputfilter({
      'parentid': 'friends_search_results', 
      'url':'stream/get_contacts_by_sortname',
      'callback': FriendStreamInputFilter.cbInputfilter,
      'delay': 750
    });   
    */
  },
  
  initAutocomplete: function() {
    jQuery(FriendStreamInputFilter.aInput).autocomplete({
      source: function(pRequest, pReponse) {
        jQuery.ajax({
          url: 'stream/get_contacts_by_sortname',
          data: pRequest,
          dataType: "json",
          type: "POST",
          success: function(data){
            var lCount = data.pop();
            FriendStreamCounter.update(lCount.count);
            debug.log(lCount.count);
            pReponse(data);
          }
        });      
      },
      dataType: "json",
      minLength: 1,
      open: function(event, ui) {
        FriendStream.toggle('friends_search_results');
        var lHeight = jQuery('.ui-autocomplete').height();
        jQuery('#result-container').height(lHeight+15);
      },
      select: function(event, ui) { 
        var item = ui.item;
        GlobalRequest.initOnClick(item, {'action': 'StreamSubFilter.getAction', 'callback': 'Stream.show', 'userid': item.id});
        FriendStreamFilter.resetCss();
        jQuery('#result-container').height(15);    
        FriendStream.reset();
        StreamSubFilter.updateCss("user-active-filter-"+item.id);
      }
    })      
    .data( "autocomplete" )._renderItem = function( ul, item ) {
      //debug.log(item);
      jQuery(ul).addClass('normal_list friend-filter-list');
      jQuery(ul).attr('id', 'friends_search_results');
      
      var lLink = jQuery('<a class="user_filter stream_filter">' + item.label +'</a>');
      jQuery(lLink).prepend(item.img);      
      return jQuery( '<li id="user-filter-'+item.id+'"></li>' )
        .data( "item.autocomplete", item )
        .append( lLink )
        .appendTo( ul );
    }; 
  },
  
  /**
   * callback function for the jquery.inputfilter-plugin initialized in FriendListFilter.init
   * updates the friendcounter
   * @author KM
   * @param object pResponse
   */
  cbInputfilter: function(pResponse) {
    debug.log("[FriendStreamInputFilter][cbInputfilter]");         
    FriendStreamFilter.resetCss();
    FriendStream.toggle('friends_search_results');
    FriendStreamCounter.update(pResponse.pCounter);
  },
  
  /**
   * empty the inputfield
   * @author KM
   */
  reset: function() {
    debug.log("[FriendStreamInputFilter][reset]");      
    jQuery('#input-friend-filter').val(i18n.get('TYPE_NAME_TO_FILTER')); 
    jQuery(FriendStreamInputFilter.aInput).toggleValue();    
  },
  
  /**
   * resets the css of headlines and filter
   * @author KM
   */
  resetCss: function() {
    debug.log("[FriendStreamInputFilter][resetCss]");        
    jQuery('#input-friend-filter').live('click', function() {
      FilterHeadline.updateCss('active_friends_headline'); 
      FriendStreamFilter.resetCss();
      if(jQuery('#input-friend-filter').val() == i18n.get('TYPE_NAME_TO_FILTER') || jQuery('#input-friend-filter').val() == ''){
        FriendStream.reset();
      }
      return true;
    });
  }
};

/**
 * the functionality of the friend-lists
 */
var FriendStream = {
  aAllFriendList: {},
  aActiveFriendList: {},
  aSearchFriendList: {},
  
  /**
   * init
   */
  init: function() {
    debug.log("[FriendStream][init]");         
    FriendStream.aAllFriendList = jQuery('#friends_all_list');
    FriendStream.aActiveFriendList = jQuery('#friends_active_list');
    FriendStream.aSearchFriendList = jQuery('#friends_search_results'); 
    jQuery(FriendStream.aAllFriendList).scrollPager({"url":"stream/get_active_friends"});
    jQuery(FriendStream.aActiveFriendList).scrollPager({"url":"stream/get_friends"});     
    //jQuery(FriendStream.aSearchFriendList).scrollPager({"url":"stream/get_contacts_by_sortname"});
  },
  
  /**
   * toggles the different boxes after clicking some filter
   * @author KM
   * @param string pElemId, object pList
   */
  toggle: function(pElemId, pList) {
    debug.log("[FriendStream][toggle]");     
    jQuery.each(jQuery('#photo_filter_box .friend-filter-list'), function(i, val) {
      jQuery(this).hide();
    }); 
    if(pList && pList === true) {
      jQuery('#'+pElemId+'_list').show();
    } else {
      jQuery('#'+pElemId).show();      
    }
  },
  
  /**
   * resets the list to state:active
   * @author KM
   */
  reset: function() {
    debug.log("[FriendStream][reset]");     
    jQuery.each(jQuery('#photo_filter_box .friend-filter-list'), function(i, val) {
      jQuery(this).hide();
    });  
    jQuery(FriendStream.aActiveFriendList).show();    
  }
    
};

/**
 * functionality of the friend-list-counter
 */
var FriendStreamCounter = {
  aCount: 0,
  
  init: function() {
    debug.log("[FriendStreamCounter][init]");     
    FriendStreamCounter.aCount = jQuery('#friend-counter').text();
  },
  
  update: function(pCount) {
    debug.log("[FriendStreamCounter][pCount]");         
    jQuery('#friend-counter').text(pCount);
  },
  
  reset: function() {
    debug.log("[FriendStreamCounter][reset]");             
    jQuery('#friend-counter').text(FriendStreamCounter.aCount);
  }
}