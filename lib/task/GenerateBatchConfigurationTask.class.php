<?php
/**
 * controller to generate the controller static php-file
 *
 * @author Matthias Pfefferle
 */
class GenerateBatchConfigurationTask extends sfBaseTask {
  /**
   * configures the controller
   */
  protected function configure() {
    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'statistics'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev')
    ));

    $this->namespace        = 'yiid';
    $this->name             = 'generate-batch-config';
    $this->briefDescription = 'generates the batch config';
    $this->detailedDescription = <<<EOF
The [GenerateController|INFO] task does things.
Call it with:

  [php symfony GenerateController|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array()) {
    // copy file
    $this->getFilesystem()->copy(sfConfig::get('sf_data_dir').'/deployment/raw_BatchConfiguration.class.php', sfConfig::get('sf_config_dir').'/BatchConfiguration.class.php', array('override' => true));

    // replace wildcards
    $this->getFilesystem()->replaceTokens(sfConfig::get('sf_config_dir').'/BatchConfiguration.class.php', '##', '##', array(
      'ENV'    => $options['env']
    ));
  }
}
