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

  const COOKIE_DOMAIN  = '.##YIID_HOST##';
  const SF_SESSION_COOKIE  = '##COOKIE_NAME##';

  const JS_POPUP_PATH = 'http://widgets.##YIID_HOST##/like';

  const JS_GETFRIENDS_PATH = 'http://widgets.##YIID_HOST##/widget/load_friends';

  const DEV = ##IS_DEV##;
  const ENVIRONMENT = '##ENVIRONMENT##';
  const RELEASE_NAME = '##RELEASE_NAME##';
}