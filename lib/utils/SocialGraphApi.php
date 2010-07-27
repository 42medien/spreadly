<?php
require_once 'Zend/Http/Client.php';

/**
 * Class to use Googles Social Graph API
 *
 * @link: http://code.google.com/apis/socialgraph/
 */
class SocialGraphApi {
	/**
	 * function to send the API call
	 *
	 * @param array $uris The startpoint URIs
	 * @param array $params the Social Graph API parameters
	 * @return string JSON
	 */
	public static function get(array $uris, array $params) {

	  // edo  boolean   Return edges out from returned nodes. -> edgesout
    $edgesout = isset($params['edgesout']) ? $params['edgesout'] : '0';
    // edi  boolean   Return edges in to returned nodes. -> edgesin
    $edgesin = isset($params['edgesin']) ? $params['edgesin'] : '0';
    // fme  boolean   Follow me links, also returning reachable nodes. -> followme
    $followme = isset($params['followme']) ? $params['followme'] : '0';
    // sgn  boolean   Return internal representation of nodes.
    $sgn = isset($params['sgn']) ? $params['sgn'] : '0';

		// is array? implode else pass
		if (is_array($uris)) {
			$uris = implode(',',$uris);
		}
		if (empty($uris)) return null;

		// build query string
		$qs = '';
		$qs .= 'q=' . $uris .
			  '&edo=' . $edgesout .
			  '&edi=' . $edgesin .
			  '&fme=' . $followme .
			  '&sgn=' . $sgn;

		// build HTTP-Client to send the POST and retrieve the response
		$client = new Zend_Http_Client(sfConfig::get('app_profile_sgapi_url')."?$qs");
    $response = $client->request();
    $result = $response->getBody();

		if (empty($result)) return null;

		//TODO: handle errors
		$data = json_decode($result, true);
		return $data;
	}

  /**
   * Function to get OnlineIdentities using googles social graph api
   *
   * @param string $url
   * @return array
   * @link http://code.google.com/apis/socialgraph/
   */
  public static function suggestOnlineIdentities($links) {
    // is array? implode else pass
    if (is_array($links)) {
      $uris = implode(',',$links);
    }
    if (empty($uris)) return null;

    try {
      // get JSON
      $result = UrlUtils::getUrlContent(sfConfig::get('app_profile_sgapi_otherme').'?q='.$uris.'&pretty=1');
    } catch(Exception $e) {
      return null;
    }

    $data = @json_decode($result, true);

    if ($data) {
      $lUniqueArray = array_unique($data);
      $lReaultArray = array();

      // url-helper in symfony 1.1 needs http or https links so here they are
      foreach ($data as $key => $value) {
        if ((preg_match("/http:\/\//i", $key) || preg_match("/https:\/\//i", $key)) && (!preg_match("/yiid\.com/i", $key))) {
          $lReaultArray[] = $key;
        }
      }

      return $lReaultArray;
    } else {
      return null;
    }
  }

  /**
   * Function to get social graph by url or by added profile
   * links
   *
   * @param string $url
   * @return array
   * @link http://code.google.com/apis/socialgraph/
   */
  public static function getSocialGraph($link) {
    // set sg params
    $params = array();
    $params['followme'] = 0;
    $params['edgesout'] = 1;
    $params['edgesin'] = 0;
    $params['sgn'] = 0;

    // use Social Graph API
    $result = self::get(array($link), $params);

    // debug
    sfContext::getInstance()->getLogger()->debug("getSocialGraph result: " . print_r($result, true));
    sfContext::getInstance()->getLogger()->debug("getSocialGraph link: " . print_r($link, true));

    // temp array
    $lResultArray = array();

    if ($result) {

      $link = $result['canonical_mapping'][$link];

      // use all real links except rel="me"
      foreach ($result['nodes'][$link]['nodes_referenced'] as $key => $value) {
        if (!in_array('me', $value['types']) && ((preg_match("/http:\/\//i", $key) || preg_match("/https:\/\//i", $key)))) {
          $lResultArray[] = $key;
        }
        //$nodes = array_merge($nodes, $r['unverified_claiming_nodes']);
      }

      return $lResultArray;
    } else {
      return null;
    }
  }

  /**
   * looks up the informations of a given URL
   *
   * @param string $pUrl an URL or SGN-Link
   * @return string|null
   */
  public static function lookupOnlineIdentityUrl($pUrl) {
    $lJson = UrlUtils::getUrlContent('http://socialgraph.apis.google.com/lookup?sgn=true&q='.$pUrl);

    sfContext::getInstance()->getLogger()->debug(print_r($lJson,true));

    $lSGObject = json_decode($lJson, true);
    $lSgnUri = $lSGObject['canonical_mapping'][$pUrl];

    $lQuery = explode("?", $lSgnUri);

    if (array_key_exists(1, $lQuery)) {
      $lQueries = array();
      parse_str($lQuery['1'], $lQueries);

      $lProfileUri = $lSGObject['nodes'][$lSgnUri]['attributes']['profile'];

      if ( array_key_exists('ident', $lQueries)) {
        return str_replace($lQueries['ident'], "%s", $lProfileUri);
      }
    }

    return null;
  }

  /**
   * looks up the informations of a given URL
   *
   * @param string $pUrl an URL or SGN-Link
   * @return string|null
   */
  public static function lookupAttributes($pUrl) {
    $lJson = UrlUtils::getUrlContent('http://socialgraph.apis.google.com/lookup?q='.$pUrl);

    sfContext::getInstance()->getLogger()->debug(print_r($lJson,true));

    $lSGObject = json_decode($lJson, true);
    $lUrl = $lSGObject["canonical_mapping"][$pUrl];
    $lAttributes = $lSGObject["nodes"][$lUrl]["attributes"];

    return $lAttributes;
  }
  
  /**
   * looks up the informations of a given URL
   *
   * @param string $pUrl an URL or SGN-Link
   * @return string|null
   */
  public static function verifyRelMe($pUrl, $pYiidIdentity) {
    $lJson = UrlUtils::getUrlContent('http://socialgraph.apis.google.com/lookup?q='.$pUrl.'&fme=1');
    //var_dump($lJson);die();  
    $lSGObject = json_decode($lJson, true);
    //var_dump($lSGObject);die();    
    $lUrl = $lSGObject["canonical_mapping"][$pUrl];
    //var_dump($lUrl);die();
    $lAttributes = $lSGObject[$lUrl];
    foreach($lSGObject['nodes'][$lUrl]['claimed_nodes'] as $lClaimed) {
    	if(stristr($pYiidIdentity, $lClaimed) != '') {
    		return true;
    	}
    }
    return false;
  }  
}
