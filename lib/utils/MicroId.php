<?php
require_once 'Zend/Http/Client.php';

/**
 * Provides methods needed to generate and consume MicroIDs.  All MicroID formats are supported.
 *
 * To generate a MicroID, use
 *   MicroID::generate(IDENTITY_URI, SERVICE_URI);
 *
 * For example,
 *   MicroID::generate('xmpp:stpeter@jabber.org', 'https://www.xmpp.net/');
 * will generate the following microid
 *   xmpp+https:sha1:6196ea6709be2a4cbdf2bc0cfaeac491f2fb8921
 *
 *
 * To verify that a given MicroID is valid, simply use
 *   MicroID::verify(IDENTITY_URI, SERVICE_URI, MICROID);
 * For example,
 *   MicroID::verify('xmpp:stpeter@jabber.org', 'https://www.xmpp.net/', 'xmpp+https:sha1:6196ea6709be2a4cbdf2bc0cfaeac491f2fb8921');
 *
 * If the given MicroID is in legacy format, the same method is used:
 *   MicroID::verify('xmpp:stpeter@jabber.org', 'https://www.xmpp.net/', '6196ea6709be2a4cbdf2bc0cfaeac491f2fb8921');
 *
 * @author Will Norris <will@willnorris.com>
 */
class MicroID {

  const META_REGEXP = '/<[\s]*meta[\s]*.*[\s]*[\s]*name[\s]*=[\s]*[\"\']?microid[\"\']?.*[\s]*[\/]*?>/i';
  const MICROID_REGEXP = '/content[\s]*=[\s]*[\"\']?(.*[a-zA-Z0-9+:])[\"\']?[\s]*/i';

	/**
	 * Compute a microid for the given identity and service URIs.
	 *
	 * @param string  $identity  identity URI
	 * @param string  $service   service URI
	 * @param string  $alorithm  algorithm to use in calculating the hash (default: sha1)
	 * @param boolean $legacy    if true, uritypes and algorithm will not be prefixed
	 *   to the generated microid (default: false)
	 * @returns string the calculated microid
	 */
	public static function generate($identity, $service, $algorithm = 'sha1', $legacy = false) {
		$microid = "";

		// add uritypes and algorithm if not using legacy mode
		if (!$legacy) {
			$microid .= substr($identity, 0, strpos($identity, ':')) . "+" .
				substr($service, 0, strpos($service, ':')) . ":" .
				strtolower($algorithm) . ":";
		}

		// try message digest engine
		if (function_exists('hash')) {
			if (in_array(strtolower($algorithm), hash_algos())) {
				return $microid .= hash($algorithm, hash($algorithm, $identity) . hash($algorithm, $service));
			}
		}

		// try mhash engine
		if (function_exists('mhash')) {
			$hash_method = @constant('MHASH_' . strtoupper($algorithm));
			if ($hash_method != null) {
				$identity_hash = bin2hex(mhash($hash_method, $identity));
				$service_hash = bin2hex(mhash($hash_method, $service));
				return $microid .= bin2hex(mhash($hash_method, $identity_hash . $service_hash));
			}
		}

		// direct string function
		if (function_exists($algorithm)) {
			return $microid .= $algorithm($algorithm($identity) . $algorithm($service));
		}

		error_log("MicroID: unable to find adequate function for algorithm '$algorithm'");
	}


	/**
	 * Compute a microid for the given identity and service URIs and verify that it matches
	 * the provided microid.  The provided ID can be in the legacy format (without URI
	 * types or algorithm), in which case the SHA1 algorithm will be assumed.
	 *
	 * @param string  $identity  identity URI
	 * @param string  $service   service URI
	 * @param string  $microid   existing microid to test against
	 * @returns boolean true if the computed microid matches the provided microid
	 */
	public static function verify($identity, $service, $microid) {
		// set defaults for legacy mode
		$algorithm = 'sha1';
		$legacy = true;

		$id_parts = split(':', $microid);
		if (sizeof($id_parts) == 3) { // not legacy mode
			$algorithm = $id_parts[1];
			$legacy = false;
		}

		if (self::generate($identity, $service, $algorithm, $legacy) == $microid) {
			return true;
		} else {
			return false;
		}

	}

	/**
	 * parse an uri to get all microids
	 *
	 * @param string $pUri
	 * @return array
	 */
	public static function parseUri($pUri) {
    try {
      $lContent = Utils::getUrlContent($pUri);
    } catch (Exception $e) {
      return null;
    }

	  preg_match_all( self::META_REGEXP, $lContent, $lMetaTags );

    $lMicroIds = array();

	  foreach ($lMetaTags[0] as $lI) {
	    preg_match_all( self::MICROID_REGEXP, $lI, $lMicroId );
	    $lMicroIds[] = $lMicroId[1][0];
	  }

	  return $lMicroIds;
	}
}

?>
