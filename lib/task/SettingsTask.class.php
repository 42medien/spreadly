<?php
/**
 * controller to generate the controller static php-file
 *
 * @author Matthias Pfefferle
 */
class SettingsTask extends sfBaseTask {
  /**
   * configures the controller
   */
  protected function configure() {
    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'platform'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('release-name', null, sfCommandOption::PARAMETER_REQUIRED, 'The releasename', 'local')
    ));

    $this->namespace        = 'yiid';
    $this->name             = 'set';
    $this->briefDescription = 'generates the widget config';
    $this->detailedDescription = <<<EOF
The [GenerateController|INFO] task does things.
Call it with:

  [php symfony GenerateController|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array()) {
    if ($options['env'] != "dev") {
      $file = sfConfig::get('sf_config_dir')."/app.yml";
      $content = file_get_contents($file);
      $content = preg_replace("/release_name:\s+'.+'/i", "release_name: '".$options['release-name']."'", $content);
      $this->logSection('set:release-name', $file);
      file_put_contents($file, $content);
    } else {
      throw new sfException(sprintf('You do not need to change the release-name on your %s-system', $options['env']));
    }
  }
}
