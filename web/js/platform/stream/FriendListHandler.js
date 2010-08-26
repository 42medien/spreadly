var FriendBox = {
  init: function() {
    debug.log("[FriendBox][init]");          
    FriendStreamFilter.init();
    FriendStreamInputFilter.init();
    FriendStream.init();
    FriendStreamCounter.init();
  },
  
  reset: function() {
    FriendStreamFilter.reset();
    FriendStreamInputFilter.reset();
    FriendStream.reset();
    FriendStreamCounter.reset();    
  }
};

var FriendStreamFilter = {
  
  aAllLink: {},
  aActiveLink: {},
  aAllLinkId: '',
  aActiveLinkId: '',
  
  init: function() {
    debug.log("[FriendStreamFilter][init]");        
    FriendStreamFilter.aAllLink = jQuery('#friends_all');
    FriendStreamFilter.aAllLinkId = jQuery(FriendStreamFilter.aAllLink).attr('id');
    FriendStreamFilter.aActiveLink = jQuery('#friends_active');  
    FriendStreamFilter.aActiveLinkId = jQuery(FriendStreamFilter.aActiveLink).attr('id');  
    
    FriendStreamFilter.bindClick();
  },
  
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
      
      FriendStreamFilter.updateCss(this.id);
      
      return false;
    });      
  },
  
  updateCss: function(pElemId) {
    jQuery.each(jQuery('#friend-filter-area .friend-filter-link'), function(i, val) {
      jQuery(this).css('text-decoration', 'none');
    });  
    jQuery('#'+pElemId).css('text-decoration', 'underline');    
  },
  
  reset: function() {
    jQuery.each(jQuery('#friend-filter-area .friend-filter-link'), function(i, val) {
      jQuery(this).css('text-decoration', 'none');
    });  
    jQuery(FriendStreamFilter.aActiveLink).css('text-decoration', 'underline');
  }
};

var FriendStreamInputFilter = {
  aInput: '',
  
  init: function() {
    if (typeof(document.friendlistfilterform) !=  "undefined"){
      document.friendlistfilterform.reset();
    }
    FriendStreamInputFilter.aInput = jQuery('#input-friend-filter');
      jQuery(FriendStreamInputFilter.aInput).toggleValue();
      jQuery(FriendStreamInputFilter.aInput).inputfilter({
        'parentid': 'friends_search_results', 
        'url':'stream/get_contacts_by_sortname',
        'callback': FriendStreamInputFilter.cbInputfilter
      });   
  },
  
  /**
   * callback function for the jquery.inputfilter-plugin initialized in FriendListFilter.init
   * updates the friendcounter
   * @author KM
   * @param object pResponse
   */
  cbInputfilter: function(pResponse) {
    FriendStreamFilter.reset();
    FriendStream.toggle('friends_search_results');
    FriendStreamCounter.update(pResponse.pCounter);
  },
  
  reset: function() {
    jQuery('#input-friend-filter').val(i18n.get('TYPE_NAME_TO_FILTER')); 
    jQuery(FriendStreamInputFilter.aInput).toggleValue();    
  }
};

var FriendStream = {
  aAllFriendList: {},
  aActiveFriendList: {},
  aSearchFriendList: {},
  
  init: function() {
    FriendStream.aAllFriendList = jQuery('#friends_all_list');
    FriendStream.aActiveFriendList = jQuery('#friends_active_list');
    FriendStream.aSearchFriendList = jQuery('#friends_search_results'); 
    jQuery(FriendStream.aAllFriendList).scrollPager({"url":"stream/get_active_friends"});
    jQuery(FriendStream.aActiveFriendList).scrollPager({"url":"stream/get_friends"});     
    jQuery(FriendStream.aSearchFriendList).scrollPager({"url":"stream/get_friends"});
  },
  
  toggle: function(pElemId, pList) {
    jQuery.each(jQuery('#photo_filter_box .friend-filter-list'), function(i, val) {
      jQuery(this).hide();
    }); 
    if(pList && pList === true) {
      jQuery('#'+pElemId+'_list').show();
    } else {
      jQuery('#'+pElemId).show();      
    }
  },
  
  reset: function() {
    jQuery.each(jQuery('#photo_filter_box .friend-filter-list'), function(i, val) {
      jQuery(this).hide();
    });  
    jQuery(FriendStream.aActiveFriendList).show();    
  }
    
};

var FriendStreamCounter = {
  aCount: 0,
  
  init: function() {
    FriendStreamCounter.aCount = jQuery('#friend-counter').text();
  },
  
  update: function(pCount) {
    jQuery('#friend-counter').text(pCount);
  },
  
  reset: function() {
    jQuery('#friend-counter').text(FriendStreamCounter.aCount);
  }
}