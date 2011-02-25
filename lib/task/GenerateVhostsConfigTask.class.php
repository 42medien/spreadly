<?php

class GenerateVhostsConfigTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'platform'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      // add your own options here
    ));

    $this->namespace        = 'yiid';
    $this->name             = 'generate-vhosts';
    $this->briefDescription = 'Generates the vhosts config for Apache';
    $this->detailedDescription = <<<EOF
The [GenerateVhostsConfig|INFO] task does things.
Call it with:

  [php symfony GenerateVhostsConfig|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    $rawFile = sfConfig::get('sf_data_dir').'/deployment/vhosts_config/vhosts.config.raw';
    $generatedFile = sfConfig::get('sf_data_dir').'/deployment/vhosts_config/vhosts_'.$options['env'].'.config';
    
    $this->getFilesystem()->copy($rawFile, $generatedFile, array('override' => true));

    // replace wildcards
    $this->getFilesystem()->replaceTokens($generatedFile, '##', '##', array(
      'PLATFORM_HOST'           => sfConfig::get('app_settings_host'),
      'PLATFORM_HOST_REGEX'     => str_replace('.', '\.', sfConfig::get('app_settings_host')),
      'WIDGET_HOST'             => sfConfig::get('app_settings_widgets_host'),
      'WIDGET_HOST_REGEX'       => str_replace('.', '\.', sfConfig::get('app_settings_widgets_host')),
      'BLOG_HOST'               => sfConfig::get('app_settings_blog_host'),
      'OLD_PLATFORM_HOST'       => sfConfig::get('app_settings_old_platform_host'),
      'OLD_PLATFORM_HOST_REGEX' => str_replace('.', '\.', sfConfig::get('app_settings_old_platform_host')),
      'OLD_STATS_HOST'          => sfConfig::get('app_settings_old_stats_host'),
'OLD_STATS_HOST_REGEX'          => str_replace('.', '\.', sfConfig::get('app_settings_old_stats_host')),
    ));

  }
}
