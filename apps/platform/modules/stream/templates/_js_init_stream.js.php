

GlobalRequest.bindClickByClass('friends_active_list','stream_filter');
GlobalRequest.bindClickByClass('friends_all_list','stream_filter');
GlobalRequest.bindClickByClass('all_networks_list','stream_filter');
GlobalRequest.bindClickByClass('main_nav_outer','main_filter');
GlobalRequest.bindClickByClass('main_stream_pager','main_filter');
GlobalRequest.bindClickByClass('new_shares', 'stream_item');
GlobalRequest.bindClickByClass('nav_shares_outer', 'detail_filter');

StreamItem.openWindow();

DataObjectPager.init('stream_pager_link','{"action":"stream/hot", "callback":"Stream.show", "page":"2"}');
DataObjectPager.init('item-stream-pager-link');

FriendListFilter.init();
FriendList.init();

jQuery('#input-friend-filter').toggleValue();

var SHOW_ALL_FRIENDS = "<?php echo __('SHOW_ALL_FRIENDS')?>";
var SHOW_HOT_FRIENDS = "<?php echo __('SHOW_HOT_FRIENDS')?>";
var ACTIVE_FRIENDS = "<?php echo __('ACTIVE_FRIENDS')?>";
var ALL_FRIENDS = "<?php echo __('ALL_FRIENDS')?>";