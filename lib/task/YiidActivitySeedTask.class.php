<?php

class YiidActivitySeedTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'statistics'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = 'yiid';
    $this->name             = 'activity-testdata';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [YiidActivitySeed|INFO] task does things.
Call it with:

  [php symfony YiidActivitySeed|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array()) {
    try {
      sfContext::getInstance();
    } catch (Exception $e) {
      // aize the database connection
      $configuration = ProjectConfiguration::getApplicationConfiguration($options['application'], $options['env'], true);
      sfContext::createInstance($configuration);
    }

    $databaseManager = new sfDatabaseManager($this->configuration);
    $databaseManager->loadConfiguration();
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    $originalPostToServicesValue = sfConfig::get('app_settings_post_to_services');
    sfConfig::set('app_settings_post_to_services', 0);

    $this->log("Using mongo host: ".sfConfig::get('app_mongodb_host'));

    $lUserHugo = UserTable::retrieveByUsername('hugo');
    $lHugoOis = $lUserHugo->getOnlineIdentitesAsArray();

    $lUserJames = UserTable::retrieveByUsername('james');
    $lJamesOis = $lUserJames->getOnlineIdentitesAsArray();

    $lCommunityTwitter = CommunityTable::retrieveByCommunity('twitter');
    $lCommunityFb = CommunityTable::retrieveByCommunity('facebook');

    $lOiHugoTwitter = OnlineIdentityTable::retrieveByAuthIdentifier('http://twitter.com/account/profile?user_id=21092406', $lCommunityTwitter->getId());
    $lOiJamesFacebook = OnlineIdentityTable::retrieveByAuthIdentifier('james_fb', $lCommunityFb->getId());

    $allDeals = DealTable::getInstance()->findAll();
    foreach ($allDeals as $deal) {
      if($deal->canSubmit()) {
        $deal->submit();        
      }
    }

    $this->dispatcher->connect('deal.changed', array('DealListener', 'updateMongoDeal'));
    $deal = DealTable::getInstance()->findByDescription('snirgel approved description');
    if($deal[0]->canApprove()) {
      $deal[0]->approve();      
    }
    $deal = DealTable::getInstance()->findByDescription('notizblog approved description');
    if($deal[0]->canApprove()) {
      $deal[0]->approve();      
    }
    $deal = DealTable::getInstance()->findByDescription('missmotz approved description');
    if($deal[0]->canApprove()) {
      $deal[0]->approve();      
    }
    
    $urls = array('www.snirgel.de', 'notizblog.org', 'www.missmotz.de');
    $tags = array('geekstuff', 'otherthings', 'schuhe');
    $users = array($lUserHugo, $lUserJames);
    $services = array('facebook', 'twitter', 'linkedin', 'google');
    $dm = MongoManager::getDM();

    for ($i=0; $i < 30; $i++) { 
      $url = $this->oneOfThese($urls);
      $tag = $this->oneOfThese($tags);
      $user = $this->oneOfThese($users);
      $ra = $this->random(1000);
      $array = array(
        'url' => "http://$url/$ra",
        'url_hash' => "hash.$ra",
        'u_id' => $user->getId(),
        'oiids' => $user->getOnlineIdentitesAsArray(),
        'tags' => $tag,
        'title' => "$url title",
        'descr' => "$url description",
        'comment' => "$url comment",
        'c' => strtotime($this->random(10)." days ago"),
        'cb' => $this->randBoolean() ? $this->random(30) : 0,
        'cb_referer' => $this->oneOfThese(array('', '', '', '', '', '', '', '', '', 'http://tierscheisse.de')),
        'cb_service' => $this->oneOfThese($services)
      );
      
      $lActivity = new Documents\YiidActivity();
      $lActivity->fromArray($array);
            
      try {
        $lActivity->skipUrlCheck=true;
        $lActivity->save();
      } catch(Exception $e) {
        $this->log($e->getMessage());
      }
      
    }


    /*

    $lActivity = new Documents\YiidActivity();
    $lActivity->fromArray($array);
    $lActivity->save();

    $array = array(
      'url' => "http://$url",
      'oiids' => array($lOiJamesFacebook->getId()),
      'title' => "$url deal title",
      'descr' => "$url description",
      'comment' => "$url comment",
      'thumb' => null,
      'clickback' => null,
      'tags' => null,
      'u_id' => $lUserJames->getId()
    );

    $lActivity = new Documents\YiidActivity();
    $lActivity->fromArray($array);
    $lActivity->save();

    $this->dispatcher->connect('deal.changed', array('DealListener', 'updateMongoDeal'));
    $deal = DealTable::getInstance()->findByDescription('notizblog approved description');
    if($deal[0]->canApprove()) {
      $deal[0]->approve();      
    }


    $url = 'notizblog.org';
    $array = array(
      'url' => "http://$url",
      'oiids' => array($lOiHugoTwitter->getId()),
      'title' => "$url deal title",
      'descr' => "$url description",
      'comment' => "$url comment",
      'thumb' => null,
      'clickback' => null,
      'tags' => null,
      'u_id' => $lUserHugo->getId()
    );

    $lActivity = new Documents\YiidActivity();
    $lActivity->fromArray($array);
    $lActivity->save();

    $this->dispatcher->connect('deal.changed', array('DealListener', 'updateMongoDeal'));
    $deal = DealTable::getInstance()->findByDescription('missmotz approved description');
    if($deal[0]->canApprove()) {
      $deal[0]->approve();      
    }

    $url = 'www.missmotz.de';
    $array = array(
      'url' => "http://$url",
      'oiids' => array($lOiHugoTwitter->getId()),
      'title' => "$url deal title",
      'descr' => "$url description",
      'comment' => "$url comment",
      'thumb' => null,
      'clickback' => null,
      'tags' => "Schuhe, Hemden",
      'u_id' => $lUserHugo->getId()
    );

    $lActivity = new Documents\YiidActivity();
    $lActivity->fromArray($array);
    $lActivity->save();
    */
    
    sfConfig::set('app_settings_post_to_services', $originalPostToServicesValue);
  }
  private function random($range) {
    return mt_rand(0,$range);
  }
  private function randBoolean() {
    return mt_rand(0,1)%2==0 ? true : false;
  }
  private function oneOfThese($these) {
    return $these[mt_rand(0, count($these)-1)];
  }
}
