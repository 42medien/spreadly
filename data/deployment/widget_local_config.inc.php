<?php
/**
 *  Configuration for Variables/Settings outside Symfony context
 *
 *
 * @author christian
 *
 */
class LikeSettings {
  const MONGO_HOSTNAME = 'localhost';
  const MONGO_DATABASENAME = 'yiid';
  const MONGO_STATS_DATABASENAME = 'yiid_stats';

  const WIDGET_USED_LIKE = 1;
  const WIDGET_USED_DISLIKE = -1;

  const COOKIE_DOMAIN  = '.yiid.local';
  const SF_SESSION_COOKIE  = 'yiid_local';


  const JS_LIKE_PATH =  'http://widgets.yiid.local/api/like';
  const JS_DISLIKE_PATH =  'http://widgets.yiid.local/api/dislike';

  const JS_POPUP_PATH = 'http://widgets.yiid.local/popup/settings';

  const JS_GETFRIENDS_PATH = 'http://widgets.yiid.local/widget/load_friends';
}