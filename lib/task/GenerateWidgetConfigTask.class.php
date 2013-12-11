<?php
/**
 * controller to generate the controller static php-file
 *
 * @author Matthias Pfefferle
 */
class GenerateWidgetConfigTask extends sfBaseTask {
  /**
   * configures the controller
   */
  protected function configure() {
    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'statistics'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev')
    ));

    $this->namespace        = 'yiid';
    $this->name             = 'generate-widget-config';
    $this->briefDescription = 'generates the widget config';
    $this->detailedDescription = <<<EOF
The [GenerateController|INFO] task does things.
Call it with:

  [php symfony GenerateController|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array()) {
    // copy file
    $this->getFilesystem()->copy(sfConfig::get('sf_data_dir').'/deployment/raw_config.inc.php', sfConfig::get('sf_web_dir').'/w/like/inc/config.inc.php', array('override' => true));

    // replace wildcards
    $this->getFilesystem()->replaceTokens(sfConfig::get('sf_web_dir').'/w/like/inc/config.inc.php', '##', '##', array(
      'MONGO_HOST'    => sfConfig::get('app_mongodb_host'),
      'MONGO_DB' => sfConfig::get('app_mongodb_database_name'),
      'MONGO_STATS_DB'    => sfConfig::get('app_mongodb_database_name_stats'),
      'YIID_HOST' => sfConfig::get('app_settings_host'),
      'YIID_URL' => sfConfig::get('app_settings_url'),
      'YIID_WIDGET_HOST' => sfConfig::get('app_settings_widgets_host'),
      'YIID_WIDGET_URL' => sfConfig::get('app_settings_widgets_url'),
      'YIID_BUTTON_URL' => sfConfig::get('app_settings_button_url'),
      'IS_DEV' => sfConfig::get('app_settings_dev'),
      'COOKIE_NAME' => $options['env'] == 'prod' ? 'spread' : 'spread_'.$options['env'],
      'ENVIRONMENT' => $options['env'],
      'RELEASE_NAME' => sfConfig::get('app_release_name'),
      'TRACKING_PARAMS' => '"'.implode('","',sfConfig::get('app_settings_filtered_parameters')).'"'
    ));
  }
}
