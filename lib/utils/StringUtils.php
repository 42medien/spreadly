<?php



/**
 * class to handel url functions
 *
 * @author Matthias Pfefferle
 */
class StringUtils {

	public static function cleanstring($pString, $pTrim = '-') {

    $lUmlauts = array("ä", "ö", "ü", "ß", "Ä", "Ö", "Ü");
    $lReplace = array("ae", "oe", "ue", "ss", "Ae", "Oe", "Ue");

    $lQuery = "";

    // FIXME funktioniert nicht!
    if (preg_match("/[ÄÖÜäöüß]/", $pString)) {
      $pString = str_replace($lUmlauts, $lReplace, $pString);
    }

		$url = str_replace("'", '', $pString);
		$url = str_replace('%20', ' ', $url);
		$url = preg_replace('~[^\\pL0-9_]+~u', $pTrim, $url);
		$url = trim($url, $pTrim);
		$url = iconv("utf-8", "us-ascii//TRANSLIT", $url);
		$url = strtolower($url);
		$url = preg_replace('~[^-a-z0-9_]+~', '', $url);

		return $url;
	}


	public static function getHtmlForLink($pString) {
		$lString = ereg_replace("[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]","<a href=\"\\0\">\\0</a>", $pString);

		return $lString;
	}

	public static function getTinyUrlInString($pHaystack) {
		$lArr = explode(" ", $pHaystack);
		foreach ($lArr as $lNeedle) {
		  $lUrlArr = array();
		  if (eregi("[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]", $lNeedle, $lUrlArr)) {
		  	try{
					if (strlen($lNeedle) > 30) {
			  		$lShortUrl = ShortUrlPeer::shortenUrl(urlencode($lNeedle));
			  		$pHaystack = str_replace($lNeedle, $lShortUrl, $pHaystack);
					}
		  	}catch (Exception $e) {
		  	}
		  }
		}

		return $pHaystack;
	}

	/**
	 * normalizes a username
	 *
	 * @author Matthias Pfefferle
	 * @param string $pUsername
	 * @return string
	 */
	public static function normalizeUsername($pUsername) {
	  $lUsername = trim($pUsername);
    $lUsername = str_replace(array(".", "-"), "_", $lUsername);

    // remove special characters
    $lUsername = preg_replace("/(\W+)/i", "", $lUsername);

    return $lUsername;
	}
	
	/**
	 * Tests, if the given string is a number
	 *
	 * @author KM
	 * @param string $pString
	 */
	public static function isNumber($pString){
		if(is_numeric($pString)) {
			return true;
		}
		return false;
	}
	
	/**
	 * This method checks if the transfered pattern exists in the string
	 * 
	 * @author Christian Schätzle
	 * 
	 * @param string $pString
	 * @param string $pPattern
	 */
	public static function pregMatchString($pString, $pPattern) {
		if(preg_match($pPattern, $pString)) {
			return true;
		} else {
		  return false;  
    }
	}
}













