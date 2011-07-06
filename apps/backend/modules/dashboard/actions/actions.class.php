<?php

/**
 * dashboard actions.
 *
 * @package    yiid
 * @subpackage dashboard
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class dashboardActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {

    $this->range = $request->getParameter('range', 'today');

    switch ($this->range) {
      case 'today':
        $range = array(strtotime("today"), strtotime("tomorrow - 1 second"));
        $lastRange = array(strtotime("yesterday"), strtotime("today - 1 second"));
        $this->fromDate = date('l', $range[0]);
        $this->toDate = date('d.m.Y', $range[0]);
        break;
      case 'yesterday':
        $range = array(strtotime("yesterday"), strtotime("today - 1 second"));
        $lastRange = array(strtotime("today - 2 days"), strtotime("yesterday - 1 second"));
        $this->fromDate = date('l', $range[0]);
        $this->toDate = date('d.m.Y', $range[0]);
        break;
      case 'last7d':
        $range = array(strtotime("today - 7 days"), strtotime("today - 1 second"));
        $lastRange = array(strtotime("today - 14 days"), strtotime("today - 7 days - 1 second"));
        $this->fromDate = date('d.m.Y', $range[0]);
        $this->toDate = date('d.m.Y', $range[1]-24*60*60);
        break;
      case 'last30d':
        $range = array(strtotime("today - 30 days"), strtotime("today - 1 second"));
        $lastRange = array(strtotime("today - 60 days"), strtotime("today - 30 days - 1 second"));
        $this->fromDate = date('d.m.Y', $range[0]);
        $this->toDate = date('d.m.Y', $range[1]-24*60*60);
        break;

      default:
        throw new Exception("No range key specified.");
        break;
    }

    $this->data = $this->calc($range, $lastRange);

    $this->setLayout('dash_layout');
  }

  private function calc($range, $lastRange) {
    $data = array();

    $data['current_user_count'] = UserTable::getInstance()->countByRange($range[0], $range[1]);
    $data['last_user_count']    = UserTable::getInstance()->countByRange($lastRange[0], $lastRange[1]);
    $data['user_count_delta']   = $this->delta($data['current_user_count'], $data['last_user_count']);

    $data['current_stats_user_count'] = SfGuardUserTable::getInstance()->countByRange($range[0], $range[1]);
    $data['last_stats_user_count']    = SfGuardUserTable::getInstance()->countByRange($lastRange[0], $lastRange[1]);
    $data['stats_user_count_delta']   =  $this->delta($data['current_stats_user_count'], $data['last_stats_user_count']);

    $data['current_likes_count']    = MongoManager::getDm()->getRepository('Documents\YiidActivity')->countByRange($range[0], $range[1]);
    $data['last_likes_count']    = MongoManager::getDm()->getRepository('Documents\YiidActivity')->countByRange($lastRange[0], $lastRange[1]);
    $data['likes_count_delta']   =  $this->delta($data['current_likes_count'], $data['last_likes_count']);

    $data['current_cbl_count']    = MongoManager::getDm()->getRepository('Documents\YiidActivity')->countCBLByRange($range[0], $range[1]);
    $data['last_cbl_count']    = MongoManager::getDm()->getRepository('Documents\YiidActivity')->countCBLByRange($lastRange[0], $lastRange[1]);
    $data['cbl_count_delta']   =  $this->delta($data['current_cbl_count'], $data['last_cbl_count']);


    $data['current_domain_count'] = DomainProfileTable::getInstance()->countByRange($range[0], $range[1]);
    $data['last_domain_count']    = DomainProfileTable::getInstance()->countByRange($lastRange[0], $lastRange[1]);
    $data['domain_count_delta']   = $this->delta($data['current_domain_count'], $data['last_domain_count']);

    $data['current_verified_domain_count'] = DomainProfileTable::getInstance()->countVerifiedByRange($range[0], $range[1]);
    $data['last_verified_domain_count']    = DomainProfileTable::getInstance()->countVerifiedByRange($lastRange[0], $lastRange[1]);
    $data['verified_domain_count_delta']   = $this->delta($data['current_verified_domain_count'], $data['last_verified_domain_count']);

    $data['current_stats']    = MongoManager::getStatsDm()->getRepository('Documents\AnalyticsActivity')->findOnlyByRange($range[0], $range[1]);

    $data['last_stats']    = MongoManager::getStatsDm()->getRepository('Documents\AnalyticsActivity')->findOnlyByRange($lastRange[0], $lastRange[1]);

    $data['current_stats'] = ($data['current_stats'] && $data['current_stats']->hasNext()) ? $data['current_stats']->getNext() : null;
    $data['last_stats'] = ($data['last_stats'] && $data['last_stats']->hasNext()) ? $data['last_stats']->getNext() : null;

    $data['current_clickback_count'] = $data['current_stats'] ? $data['current_stats']['value']['cb'] : 0;
    $data['last_clickback_count'] = $data['last_stats'] ? $data['last_stats']['value']['cb'] : 0;
    $data['clickback_count_delta'] = $this->delta($data['current_clickback_count'], $data['last_clickback_count']);

    $data['current_media_penetration_count'] = $data['current_stats'] ? $data['current_stats']['value']['mp'] : 0;
    $data['last_media_penetration_count'] = $data['last_stats'] ? $data['last_stats']['value']['mp'] : 0;
    $data['media_penetration_count_delta'] = $this->delta($data['current_media_penetration_count'], $data['last_media_penetration_count']);

    $data['share_distribution'] = $data['current_stats'] ?
      array(
        $data['current_stats']['value']['s']['facebook'] ? $data['current_stats']['value']['s']['facebook']['l'] : 0,
        $data['current_stats']['value']['s']['twitter'] ? $data['current_stats']['value']['s']['twitter']['l'] : 0,
        $data['current_stats']['value']['s']['linkedin'] ? $data['current_stats']['value']['s']['linkedin']['l'] : 0,
        $data['current_stats']['value']['s']['google'] ? $data['current_stats']['value']['s']['google']['l'] : 0
        ) : array(0,0,0,0);

    $data['share_distribution_labels'] = array('Fb:'.$data['share_distribution'][0] , 'Tw:'.$data['share_distribution'][1], 'Li:'.$data['share_distribution'][2], 'Go:'.$data['share_distribution'][3]);

    if($this->range == 'today' || $this->range == 'yesterday') {
      $lActivityStats = MongoManager::getStatsDm()->getRepository("Documents\ActivityStats")->findByRangeGroupByDay($range[0], $range[1]);

      $h = null;
      if($lActivityStats && $lActivityStats->hasNext()) {
        $temp = $lActivityStats->getNext();
        $h = $temp['value']['h'];
        unset($h['php_ckuf']);
      }

      $data['current_likes_range'] = $h ? $h : array();
      
      sfContext::getInstance()->getLogger()->err(print_r($data['current_likes_range'], true));

      $lActivityStats = MongoManager::getStatsDm()->getRepository("Documents\DealStats")->findByRangeGroupByDay($range[0], $range[1]);

      $h = null;
      if($lActivityStats && $lActivityStats->hasNext()) {
        $temp = $lActivityStats->getNext();
        $h = $temp['value']['h'];
        unset($h['php_ckuf']);
      }

      $data['current_deals_range'] = $h ? $h : array();
    } else {
      $lActivityStats = MongoManager::getStatsDm()->getRepository("Documents\ActivityStats")->findLikesByRangeGroupByDay($range[0], $range[1]);

      if ($lActivityStats) {
        $lActivityStats = $lActivityStats->toArray();

        $data['current_likes_range'] = array_values($this->padLikes($lActivityStats, date('c', $range[0]), date('c', $range[1])));


        $lActivityStats = MongoManager::getStatsDm()->getRepository("Documents\DealStats")->findLikesByRangeGroupByDay($range[0], $range[1]);

        $lActivityStats = $lActivityStats->toArray();

        $data['current_deals_range'] = array_values($this->padLikes($lActivityStats, date('c', $range[0]), date('c', $range[1])));
      }
    }

    $data['top_users'] = array_slice(MongoManager::getStatsDm()->getRepository("Documents\AnalyticsActivity")->groupByUsers($range[0], $range[1]), 0, 5);

    $data['top_hosts'] = array_slice(MongoManager::getStatsDm()->getRepository("Documents\AnalyticsActivity")->groupByHosts($range[0], $range[1]), 0, 5);

    $data['top_urls'] = array_slice(MongoManager::getStatsDm()->getRepository("Documents\AnalyticsActivity")->groupByUrls($range[0], $range[1]), 0, 5);

    $cb = new Chartbeat();
    $data['current_popup_visitors_count'] = $cb->getVisitorsByDate($this->range);
    
    
    $data['current_pi_count'] = intval(VisitTable::countPisForDay($range[0]));
    $data['last_pi_count']    = intval(VisitTable::countPisForDay($lastRange[0]));
    $data['pi_count_delta']   = $this->delta($data['current_pi_count'], $data['last_pi_count']);

    $data['current_conversion'] =  $this->conversion($data['current_likes_count'], $data['current_pi_count']);
    $data['last_conversion']    =  $this->conversion($data['last_likes_count'], $data['last_pi_count']);
    $data['conversion_delta']   = $this->delta($data['current_conversion'], $data['last_conversion']);

    return $data;
  }

  private function delta($x, $y) {
    if($x==$y) return 0;
    return $y>0 ? round((($x-$y)/$y)*100) : '∞';
  }

  private function conversion($x, $y) {
    if($y==0) return 0;
    return round(($x/$y)*100);
  }
  
  // undry copy of analytics/actions
  private function padLikes($activityStats, $from, $to) {
    $from = new DateTime($from);
    $from->setTime(0,0);
    $to = new DateTime($to);
    $to->setTime(24,0);

    $lDayPeriod = new DatePeriod($from, new DateInterval('P1D'), $to);

    $res = array();
    foreach ($lDayPeriod as $day) {
      $res[$day->format('Y-m-d')] = 0;
    }
    foreach ($activityStats as $stat) {
      $res[date('Y-m-d', $stat['_id']->sec)] = $stat['value']['l'];
    }
    return $res;
  }
}
