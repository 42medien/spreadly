debug.log("Info [platform][js_init_stream.js.php]");

GlobalRequest.bindClickByClass('friends_active_list','stream_filter');
GlobalRequest.bindClickByClass('all_networks_list','stream_filter');
GlobalRequest.bindClickByClass('main_nav_outer','main_filter');
GlobalRequest.bindClickByClass('main_stream_pager','main_filter');
GlobalRequest.bindClickByClass('new_shares', 'stream_item');
GlobalRequest.bindClickByClass('nav_shares_outer', 'detail_filter');

DataObjectPager.init('stream_pager_link','{"action":"stream/hot", "callback":"Stream.show", "page":"2"}');
DataObjectPager.init('item-stream-pager-link');

FriendListFilter.init();