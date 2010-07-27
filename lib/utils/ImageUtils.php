<?php
/**
 * image utils
 *
 * @author Matthias Pfefferle
 */
class ImageUtils {
  public static function createAvatar($pAvatar) {

  }

  /**
   * generates the http path
   *
   * @param string $pSource the filename
   * @param string $pSize the size of the image
   * @return string the http path to the avatar
   */
  public static function generateAvatarUrl($pSource, $pSize) {
    $lUploadPath = sfConfig::get('sf_upload_dir_name');

    return sfConfig::get('app_settings_url').self::generateAvatarPath($pSource, $pSize, $lUploadPath);
  }

  /**
   * generates the unix/windows directory path (for filesystem operations)
   *
   * @param string $pSource the filename
   * @param string $pSize the size of the image
   * @return string the filesystem path to the avatar
   */
  public static function generateAvatarDirectory($pSource, $pSize) {
    $lUploadPath = sfConfig::get('sf_upload_dir');

    return self::generateAvatarPath($pSource, $pSize, $lUploadPath);
  }

  /**
   * generic avatar path generator
   *
   * @param string $pSource the source file
   * @param string $pSize the avatar size
   * @param string $pPath
   * @return string the path to the avatar
   */
  public static function generateAvatarPath($pSource, $pSize, $pPath) {
    if (preg_match("/x/i", $pSize)) {
      $lSize = $pSize;
    } else {
      $lSize = $pSize.'x'.$pSize;
    }

    $lBaseDir =  '/'.$pPath.DIRECTORY_SEPARATOR.'avatars'.DIRECTORY_SEPARATOR.$lSize;

    if ($pSource == "" || $pSource == "default.png") {
      $lSource = $lBaseDir.DIRECTORY_SEPARATOR."default.png";
    } else {
      $lSource = $lBaseDir.DIRECTORY_SEPARATOR.$pSource[0].DIRECTORY_SEPARATOR.$pSource[1].DIRECTORY_SEPARATOR.$pSource[2].DIRECTORY_SEPARATOR.$pSource;
    }

    return $lSource;
  }




  /**
   * generates the http path
   *
   * @param string $pSource the filename
   * @param string $pSize the size of the image
   * @return string the http path to the community-icon
   */
  public static function generateCommunityIconUrl($pSource, $pSize = 50) {
    $lUploadPath = sfConfig::get('sf_upload_dir_name');

    return self::generateCommunityIconPath($pSource, $pSize, $lUploadPath);
  }

  /**
   * generates the unix/windows directory path (for filesystem operations)
   *
   * @param string $pSource the filename
   * @param string $pSize the size of the image
   * @return string the filesystem path to the community-icon
   */
  public static function generateCommunityIconDirectory($pSource, $pSize = 50) {
    $lUploadPath = sfConfig::get('sf_upload_dir');

    return self::generateCommunityIconPath($pSource, $pSize, $lUploadPath);
  }

  /**
   * generator for community-icon paths
   *
   * @param string $pSource the source file
   * @param string $pSize the avatar size
   * @param string $pPath
   * @return string  path to the avatar
   */
  public static function generateCommunityIconPath($pSource, $pSize, $pPath) {
    if (preg_match("/x/i", $pSize)) {
      $lSize = $pSize;
    } else {
      $lSize = $pSize.'x'.$pSize;
    }

    $lBaseDir = '/'.$pPath.DIRECTORY_SEPARATOR.'community-icons'.DIRECTORY_SEPARATOR.$lSize;

    if ($pSource == "" || $pSource == "default") {
      $lSource = $lBaseDir.DIRECTORY_SEPARATOR."default";
    } else {
      $lSource = $lBaseDir.DIRECTORY_SEPARATOR.$pSource[0].DIRECTORY_SEPARATOR.$pSource[1].DIRECTORY_SEPARATOR.$pSource[2].DIRECTORY_SEPARATOR.$pSource;
    }

    return $lSource;
  }

  /**
   * generates http headers to return and display an image
   *
   * @author Christian Weyand
   *
   * @param $pResponse
   * @param $pImagePath
   * @param $pModified
   * @return sfWebResponse
   */
  public static function generateImageHeaders($pResponse, $pImagePath, $pModified) {
    $lResponse = $pResponse;
    $filesize =  intval(filesize($pImagePath));
    $lResponse->setHttpHeader('Last-Modified',$pModified);
    $lResponse->setContentType('image/png');

    $lResponse->setHttpHeader('Content-Length', $filsize);

    $handle = fopen ($pImagePath, "r");
    $lResponse->setContent( fread( $handle,$filesize));
    fclose($handle);
    return $lResponse;
  }

    /**
   * generates the absoute http uri for an aggregated activity icon
   * (http://www.yiid.com/img/icon/xyz.jpg
   *
   * @author weyandch
   * @param string $pSource the filename
   * @param string $pSize the size of the image
   * @return string the http path to the aggreagted-icon
   */
  public static function generateAggregatedActivityIconUrl($pType) {
    return sfConfig::get('app_settings_url')."/img/search/type_icons/".strtolower($pType).'.jpg';
  }


}
?>