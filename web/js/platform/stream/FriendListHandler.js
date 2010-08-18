/**
 * @combine platform
 */


/**
 * object to handle filters for the friendlist on the left sidebar
 * @author KM
 */
var FriendListFilter = {
  
  /**
   * inits the inputfilter
   * @author KM
   */
  init: function() {
    jQuery('#input-friend-filter').inputfilter({
      'parentid': 'friends_active_list', 
      'url':'stream/get_contacts_by_sortname',
      'callback': FriendListFilter.cbFilter
    });
  },
  
  /**
   * callback function for the jquery.inputfilter-plugin initialized in FriendListFilter.init
   * updates the friendcounter
   * @author KM
   * @param object pResponse
   */
  cbFilter: function(pResponse) {
    if(jQuery('#friends_active_list').css('display') == 'none') {
      ElementHandler.toggleTwoAreas('friends_active_list', 'friends_all_list');
      TextHandler.toggleById('all-friends-link', 'SHOW_ALL_FRIENDS', 'SHOW_HOT_FRIENDS');
      TextHandler.toggleById('active_friends_headline', 'ACTIVE_FRIENDS', 'ALL_FRIENDS');
    }
  }
};


/**
 * Object to handle the postload and toggle of the all-friend-list
 * @author KM
 */
var FriendList = {

  aPage: 1,    
    
  /**
   * inits the functions
   * @author KM
   */
  init: function() {
    FriendList.toggleLists();
    FriendList.loadMore();
  },
  
  /**
   * toggles between the hot and all-friends-list
   * @author KM
   */
  toggleLists: function() {
    debug.log("[FriendList][toggleLists]");      
    jQuery('#all-friends-link').live('click', function() {
      ElementHandler.toggleTwoAreas('friends_active_list', 'friends_all_list');
      TextHandler.toggleById('all-friends-link', 'SHOW_ALL_FRIENDS', 'SHOW_HOT_FRIENDS');
      TextHandler.toggleById('active_friends_headline', 'ALL_FRIENDS', 'ACTIVE_FRIENDS');
      return false;
    });
  },
  
  /**
   * scrollpager for the friendlist
   * @author KM
   */
  loadMore: function() {
    jQuery('#friends_all_list').bind('scroll', function() {
      var lElement = jQuery('#friends_all_list');
      var lPage = 1;
      
      var scrolltop = jQuery(lElement).attr('scrollTop');  
      var scrollheight = jQuery(lElement).attr('scrollHeight');  
      var windowheight = jQuery(lElement).attr('clientHeight');
      var scrolloffset = 0;
      
      if (scrolltop >= (scrollheight-(windowheight+scrolloffset))) {
        jQuery.ajax({
          type: "GET",
          url: 'stream/get_contacts_by_sortname',
          dataType: "json",
          data: {'sortname':'h', 'page': FriendList.aPage},
          success: function(pResponse) {
            jQuery(lElement).append(pResponse.html);
            FriendList.aPage++;
          }
        });        
      }      
    });
  }
};