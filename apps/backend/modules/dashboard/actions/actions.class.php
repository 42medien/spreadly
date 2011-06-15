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
        $range = array(strtotime("today"), strtotime("tomorrow"));
        $lastRange = array(strtotime("yesterday"), strtotime("today"));
        $this->fromDate = date('l', $range[0]);
        $this->toDate = date('d.m.Y', $range[0]);
        break;
      case 'yesterday':
        $range = array(strtotime("yesterday"), strtotime("today"));
        $lastRange = array(strtotime("2 days ago"), strtotime("yesterday"));
        $this->fromDate = date('l', $range[0]);
        $this->toDate = date('d.m.Y', $range[0]);
        break;
      case 'last7d':
        $range = array(strtotime("6 days ago"), strtotime("tomorrow"));
        $lastRange = array(strtotime("14 days ago"), strtotime("7 days ago"));
        $this->fromDate = date('d.m.Y', $range[0]);
        $this->toDate = date('d.m.Y', $range[1]-24*60*60);
        break;
      case 'last30d':
        $range = array(strtotime("29 days ago"), strtotime("tomorrow"));
        $lastRange = array(strtotime("60 days ago"), strtotime("30 days ago"));
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

    $data['current_domain_count'] = DomainProfileTable::getInstance()->countByRange($range[0], $range[1]);
    $data['last_domain_count']    = DomainProfileTable::getInstance()->countByRange($lastRange[0], $lastRange[1]);
    $data['domain_count_delta']   = $this->delta($data['current_domain_count'], $data['last_domain_count']);

    $data['current_verified_domain_count'] = DomainProfileTable::getInstance()->countVerifiedByRange($range[0], $range[1]);
    $data['last_verified_domain_count']    = DomainProfileTable::getInstance()->countVerifiedByRange($lastRange[0], $lastRange[1]);
    $data['verified_domain_count_delta']   = $this->delta($data['current_verified_domain_count'], $data['last_verified_domain_count']);
    
    $data['current_stats']    = MongoManager::getStatsDm()->getRepository('Documents\AnalyticsActivity')->findOnlyByRange($range[0], $range[1]);

    $data['last_stats']    = MongoManager::getStatsDm()->getRepository('Documents\AnalyticsActivity')->findOnlyByRange($lastRange[0], $lastRange[1]);

    $data['current_stats'] = $data['current_stats']->getNext();
    $data['last_stats'] = $data['last_stats']->getNext();

    $data['current_clickback_count'] = $data['current_stats'] ? $data['current_stats']['value']['cb'] : 0;
    $data['last_clickback_count'] = $data['last_stats'] ? $data['last_stats']['value']['cb'] : 0;
    $data['clickback_count_delta'] = $this->delta($data['current_clickback_count'], $data['last_clickback_count']);
    
    $data['current_media_penetration_count'] = $data['current_stats'] ? $data['current_stats']['value']['mp'] : 0;
    $data['last_media_penetration_count'] = $data['last_stats'] ? $data['last_stats']['value']['mp'] : 0;
    $data['media_penetration_count_delta'] = $this->delta($data['current_media_penetration_count'], $data['last_media_penetration_count']);
    
    $data['share_distribution'] = $data['current_stats'] ? 
      array(
        $data['current_stats']['value']['s']['facebook']['l'],
        $data['current_stats']['value']['s']['twitter']['l'],
        $data['current_stats']['value']['s']['linkedin']['l'],
        $data['current_stats']['value']['s']['google']['l']
        ) : array();
        
    $data['share_distribution_labels'] = array('Fb', 'Tw', 'Li', 'Go');
    
    return $data;
  }
  
  private function delta($x, $y) {
    if($x==$y) return 0;
    return $y>0 ? round((($x-$y)/$y)*100) : '∞';
  }
}
 