<?php
/**
 * Enter description here...
 *
 * @author Christian Weyand
 */
class FilesystemHelper {

  /**
   * generates for a given path and filename the Filesystem Path
   *
   * @param string $pFilename
   * @param string $pBasedir
   * @return string|false
   */
  public static function generateSystemPath($pFilename, $pBasedir) {
    // split filename to check if the given name has sufficient length alter
    $lFileParts = explode('.', $pFilename);
    $returnPath = '';

    // we need 3 hierachies for subfolders with a minimum filename length of 3 chars
    if (strlen($lFileParts[0]) >= 3 ) {
      // create folder structure if necessary
      $returnPath = self::generateFolderStructure($pFilename, $pBasedir);

      return $returnPath.=DIRECTORY_SEPARATOR.$pFilename;
    }
    return false;
  }

  public static function generateWebPath($pFilename) {

  }


  /**
   * generate all necessary folders
   *
   * @param $pFilename
   * @param $pBasedir
   * @return unknown_type
   */
  public static function generateFolderStructure($pFilename, $pBasedir) {
    $lFilename = $pFilename;

    try {
      $lBaseDir = $pBasedir.DIRECTORY_SEPARATOR.$lFilename[0];
      if(!file_exists($lBaseDir)) {
        mkdir($lBaseDir, 0755);
      }

      $lBaseDir .= DIRECTORY_SEPARATOR.$lFilename[1];

      if(!file_exists($lBaseDir)) {
        mkdir($lBaseDir, 0755);
      }

      $lBaseDir .= DIRECTORY_SEPARATOR.$lFilename[2];

      if(!file_exists($lBaseDir)) {
        mkdir($lBaseDir, 0755);
      }

    } catch (Exception $e) {
      throw new Exception('ERROR_UPLOAD_FILE');
    }
    return $lBaseDir;
  }



/**
 * Returns an array of File-Paths, that we want to combine to a single file
 * ExclusionDir says, which folders should not be combined.
 * ExclusionFile says, which files should not be combined.
 *
 * @author Karina Mies, Christian Weyand
 * @param string $pDir
 * @param array $pExclusionDir
 * @param array $pExclusionFile
 * @return array $lFiles
 */
public static function retrieveFilesInDir($pDir, $pExclusionDir = array(), $pExclusionFile = array(), $pType = '.js') {
  $lFiles = array();
  //we get an array of files and directories that ar in the given directories
  $lDirs = scandir($pDir);
  foreach($lDirs as $lFile) {
    //true, if the current $lFile should be excluded from the combine
    $lInDir = in_array($lFile, $pExclusionDir);
    //true, if the current $lFile should be excluded from the combine
    $lInFile = in_array($lFile, $pExclusionFile);
    //false, if the current-file is not a js-file. we only wanna combine js-files
    $lIsJs = stripos($lFile, $pType);
    //if current file is named . or .. we wanna do nothing
    if (($lFile == '.')||($lFile == '..')) {
      continue;
    } elseif (is_dir($pDir.'/'.$lFile) && !$lInDir) {
      //if the current file is a directory and not excluded to combine call this function again with the current file as param
      $lArray = self::retrieveFilesInDir($pDir.'/'.$lFile, $pExclusionDir, $pExclusionFile, $pType);
      //and merge the current files to the previous
      $lFiles = array_merge($lFiles, $lArray);
    } elseif (!$lInDir && !$lInFile && $lIsJs != false) {
      //if the current file is a file AND a js-File, write in array that we wanna return
      $lFiles[] = $pDir.'/'.$lFile;
    }
  }
  return $lFiles;
}

}