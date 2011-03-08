<?php

require_once(dirname(__FILE__).'/../../lib/vendor/jsmin.php');

class BuildJsTask extends sfBaseTask
{
  protected function configure()
  {
    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'statistics'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      // add your own options here
    ));

    $this->namespace        = 'yiid';
    $this->name             = 'build-js';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [BuildJs|INFO] task does things.
Call it with:

  [php symfony BuildJs|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    $configuration = ProjectConfiguration::getApplicationConfiguration($options['application'], $options['env'], true);

    $this->getFilesystem()->mkdirs('web/js/100_main/include');

    // the path to the directory we want to combine and minify
    $lDir = dirname(__FILE__).'/../../web/js';

    //generate the filenames by the current release-entry in the app.yml
    $lFileName = sfConfig::get('app_release_name').'.js';
    $lFileMinName = sfConfig::get('app_release_name').'.min.js';
    //initialize the combine and minify-process
    $this->writeWholeFile($lDir,$lFileName,$lFileMinName);
  }

  /**
   * Initializes the combine and minify-processes
   *
   * @param string $pDir
   * @param string $pFileName
   * @param string $pFileMinName
   */
  private function writeWholeFile($pDir, $pFileName, $pFileMinName) {

  	$lFiles = FilesystemHelper::retrieveFilesInDir(dirname(__FILE__).'/../../web/js/100_main/include/', array('.svn'), array(), '.js');
    foreach($lFiles as $lFile) {
    	unlink($lFile);
    }

    //we get all Files we want to combine
    $lFiles = FilesystemHelper::retrieveFilesInDir($pDir, array('.svn', 'include', 'tiny_mce'), array(), '.js');
    //writes the current needed consolelog-file to the beginning of all scripts
    //$lFiles = handleConsoleLog($pDir, $lFiles);
    //we combine the Files to one file named by given filenname and save it in the include-folder
    $this->combineFiles($lFiles, $pFileName);
    //we minify the combined file and save it in the include-folder by given fileminname
    $this->minifyFiles(dirname(__FILE__).'/../../web/js/100_main/include/');
    //echo "build js-File: ".$pFileMinName;
    //echo "\n\r";
  }


  /**
   * Combines the Files from the given array to on file, named by given filename
   *
   * @param array $pFiles
   * @param string $pFileName
   */
  private function combineFiles($pFiles, $pFileName) {

  	//foreach about all files we wanna combine
    foreach($pFiles as $lMyFile) {
    	//now we get the content of the current-file as an array (every line = one field in the array)
    	$lArray = file($lMyFile);
      //var_dump(trim(chop($lArray[0])));die();
    	foreach($lArray as $lKey => $lValue) {
    		//remove all spaces
    		$lValue = trim(chop(str_replace(" ", "", $lValue)));

    		//if(sfConfig::get('app_settings_dev') == false && strpos($lValue, 'debug.log') !== false) {
    		if(strpos($lValue, 'debug.log') !== false) {
    			unset($lArray[$lKey]);
    		}

    		//if there is a @combine in the file
    		if(strpos($lValue, '*@combine') !== false) {
    			//build the current set filename
    			$lNewName = str_replace('*@combine', "", $lValue).'-'.$pFileName;
    			//open or build the file with the new name
          $lWholeFile = fopen(dirname(__FILE__).'/../../web/js/100_main/include/'.$lNewName, 'a+');
          //get the content
          $lContent = file_get_contents($lMyFile);
          if(sfConfig::get('app_settings_dev') == false) {
            $lContent = str_replace('debug.log', "//debug.log", $lContent);
          }
          //and write to the end of the new file
          $lDone = fwrite($lWholeFile, $lContent);
          echo basename($lMyFile)." combined to ".$lNewName;
          echo "\n\r";
    		}
    	}
    }
    // at least, close the new combine-file
    fclose($lWholeFile);
  }

  /**
   * Minifies a given File(whole filepath) to a new filed named by fileminname
   *
   * @param string $pFile
   * @param string $pFileMinName
   */
  private function minifyFiles($pDirname) {
  	//take all combined files from the include-folder
    $lFiles = FilesystemHelper::retrieveFilesInDir($pDirname, array('.svn'), array(), '.js');
    foreach($lFiles as $lFile) {
    	//minify each single combined file
      $lJsMin = JSMin::minify(file_get_contents($lFile));
      //build the filename with path
      $lFileName = $pDirname.str_replace('.js', '', basename($lFile)).'.min.js';
  	  //build a new minify-file named by given fileminname and open it
  	  $lMinFile = fopen($lFileName, 'a+');
  	  //write the minified content to the new minify-file
  	  $lDone = fwrite($lMinFile, $lJsMin);
  	  //and close the new minify-file
  	  fclose($lMinFile);
      echo "Minified: ".$lFileName;
      echo "\n\r";
    }
  }
}
