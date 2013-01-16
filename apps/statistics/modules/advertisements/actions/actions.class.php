<?php

/**
 * advertising actions.
 *
 * @package    yiid
 * @subpackage advertising
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class advertisementsActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request) {
  
  }
  
  /**
   * Executes advertisement action
   *
   * @param sfRequest $request A request object
   */
   public function executeAdvertisement(sfWebRequest $request) {
     $domain = $request->getParameter("domain", "http://spreadly.com/");
     $domain = urldecode($domain);

     $host = parse_url($domain, PHP_URL_HOST);
     $scheme = parse_url($domain, PHP_URL_SCHEME);

     $visit = VisitTable::getMonthlyStatistics(date('Y-m', strtotime("-1 month")), $host);
     $counter = 0;

     if (is_array($visit) && count($visit) > 0) {
       if (array_key_exists("pis_total", $visit[0])) {
         $counter = $visit[0]["pis_total"];
       }
     }

     $this->domain = $scheme."://".$host;
     $this->counter = $counter;
   }
}