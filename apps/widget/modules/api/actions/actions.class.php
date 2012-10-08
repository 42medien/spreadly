<?php
/**
 * api actions.
 *
 * @package    yiid
 * @subpackage api
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class apiActions extends sfActions {

	public function executeLoad_friends(sfWebRequest $request) {
	  $this->getResponse()->setHttpHeader('Access-Control-Allow-Origin', '*');

    $this->getResponse()->setContentType('text/html');
    $this->setLayout(false);
    $lUserId = $request->getParameter('u_id');
    $lSocialObjectId = $request->getParameter('so_id');

    $lReturn['success'] = false;
		$lReturn['html'] = false;
		$this->pFriends = array();
    if($lUserId && $lSocialObjectId) {
    	$this->pFriends = array_slice(UserTable::getFriendIdsBySocialObjectId($lSocialObjectId, $lUserId), 0, 3);
    }

   	return $lReturn['html'];
  }
  
  public function executeDemo_ad(sfWebRequest $request) {
    $url = $request->getParameter("url");
    $domain = parse_url($url, PHP_URL_HOST);
    
    switch(strtolower($domain)) {
      case ("deraktionaer.de"):
      case ("www.deraktionaer.de"):
        $this->setTemplate("deraktionaer_ad");
        break;
 
      case ("yigg.de"):
      case ("www.yigg.de"):
      case ("ednetz.de"):
      case ("www.ednetz.de"):
        $this->setTemplate("yigg_ad");
        break;

      case ("urlaubspartner.net"):
      case ("www.urlaubspartner.net"):
        $this->setTemplate("urlaubspartner_ad");
        break;

      case ("docinsider.de"):
      case ("www.docinsider.de"):
        $this->setTemplate("docinsider_ad");
        break;
      
      case ("peketec.de"):
      case ("www.peketec.de"):
        $this->setTemplate("peketec_ad");
        break;
      
      case ("planet-liebe.de"):
      case ("www.planet-liebe.de"):
        $this->setTemplate("planet_liebe_ad");
        break;
      
      case ("klatsch-tratsch.de"):
      case ("www.klatsch-tratsch.de"):
        $this->setTemplate("klatsch_tratsch_ad");
        break;

      case ("basicthinking.de"):
      case ("www.basicthinking.de"):
        $this->setTemplate("basicthinking_ad");
        break;
      
      case ("ibusiness.de"):
      case ("www.ibusiness.de"):
        $this->setTemplate("ibusiness_ad");
        break;
      
      case ("briefmarkenspiegel.de"):
      case ("www.briefmarkenspiegel.de"):
        $this->setTemplate("briefmarkenspiegel_ad");
        break;
      
      case ("d-b-z.de"):
      case ("www.d-b-z.de"):
        $this->setTemplate("dbz_ad");
        break;
      
      case ("eins.de"):
      case ("www.eins.de"):
        $this->setTemplate("eins_ad");
        break;
      
      case ("istlokal.de"):
      case ("www.istlokal.de"):
      case ("16vor.de"):
      case ("www.16vor.de"):
      case ("dippolds.info"):
      case ("www.dippolds.info"):
      case ("dahogn.de"):
      case ("www.dahogn.de"):
      case ("dossenheimblog.de"):
      case ("www.dossenheimblog.de"):
      case ("ebersberger-nachrichten.de"):
      case ("www.ebersberger-nachrichten.de"):
      case ("edingenneckarhausenblog.de"):
      case ("www.edingenneckarhausenblog.de"):
      case ("eichwalder-nachrichten.de"):
      case ("www.eichwalder-nachrichten.de"):
      case ("ferienstimme.de"):
      case ("www.ferienstimme.de"):
      case ("fuerther-freiheit.info"):
      case ("www.fuerther-freiheit.info"):
      case ("heddesheimblog.de"):
      case ("www.heddesheimblog.de"):
      case ("hemsbachblog.de"):
      case ("www.hemsbachblog.de"):
      case ("hirschbergblog.de"):
      case ("www.hirschbergblog.de"):
      case ("homberger-hingucker.de"):
      case ("www.homberger-hingucker.de"):
      case ("ilvesheimblog.de"):
      case ("www.ilvesheimblog.de"):
      case ("klaerwerk-blog.de"):
      case ("www.klaerwerk-blog.de"):
      case ("ladenburgblog.de"):
      case ("www.ladenburgblog.de"):
      case ("laudenbachblog.de"):
      case ("www.laudenbachblog.de"):
      case ("leer-meinung.de"):
      case ("www.leer-meinung.de"):
      case ("mecklenburgerstimme.de"):
      case ("www.mecklenburgerstimme.de"):
      case ("mittelhessenblog.de"):
      case ("www.mittelhessenblog.de"):
      case ("nadr.de"):
      case ("www.nadr.de"):
      case ("nrwz.de"):
      case ("www.nrwz.de"):
      case ("pottblog.de"):
      case ("www.pottblog.de"):
      case ("prenzlauerberg-nachrichten.de"):
      case ("www.prenzlauerberg-nachrichten.de"):
      case ("regensburg-digital.de"):
      case ("www.regensburg-digital.de"):
      case ("rheinneckarblog.de"):
      case ("www.rheinneckarblog.de"):
      case ("rhein-onliner.de"):
      case ("www.rhein-onliner.de"):
      case ("freiehonnefer.de"):
      case ("www.freiehonnefer.de"):
      case ("rostockerjournal.de"):
      case ("www.rostockerjournal.de"):
      case ("rothenburg.info"):
      case ("www.rothenburg.info"):
      case ("ruhrbarone.de"):
      case ("www.ruhrbarone.de"):
      case ("schriesheimblog.de"):
      case ("www.schriesheimblog.de"):
      case ("schweinfurter-echo.de"):
      case ("www.schweinfurter-echo.de"):
      case ("singold-bote.de"):
      case ("www.singold-bote.de"):
      case ("solinger-bote.de"):
      case ("www.solinger-bote.de"):
      case ("tegernseerstimme.de"):
      case ("www.tegernseerstimme.de"):
      case ("viernheimblog.de"):
      case ("www.viernheimblog.de"):
      case ("weilburger-nachrichten.de"):
      case ("www.weilburger-nachrichten.de"):
      case ("weinheimblog.de"):
      case ("www.weinheimblog.de"):
      case ("weiterstadtnetz.de"):
      case ("www.weiterstadtnetz.de"):
      case ("wendland-net.de"):
      case ("www.wendland-net.de"):
      case ("wir-im-vorgebirge.de"):
      case ("www.wir-im-vorgebirge.de"):
      case ("schiebener.eu"):
      case ("www.schiebener.eu"):
        $this->setTemplate("istlokal_ad");
        break;
    }
    
    $this->setLayout(false);
  }
}