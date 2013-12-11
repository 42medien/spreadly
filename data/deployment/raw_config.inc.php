<?php
/**
 *  Configuration for Variables/Settings outside Symfony context
 *
 *
 * @author christian
 *
 */
class LikeSettings {
  const MONGO_HOSTNAME = '##MONGO_HOST##';
  const MONGO_DATABASENAME = '##MONGO_DB##';
  const MONGO_STATS_DATABASENAME = '##MONGO_STATS_DB##';

  const COOKIE_DOMAIN  = '.##YIID_WIDGET_HOST##';
  const SF_SESSION_COOKIE  = '##COOKIE_NAME##';
  const JS_POPUP_PATH = '##YIID_WIDGET_URL##/';
  const BUTTON_URL = '##YIID_BUTTON_URL##';

  const DEV = ##IS_DEV##;
  const ENVIRONMENT = '##ENVIRONMENT##';
  const RELEASE_NAME = '##RELEASE_NAME##';
  public static $TRACKING_PARAMS = array(##TRACKING_PARAMS##);
}