<?php
/**
 *  Configuration for Variables/Settings outside Symfony context
 *
 *
 * @author christian
 *
 */
class LikeSettings {
  const MONGO_HOSTNAME = '127.0.0.1';
  const MONGO_DATABASENAME = 'yiid_dev';
  const MONGO_STATS_DATABASENAME = 'yiid_stats_dev';

  const COOKIE_DOMAIN  = '.spread.local';
  const SF_SESSION_COOKIE  = 'spread_dev';
  const JS_POPUP_PATH = 'http://spread.local/';

  const DEV = 1;
  const ENVIRONMENT = 'dev';
  const RELEASE_NAME = 'dev';
  public static $TRACKING_PARAMS = array("spreadly","yiidit","zanpid","utm_source","utm_medium","utm_campaign","utm_content","at_xt","sms_ss");
}