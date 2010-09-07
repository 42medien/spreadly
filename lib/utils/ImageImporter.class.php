<?php
/**
 *
 * Handles import of UserAvatars from gravatar
 *
 * @author Christian Weyand
 * @author Matthias Pfefferle
 */
class ImageImporter {
  const PATH_TYPE_URL       = 1;
  const PATH_TYPE_DIRECTORY = 2;

  /**
   * Checks, if there's an Gravatar image for a given Email
   *
   * @param string $pEmail
   * @param int $pUserId
   *
   * @author Christian Weyand
   * @return boolean true|false
   */
  public static function importGravatarImage($pEmail, $pUserId) {
    try {
      // try to get an image from gravatar
      $lImage = UrlUtils::getUrlContent("http://www.gravatar.com/avatar/".md5(strtolower($pEmail))."?s=200&d=404");

      // create folder structure and save the image to our local filesystem
      $path = FilesystemHelper::generateSystemPath(md5(strtolower($pEmail)).'-'.$pUserId.'.jpg', sfConfig::get('sf_upload_dir').DIRECTORY_SEPARATOR.'avatars'.DIRECTORY_SEPARATOR.'original');
      $fp  = fopen($path, 'w+');
      fputs($fp, $lImage);
      fclose($fp);

      unset($lImage);
      return true;
    }
    catch (Exception $e) {
      sfContext::getInstance()->getLogger()->err("{ImageImporter} Exception: ".print_r($e, true));
      return false;
    }
  }

  public static function importImageFromUrl($pUrl, $pUserId) {
    try {
    	// try to get an image from url
      $lImage = UrlUtils::getUrlContent($pUrl);
      // create folder structure and save the image to our local filesystem
      $path = FilesystemHelper::generateSystemPath(md5(strtolower($pUrl)).'-'.$pUserId.'.jpg', sfConfig::get('sf_upload_dir').DIRECTORY_SEPARATOR.'avatars'.DIRECTORY_SEPARATOR.'original');
      $fp  = fopen($path, 'w+');
      fputs($fp, $lImage);
      fclose($fp);

      // transform to png
      // get mime-type
      $lImgData = GetImageSize($path);

      if ($lImgData['mime'] != "image/jpg" && $lImgData['mime'] != 'image/x-ms-bmp') {
        $lImg = new sfImage($path, $lImgData['mime'], 'GD');
        $lImg->getMIMEType();
        $lImg->setQuality(100);
        $lImg->saveAs($path, 'image/jpg');
        unset($lImage);
        return true;
      }
      return false;
    }
    catch (Exception $e) {
      sfContext::getInstance()->getLogger()->err("{ImageImporter} Exception: ".print_r($e, true));
      return false;
    }
  }

  /**
   * saves a snapshot of a communitiy's landingpage for cropping
   *
   * @param Object $pCommunity
   *
   * @author Christian Weyand
   * @return boolean true|false
   */
  public static function importCommunitSnapshot($pCommunity, $pPath = self::PATH_TYPE_URL) {
    try {
      // try to get an image from websnapr
      $lImage = UrlUtils::getUrlContent($pCommunity->getImage('1024x768'));
      $lBasePath = DIRECTORY_SEPARATOR.'community-icons'.DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.$pCommunity->getSlug().'.jpg';


      // create folder structure and save the image to our local filesystem
      $path = sfConfig::get('sf_upload_dir').$lBasePath;
      $fp  = fopen($path, 'w+');
      fputs($fp, $lImage);
      fclose($fp);

      unset($lImage);

      if ($pPath == self::PATH_TYPE_URL) {
        return DIRECTORY_SEPARATOR.sfConfig::get('sf_upload_dir_name').$lBasePath;
      } else {
        return $path;
      }
    }
    catch (Exception $e) {
      sfContext::getInstance()->getLogger()->err("{ImageImporter} Exception: ".print_r($e, true));
      return null;
    }
  }

  /**
   * saves the favicon of a communitiy
   *
   * @author Matthias Pfefferle
   *
   * @param Object $pCommunity
   * @return boolean true|false
   */
  public static function importFavicon($pCommunity, $pPath = self::PATH_TYPE_URL) {
    try {
      // try to get an image from websnapr
      $lImage = UrlUtils::getUrlContent($pCommunity->getFavicon());
      $lBasePath = DIRECTORY_SEPARATOR.'favicons'.DIRECTORY_SEPARATOR.$pCommunity->getSlug().'.png';

      // create folder structure and save the image to our local filesystem
      $path = sfConfig::get('sf_upload_dir').$lBasePath;
      $fp  = fopen($path, 'w+');
      fputs($fp, $lImage);
      fclose($fp);

      // get mime-type
      $lImgData = GetImageSize($path);

      if ($lImgData['mime'] != "image/png") {
        $lImg = new sfImage($path, $lImgData['mime'], 'GD');
        $lImg->getMIMEType();
        $lImg->setQuality(100);
        $lImg->saveAs($path, 'image/png');
      }

      unset($lImage);

      if ($pPath == self::PATH_TYPE_URL) {
        return DIRECTORY_SEPARATOR.sfConfig::get('sf_upload_dir_name').$lBasePath;
      } else {
        return $path;
      }
    }
    catch (Exception $e) {
      sfContext::getInstance()->getLogger()->err("{ImageImporter} Exception: ".print_r($e, true));
      return null;
    }
  }

  public static function importByUrlAndUserId($pUrl, $pUserId, $pOnlineIdentity) {
  	try{
	    $lImported = ImageImporter::importImageFromUrl($pUrl, $pUserId);
	    if($lImported) {
		    $lAvatar = new UserAvatar();
		    $lAvatar->setUserId($pUserId);
		    $lAvatar->setAvatar(md5(strtolower($pUrl)).'-'.$pUserId.'.jpg');
		    $lAvatar->setOnlineIdentityId($pOnlineIdentity->getId());

		    // inititalize gravatar info
		    $lAvatar->setImportedIdentifier($pUrl);
		    // generate missing
		    $lAvatar->generateAvatarThumbnails();
		    $lAvatar->setImportedCommunity($pOnlineIdentity->getCommunityId());
		    $lAvatar->save();
	     }
  	} catch (Exception $e) {
      sfContext::getInstance()->getLogger()->err("{ImageImporter} Exception: ".print_r($e, true));
      return null;
    }
  }
}