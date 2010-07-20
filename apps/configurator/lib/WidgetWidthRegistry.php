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
	 * @return integer
	 */
	public static function get($pGlobalType, $pLikeType, $pCulture) {
		$lWidthValues = self::$lWidthArr;
		return $lWidthValues[$pGlobalType][$pLikeType][$pCulture];
	}
  
  /**
   * This function returns the minimum full width for the transfered widget type and culture
   * @author Christian Schätzle
   * 
   * @param string $pType
   * @param string $pCulture
   * @return integer
   */
  public static function getFull($pType, $pCulture) {
    return self::get(self::WIDGET_GLOBAL_TYPE_FULL, $pType, $pCulture);
  }
  
  /**
   * This function returns the minimum like width for the transfered widget type and culture
   * @author Christian Schätzle
   * 
   * @param string $pType
   * @param string $pCulture
   * @return integer
   */
  public static function getLike($pType, $pCulture) {
    return self::get(self::WIDGET_GLOBAL_TYPE_LIKE, $pType, $pCulture);
  }
	
	/**
	 * This function returns the optimal full width for the transfered widget type and culture. 
	 * If the users' width is smaller than the minimum width, it returns the minimum width
	 * 
	 * @author Christian Schätzle
	 * 
	 * @param integer $pUserWidth
	 * @param string $pType
	 * @param string $pCulture
	 */
	public static function getOptimalFullWidth($pUserWidth, $pType, $pCulture) {
		$lCurrentMinimumWidthFull = self::getFull($pType, $pCulture);
		
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
   * @param integer $pUserWidth
   * @param string $pType
   * @param string $pCulture
   */
  public static function getOptimalLikeWidth($pUserWidth, $pType, $pCulture) {
    $lCurrentMinimumWidthLike = self::getLike($pType, $pCulture);
    
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
   * @return integer
   */
  public static function getWidthForLabel($pGlobalType, $pLikeType, $pCulture) {
  	if($pGlobalType == self::WIDGET_GLOBAL_TYPE_LIKE) {
      return self::getLike($pLikeType, $pCulture);
  	} else {
  		return self::getFull($pLikeType, $pCulture);
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
        'de' => 410,
        'en' => 390),
      'pro' => array(
        'de' => 400,
        'en' => 370),
      'recommend' => array(
        'de' => 450,
        'en' => 490),
      'visit' => array(
        'de' => 390,
        'en' => 440),
      'nice' => array(
        'de' => 430,
        'en' => 420),
      'buy' => array(
        'de' => 410,
        'en' => 440),
      'rsvp' => array(
        'de' => 390,
        'en' => 340)
    ),
    'like' => array(
      'like' => array(
        'de' => 420,
        'en' => 350),
      'pro' => array(
        'de' => 380,
        'en' => 330),
      'recommend' => array(
        'de' => 430,
        'en' => 470),
      'visit' => array(
        'de' => 380,
        'en' => 430),
      'nice' => array(
        'de' => 440,
        'en' => 410),
      'buy' => array(
        'de' => 430,
        'en' => 430),
      'rsvp' => array(
        'de' => 400,
        'en' => 330)
    ),
  );
	
}