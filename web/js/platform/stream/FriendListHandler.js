var FriendListFilter = {
  init: function() {
    jQuery('#input-friend-filter').inputfilter({
      'listid': 'friends_active_list', 
      'action':'stream/get_contacts_by_sortname',
      'callback':'FriendListFilter.showFiltered'
    });
  },
  
  showFiltered: function(pResponse) {
    debug.log('showFiltered');
    var lResults = jQuery.parseJSON(pResponse.results);
    jQuery(lParent).empty(); 
    for(var i=0; i<lResults.length; i++){
      debug.log(lResults[i]);            
    }    
  }
}