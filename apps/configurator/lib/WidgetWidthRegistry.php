<?php

/**
 *
 * @author Christian Schätzle
 *
 */
class WidgetWidthRegistry 
{
	const WIDGET_GLOBAL_TYPE_FULL = 'full';
	const WIDGET_GLOBAL_TYPE_LIKE = 'like';
  
	/**
	 * This function returns the minimum width for the transfered gobal widget type, widget like type and culture
	 * @author Christian Schätzle
	 * 
   * @param string $pGlobalType
	 * @param string $pLikeType
	 * @param string $pCulture
   * @param integer $pShortVersion
	 * @return integer
	 */
	public static function get($pGlobalType, $pLikeType, $pCulture, $pShortVersion) {
		if($pShortVersion) {
		  $lWidthValues = self::$lWidthArrShort;
		} else {
      $lWidthValues = self::$lWidthArr;
		}
		return $lWidthValues[$pGlobalType][$pLikeType][$pCulture];
	}
  
  /**
   * This function returns the minimum full width for the transfered widget type and culture
   * @author Christian Schätzle
   * 
   * @param string $pType
   * @param string $pCulture
   * @param integer $pShortVersion
   * @return integer
   */
  public static function getFull($pType, $pCulture, $pShortVersion) {
    return self::get(self::WIDGET_GLOBAL_TYPE_FULL, $pType, $pCulture, $pShortVersion);
  }
  
  /**
   * This function returns the minimum like width for the transfered widget type and culture
   * @author Christian Schätzle
   * 
   * @param string $pType
   * @param string $pCulture
   * @param integer $pShortVersion
   * @return integer
   */
  public static function getLike($pType, $pCulture, $pShortVersion) {
    return self::get(self::WIDGET_GLOBAL_TYPE_LIKE, $pType, $pCulture, $pShortVersion);
  }
	
	/**
	 * This function returns the optimal full width for the transfered widget type and culture. 
	 * If the users' width is smaller than the minimum width, it returns the minimum width
	 * 
	 * @author Christian Schätzle
	 * 
   * @param integer $pShortVersion
	 * @param integer $pUserWidth
	 * @param string $pType
	 * @param string $pCulture
	 */
	public static function getOptimalFullWidth($pShortVersion, $pUserWidth, $pType, $pCulture) {
		$lCurrentMinimumWidthFull = self::getFull($pType, $pCulture, $pShortVersion);
		
		if($pUserWidth < $lCurrentMinimumWidthFull)
		  return $lCurrentMinimumWidthFull;
		else
		  return $pUserWidth;
	}
  
  /**
   * This function returns the optimal like width for the transfered widget type and culture. 
   * If the users' width is smaller than the minimum width, it returns the minimum width
   * 
   * @author Christian Schätzle
   * 
   * @param integer $pShortVersion
   * @param integer $pUserWidth
   * @param string $pType
   * @param string $pCulture
   */
  public static function getOptimalLikeWidth($pShortVersion, $pUserWidth, $pType, $pCulture) {
    $lCurrentMinimumWidthLike = self::getLike($pType, $pCulture, $pShortVersion);
    
    if($pUserWidth < $lCurrentMinimumWidthLike)
      return $lCurrentMinimumWidthLike;
    else
      return $pUserWidth;
  }
  
  /**
   * This function returns the width for the configurator width label
   * 
   * @author Christian Schätzle
   * 
   * @param string $pGlobalType
   * @param string $pLikeType
   * @param string $pCulture
   * @param integer $pShortVersion
   * @return integer
   */
  public static function getWidthForLabel($pGlobalType, $pLikeType, $pCulture, $pShortVersion) {
  	if($pGlobalType == self::WIDGET_GLOBAL_TYPE_LIKE) {
      return self::getLike($pLikeType, $pCulture, $pShortVersion);
  	} else {
  		return self::getFull($pLikeType, $pCulture, $pShortVersion);
  	}
  }
  
  /**
   * This array consists of all minimum iframe sizes for the specific types and cultures
   * 
   * @author Christian Schätzle
   * 
   * @var $lWidthArr
   */
  public static $lWidthArr = array(
    'full' => array(
      'like' => array(
        'de' => 345,
        'en' => 265),
      'pro' => array(
        'de' => 295,
        'en' => 260),
      'recommend' => array(
        'de' => 365,
        'en' => 360),
      'visit' => array(
        'de' => 315,
        'en' => 335),
      'nice' => array(
        'de' => 340,
        'en' => 330),
      'buy' => array(
        'de' => 360,
        'en' => 320),
      'rsvp' => array(
        'de' => 330,
        'en' => 305)
    ),
    'like' => array(
      'like' => array(
        'de' => 295,
        'en' => 235),
      'pro' => array(
        'de' => 260,
        'en' => 225),
      'recommend' => array(
        'de' => 320,
        'en' => 320),
      'visit' => array(
        'de' => 270,
        'en' => 310),
      'nice' => array(
        'de' => 320,
        'en' => 320),
      'buy' => array(
        'de' => 320,
        'en' => 285),
      'rsvp' => array(
        'de' => 285,
        'en' => 285)
    ),
  );
  
  /**
   * This array consists of all minimum iframe sizes for the specific types and cultures (short version)
   * 
   * @author Christian Schätzle
   * 
   * @var $lWidthArr
   */
  public static $lWidthArrShort = array(
    'full' => array(
      'like' => array(
        'de' => 245,
        'en' => 200),
      'pro' => array(
        'de' => 230,
        'en' => 200),
      'recommend' => array(
        'de' => 270,
        'en' => 255),
      'visit' => array(
        'de' => 240,
        'en' => 240),
      'nice' => array(
        'de' => 265,
        'en' => 250),
      'buy' => array(
        'de' => 280,
        'en' => 250),
      'rsvp' => array(
        'de' => 235,
        'en' => 200)
    ),
    'like' => array(
      'like' => array(
        'de' => 210,
        'en' => 180),
      'pro' => array(
        'de' => 210,
        'en' => 180),
      'recommend' => array(
        'de' => 235,
        'en' => 225),
      'visit' => array(
        'de' => 205,
        'en' => 220),
      'nice' => array(
        'de' => 250,
        'en' => 245),
      'buy' => array(
        'de' => 250,
        'en' => 220),
      'rsvp' => array(
        'de' => 200,
        'en' => 195)
    ),
  );
	
}