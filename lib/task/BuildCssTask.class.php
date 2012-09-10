<?php

require_once(dirname(__FILE__).'/../../lib/vendor/Minify_CSS_Compressor.php');

class BuildCssTask extends sfBaseTask
{
  protected function configure()
  {
    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'statistics'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      // add your own options here
    ));

    $this->namespace        = 'yiid';
    $this->name             = 'build-css';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [BuildCss|INFO] task does things.
Call it with:

  [php symfony BuildCss|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    $configuration = ProjectConfiguration::getApplicationConfiguration($options['application'], $options['env'], true);

    $this->getFilesystem()->mkdirs('web/css/include');

    // the path to the directory we want to combine and minify
    $lDir = dirname(__FILE__).'/../../web/css';

    //generate the filenames by the current release-entry in the app.yml
    $lFileName = sfConfig::get('app_release_name').'.css';
    $lFileMinName = sfConfig::get('app_release_name').'.min.css';
    //initialize the combine and minify-process
    $this->writeWholeFile($lDir,$lFileName,$lFileMinName);
    
    $this->buildApiCss();
  }

  /**
   * Initializes the combine and minify-processes
   *
   * @param string $pDir
   * @param string $pFileName
   * @param string $pFileMinName
   */
  private function writeWholeFile($pDir, $pFileName, $pFileMinName) {
    //we get all Files we want to combine
    $lFiles = FilesystemHelper::retrieveFilesInDir($pDir, array('.svn', 'include', 'tiny_mce', 'widget', 'engineroom'), array($pFileName, $pFileMinName), '.css');

    //we combine the Files to one file named by given filename and save it in the include-folder
    $this->combineFiles($lFiles, $pFileName);
    //we minify the combined file and save it in the include-folder by given fileminname
    $lCssMin = Minify_CSS_Compressor::process(file_get_contents(dirname(__FILE__).'/../../web/css/include/'.$pFileName));
    $lCssMinFile = fopen(dirname(__FILE__).'/../../web/css/include/'.$pFileMinName, 'w+');
    $lDone = fwrite($lCssMinFile, $lCssMin);
    fclose($lCssMinFile);
    echo "build css-File: ".$pFileMinName;
    echo "\n\r";
  }


  /**
   * Combines the Files from the given array to on file, named by given filename
   *
   * @param array $pFiles
   * @param string $pFileName
   */
  private function combineFiles($pFiles, $pFileName) {
    //build a new combine-file named by given filename and open it
    $lWholeFile = fopen(dirname(__FILE__).'/../../web/css/include/'.$pFileName, 'w+');
    //foreach about all files we wanna combine
    foreach($pFiles as $lMyFile) {
      //no we get the content of the current-file as an array (every line = one field in the array)
      $lArray = file($lMyFile);
      //if the first line in the file has the comment /*NOCOMBINE*/, do nothing -> we don't want the file in the combine
      if(trim(chop($lArray[0])) == '/*NOCOMBINE*/') {
        continue;
      } else {
        //if there is no /*NOCOMBINE*/ - Comment, get the content of the file as a string and write it at the end of the combine-file
        $lContent = file_get_contents($lMyFile);
        $lDone = fwrite($lWholeFile, $lContent);
      }
    }
    // at least, close the new combine-file
    fclose($lWholeFile);
  }
  
  private function buildApiCss() {
    // copy file
    $this->getFilesystem()->copy(sfConfig::get('sf_web_dir').'/css/api_sources/button.css', sfConfig::get('sf_web_dir').'/css/v1/button.css', array('override' => true));

    // replace wildcards
    $this->getFilesystem()->replaceTokens(sfConfig::get('sf_web_dir').'/css/v1/button.css', '##', '##', array(
      'YIID_WIDGET_HOST' => sfConfig::get('app_settings_widgets_host'),
      'YIID_BUTTON_HOST' => sfConfig::get('app_settings_button_url')
    ));
    
    $lCssMin = Minify_CSS_Compressor::process(file_get_contents(sfConfig::get('sf_web_dir').'/css/v1/button.css'));
    $lCssMinFile = fopen(sfConfig::get('sf_web_dir').'/css/v1/button.css', 'w+');
    $lDone = fwrite($lCssMinFile, $lCssMin);
    fclose($lCssMinFile);
  }
}
