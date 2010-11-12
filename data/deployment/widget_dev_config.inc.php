<?php
/**
 *  Configuration for Variables/Settings outside Symfony context
 *  Modify this file in buildconfig ONYL!!
 *
 * @author christian
 *
 */
class LikeSettings {
  const MONGO_HOSTNAME = 'donkeykong';
  const MONGO_DATABASENAME = 'yiid_dev';
  const MONGO_STATS_DATABASENAME = 'yiid_dev_stats';

  const WIDGET_USED_LIKE = 1;
  const WIDGET_USED_DISLIKE = -1;

  const COOKIE_DOMAIN  = '.yiiddev.com';
  const SF_SESSION_COOKIE  = 'yiiddev_com';


  const JS_LIKE_PATH =  'http://widgets.yiiddev.com/widget.php/api/like';
  const JS_DISLIKE_PATH =  'http://widgets.yiiddev.com/widget.php/api/dislike';

  const JS_POPUP_PATH = 'http://widgets.yiiddev.com/popup/signin';

  const JS_GETFRIENDS_PATH = 'http://widgets.yiiddev.com/widget/load_friends';

  const DEV = 1;
  const ENVIRONMENT = 'dev';
}