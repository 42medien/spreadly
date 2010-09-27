<?php
/**
 *  Configuration for Variables/Settings outside Symfony context
 *
 *
 * @author christian
 *
 */
class LikeSettings {
  const MONGO_HOSTNAME = 'donkeykong';
  const MONGO_DATABASENAME = 'yiid';
  const MONGO_STATS_DATABASENAME = 'yiid_stats';

  const WIDGET_USED_LIKE = 1;
  const WIDGET_USED_DISLIKE = -1;

  const COOKIE_DOMAIN  = '.yiid.com';
  const SF_SESSION_COOKIE  = 'yiid';

  const JS_LIKE_PATH =  'http://widgets.yiid.com/widget.php/api/like';
  const JS_DISLIKE_PATH =  'http://widgets.yiid.com/widget.php/api/dislike';

  const JS_POPUP_PATH = 'http://widgets.yiid.com/popup/signin';

  const JS_GETFRIENDS_PATH = 'http://widgets.yiid.local/widget/load_friends';
}