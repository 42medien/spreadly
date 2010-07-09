<?php

/**
 * The Script creates a new combined and minified js-file called by build.xml (phing buildjs)
 * requires the jsmin.php-class and an entry in the app.yml with current release-name
 * @author KM
 * @version 1.0
 */


require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');
require_once(dirname(__FILE__).'/../lib/vendor/jsmin.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'prod', true);
include_once(dirname(__FILE__).'/../config/setIncludePath.php');
sfContext::createInstance($configuration);

$logger = sfContext::getInstance()->getLogger();

// Initialize database manager.
$dbManager = new sfDatabaseManager($configuration);
$dbManager->loadConfiguration();


// the path to the directory we want to combine and minify
$lDir = dirname(__FILE__).'/../web/js';

//generate the filenames by the current release-entry in the app.yml
//$lFileName = sfConfig::get('app_release_name').'.js';
//$lFileMinName = sfConfig::get('app_release_name').'.min.js';
$lFileName = 'rogue.js';
$lFileMinName = 'rogue.min.js';


//initialize the combine and minify-process
writeWholeFile($lDir,$lFileName,$lFileMinName);

/**
 * Initializes the combine and minify-processes
 *
 * @param string $pDir
 * @param string $pFileName
 * @param string $pFileMinName
 */
function writeWholeFile($pDir, $pFileName, $pFileMinName) {
	
	$lFiles = FilesystemHelper::retrieveFilesInDir(dirname(__FILE__).'/../web/js/test/', array('.svn'), array(), '.js');
  foreach($lFiles as $lFile) {
  	unlink($lFile);	
  }
	
  //we get all Files we want to combine
  $lFiles = FilesystemHelper::retrieveFilesInDir($pDir, array('.svn', 'vendor', 'include'), array($pFileName, $pFileMinName), '.js');
  //writes the current needed consolelog-file to the beginning of all scripts
  //$lFiles = handleConsoleLog($pDir, $lFiles);
  //we combine the Files to one file named by given filenname and save it in the include-folder
  combineFiles($lFiles, $pFileName);
  //we minify the combined file and save it in the include-folder by given fileminname
  minifyFiles(dirname(__FILE__).'/../web/js/test/');
  //echo "build js-File: ".$pFileMinName;
  //echo "\n\r";
}


/**
 * Combines the Files from the given array to on file, named by given filename
 *
 * @param array $pFiles
 * @param string $pFileName
 */
function combineFiles($pFiles, $pFileName) {

	//foreach about all files we wanna combine
  foreach($pFiles as $lMyFile) {
  	//now we get the content of the current-file as an array (every line = one field in the array)
  	$lArray = file($lMyFile);
    //var_dump(trim(chop($lArray[0])));die();  
  	foreach($lArray as $lKey => $lValue) {
  		$lValue = trim(chop(str_replace(" ", "", $lValue)));
  		
  		if(strpos($lValue, '*@combine') !== false) {
  			$lNewName = str_replace('*@combine', "", $lValue).'-'.$pFileName;
        $lWholeFile = fopen(dirname(__FILE__).'/../web/js/test/'.$lNewName, 'a+');
        $lContent = file_get_contents($lMyFile);
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
function minifyFiles($pDirname) {
	
  $lFiles = FilesystemHelper::retrieveFilesInDir($pDirname, array('.svn'), array(), '.js');
  foreach($lFiles as $lFile) {
    $lJsMin = JSMin::minify(file_get_contents($lFile));
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


function handleConsoleLog($pDir, $pFiles) {
  $lDevKey = array_search($pDir.'/utils/clog_dev.js', $pFiles);
  $lLiveKey = array_search($pDir.'/utils/clog_live.js', $pFiles);
	if(sfConfig::get('app_settings_dev') == true) {
    unset($pFiles[$lLiveKey]);
    $lDevFile = $pFiles[$lDevKey];
    unset($pFiles[$lDevKey]);
    array_unshift($pFiles, $lDevFile);
  }	else {
    unset($pFiles[$lDevKey]);
    $lLiveFile = $pFiles[$lLiveKey];
    unset($pFiles[$lLiveKey]);
    array_unshift($pFiles, $lLiveFile);
  }
  return $pFiles;
}


?>
