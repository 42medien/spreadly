GlobalRequest.bindClickByClass('photo_filter_box','stream_filter');
//GlobalRequest.bindClickByClass('all_networks_list','stream_filter');
GlobalRequest.bindClickByClass('main_nav_outer','main_filter', undefined, undefined, jQuery('#new_shares'));
GlobalRequest.bindClickByClass('main_stream_pager','main_filter');
GlobalRequest.bindClickByClass('new_shares', 'stream_item', undefined, undefined, jQuery('#content_supp'));
GlobalRequest.bindClickByClass('nav_shares_outer', 'detail_filter');

StreamItem.openWindow();

ItemDetail.loadFirst();

DataObjectPager.init('stream_pager_link','{"action":"stream/hot", "callback":"Stream.show", "page":"2", "css": "{\\"class\\":\\"whats_hot_active\\", \\"id\\":\\"main_nav_outer\\"}"}');

FriendBox.init();



var TYPE_NAME_TO_FILTER = "<?php echo __('Type name to filter...'); ?>";
var SHOW_ALL_FRIENDS = "<?php echo __('SHOW_ALL_FRIENDS')?>";
var SHOW_HOT_FRIENDS = "<?php echo __('SHOW_HOT_FRIENDS')?>";
var ACTIVE_FRIENDS = "<?php echo __('ACTIVE_FRIENDS')?>";
var ALL_FRIENDS = "<?php echo __('ALL_FRIENDS')?>";

i18n.init({
  "TYPE_NAME_TO_FILTER":"<?php echo __('Type name to filter...'); ?>"
});