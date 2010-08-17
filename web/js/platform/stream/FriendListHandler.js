var FriendListFilter = {
  init: function() {
    jQuery('#input-friend-filter').inputfilter({
      'parentid': 'friends_active_list', 
      'url':'stream/get_contacts_by_sortname',
      'callback': FriendListFilter.cbFilter
    });
  },
  
  cbFilter: function(pResponse) {
    debug.log(pResponse);
  }
};