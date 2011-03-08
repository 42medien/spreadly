<?php
/**
 * controller to generate the controller static php-file
 *
 * @author Matthias Pfefferle
 */
class GenerateControllerTask extends sfBaseTask {
  /**
   * configures the controller
   */
  protected function configure() {
    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'statistics'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('all', null, sfCommandOption::PARAMETER_NONE, 'Build all controller')
    ));

    $this->namespace        = 'yiid';
    $this->name             = 'generate-controller';
    $this->briefDescription = 'generates the app controller';
    $this->detailedDescription = <<<EOF
The [GenerateController|INFO] task does things.
Call it with:

  [php symfony GenerateController|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array()) {
    // generate all controllers
    if ($options['all']) {
      $dirs = sfFinder::type('dir')->maxdepth(0)->follow_link()->relative()->in(sfConfig::get('sf_apps_dir'));
      foreach ($dirs as $dir) {
        $this->generateController($dir, $options['env']);
      }
    // or a specific
    } else {
      $this->generateController($options['application'], $options['env']);
    }
  }

  protected function generateController($application, $env) {
    $app = $application;
    $env = $env;

    if ($env == 'dev' || $env == 'staging') {
      $debug = 'true';
    } elseif ($env == 'prod') {
      $debug = 'false';
    } else {
      throw new sfException(sprintf('Module "%s" does not exist.', $env));
    }

    // generate filename
    if ($app == 'statistics') {
      $indexName = 'index';
    } else {
      $indexName = $app;
    }

    // copy file
    $this->getFilesystem()->copy(sfConfig::get('sf_data_dir').'/deployment/raw_controller.php', sfConfig::get('sf_web_dir').'/'.$indexName.'.php', array('override' => true));

    // replace wildcards
    $this->getFilesystem()->replaceTokens(sfConfig::get('sf_web_dir').'/'.$indexName.'.php', '##', '##', array(
      'APP_NAME'    => $app,
      'ENVIRONMENT' => $env,
      'IS_DEBUG'    => $debug,
      'IP_CHECK'    => '',
    ));
  }
}
