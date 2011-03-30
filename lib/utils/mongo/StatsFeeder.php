<?php
use Documents\YiidActivity,
    Documents\SocialObject,
    Documents\ActivityStats,
    Documents\ActivityUrlStats,
    Documents\DealStats,
    Documents\DealUrlStats,
    Documents\HostSummary,
    Documents\UrlSummary;

/**
 * track stats
 *
 * @author Matthias Pfefferle
 * @author Hannes Schippmann
 */
class StatsFeeder {

  /**
   * track full stats
   *
   * @author Matthias Pfefferle
   * @param YiidActivty $pYiidActivtiy
   */
  public static function feed($pYiidActivity) {
    self::feedActivityStats($pYiidActivity);
  }
  
  public static function feedActivityStats($pYiidActivity) {
    $dm = MongoManager::getStatsDM();
    $url = strtolower($pYiidActivity->getUrl());
    $host = parse_url($url, PHP_URL_HOST);
    $day = new MongoDate(strtotime(date("Y-m-d", $pYiidActivity->getC())));
    $hourOfDay = date("G", strtotime("now"));
    
    #$ass = new ActivityStats();
    #$ass->setDay($day);
    #$ass->setHost($host);
       
    #$dm->persist($ass);
    #$dm->flush();
    
    $query = $dm->createQueryBuilder('Documents\ActivityStats')
       ->findAndUpdate()
       ->upsert()
       // Select by these
       ->field('day')->equals($day)
       ->field('host')->equals($host)
       // Update these
       
       // Likes
       ->field('likes')->inc(1)
       
       ->field('services.facebook.l')->inc(1)
       
       ->field('services.twitter.l')->inc(1)
       ->field('services.google.l')->inc(1)
       ->field('services.linkedin.l')->inc(1)
       
       // Clickbacks
       ->field('clickbacks')->inc(1)
       ->field('services.facebook.cb')->inc(1)
       ->field('services.twitter.cb')->inc(1)
       ->field('services.google.cb')->inc(1)
       ->field('services.linkedin.cb')->inc(1)
       
       // Media Penetration
       ->field('media_penetration')->inc(1)
       ->field('services.facebook.mp')->inc(1)
       ->field('services.twitter.mp')->inc(1)
       ->field('services.google.mp')->inc(1)
       ->field('services.linkedin.mp')->inc(1)
       
       ->field('h.'.$hourOfDay)->inc(1)
       
       // Fire
       ->getQuery()
       ->execute();

    #var_dump($o->hasNext());
    /*
    $dm->createQueryBuilder('Documents\ActivityStats')
       ->field('day')->equals($day)
       ->field('host')->equals($host)
       ->field('likes')->inc(1)
       ->getQuery()
       ->execute();
    */
    /*
    $stats = $dm->getRepository('ActivityStats')->findOneBy(
      array(
        'day' => $day,
        'host' => $host
    ));
    */
    
  }

}
