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

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $configuration = ProjectConfiguration::getApplicationConfiguration($options['application'], $options['env'], true);
    sfContext::createInstance($configuration);
    $databaseManager = new sfDatabaseManager($this->configuration);
    $databaseManager->loadConfiguration();
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();
    
    $lUserHugo = UserTable::retrieveByUsername('hugo');
    $lHugoOis = $lUserHugo->getOnlineIdentitesAsArray();

    $lCommunityTwitter = CommunityTable::retrieveByCommunity('twitter');
    $lCommunityFb = CommunityTable::retrieveByCommunity('facebook');

    $lOiHugoTwitter = OnlineIdentityTable::retrieveByAuthIdentifier('http://twitter.com/account/profile?user_id=21092406', $lCommunityTwitter->getId());
    
    $this->dispatcher->connect('deal.changed', array('DealListener', 'updateMongoDeal'));
    $deal = DealTable::getInstance()->findByDescription('snirgel approved description');
    $deal[0]->approve();
        
    YiidActivityTable::saveLikeActivitys($lUserHugo->getId(),
                                         'http://www.snirgel.de',
                                         array($lOiHugoTwitter->getId()), 
                                         1, 
                                         'like', 
                                         'www.snirgel.de deal title', 
                                         'www.snirgel.de description',
                                         null,
                                         null,
                                         null);

    $this->dispatcher->connect('deal.changed', array('DealListener', 'updateMongoDeal'));
    $deal = DealTable::getInstance()->findByDescription('notizblog approved description');
    $deal[0]->approve();

    YiidActivityTable::saveLikeActivitys($lUserHugo->getId(),
                                         'http://notizblog.org',
                                         array($lOiHugoTwitter->getId()), 
                                         1, 
                                         'like', 
                                         'notizblog.org deal title', 
                                         'notizblog.org description',
                                         null,
                                         null,
                                         "geekstuff");

    $this->dispatcher->connect('deal.changed', array('DealListener', 'updateMongoDeal'));
    $deal = DealTable::getInstance()->findByDescription('missmotz approved description');
    $deal[0]->approve();

    YiidActivityTable::saveLikeActivitys($lUserHugo->getId(),
                                         'http://www.missmotz.de',
                                         array($lOiHugoTwitter->getId()), 
                                         1, 
                                         'like', 
                                         'www.missmotz.de deal title', 
                                         'www.missmotz.de description',
                                         null,
                                         null,
                                         "schuhe,hemden");
    
  }
}
