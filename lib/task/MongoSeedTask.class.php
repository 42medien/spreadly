<?php

class MongoSeedTask extends sfBaseTask
{
  protected function configure()
  {
    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'statistics'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      // add your own options here
      new sfCommandOption('count', null, sfCommandOption::PARAMETER_OPTIONAL, 'The number of documents created in MongoDB.', 1000),
      new sfCommandOption('hosts', null, sfCommandOption::PARAMETER_OPTIONAL, 'The comma separated hosts to use as test data in MongoDB', "bim.bo,snirgel.de,www.snirgel.de"),
      new sfCommandOption('drop', null, sfCommandOption::PARAMETER_OPTIONAL, 'Drop the MongoDB collections.', true),
    ));

    $this->namespace        = 'yiid';
    $this->name             = 'mongo-testdata';
    $this->briefDescription = 'Generates mongo testdata for statistics in development';
    $this->detailedDescription = <<<EOF
The [MongoSeed|INFO] generates mongo testdata for statistics in development.
Call it with:

  [php symfony yiid-generate:mongo-testdata|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // add your code here
    $configuration = ProjectConfiguration::getApplicationConfiguration($options['application'], $options['env'], true);
    date_default_timezone_set('Europe/Berlin');
    $db = new Mongo(sfConfig::get('app_mongodb_host'));
    $this->hosts = explode(',', $options['hosts']);
    $this->entries = $options['count'];
    $this->drop = $options['drop'];
    $this->log("Creating ".$this->entries." entries in MongoDB ...");
    $this->createActivitiesData($db);
    $this->createPiData($db);
    $this->createChartData($db);
  }
  
  private function createActivitiesData($db) {
    $activitiesCol = $db->selectCollection(sfConfig::get('app_mongodb_database_name_stats'), "analytics.activities");
    if($this->drop) $activitiesCol->drop();

    $i = 0;
    while ($i < $this->entries) {
      $host = $this->hosts[mt_rand(0,2)];
      $path = mt_rand(1000,9999);
      $activitiesCol->insert(array(
          'host' => $host,
          'url' => "http://".$host."/my/url/".$path,
          'date' => $this->randomDate(),
          'pos' => mt_rand(1,2)%2==0 ? true : false,
          'verb' => mt_rand(1,2)%2==0 ? 'like' : 'dislike',
          'gender' => mt_rand(1,2)%2==0 ? 'm' : 'f',
          'user_id' => mt_rand(1,1000000),
          'ya_id' => mt_rand(1,1000000),
          'age' => mt_rand(14,65),
          'zip' => "".mt_rand(10000,99999),
          'rel' => mt_rand(1,2)%2==0 ? 'single' : 'married',
          'cb' => array(
            array('name' => 'facebook', 'ya_id' => mt_rand(1,1000000)),
          ),
          'oi' => array(
            array('name' => 'facebook', 'cnt' => mt_rand(1,200)),
            array('name' => 'linkedin', 'cnt' => mt_rand(1,200)),
            array('name' => 'google', 'cnt' => mt_rand(1,200)),
            array('name' => 'twitter', 'cnt' => mt_rand(1,200))
          )
      ));
      $i++;
    }
  }

  private function randomDate() {
    $rnd = mt_rand(1,31);
    $day = $rnd < 10 ? '0'.$rnd : $rnd;
    $rnd = mt_rand(6,11);
    $month = $rnd < 10 ? '0'.$rnd : $rnd;

    return new MongoDate(strtotime("2010-".$month."-".$day." 00:00:00"));
  }

  private function createPiData($db) {
    foreach ($this->hosts as $host) {
      $col = $db->selectCollection(sfConfig::get('app_mongodb_database_name_stats'), str_replace('.', '_', $host).".analytics.pis");
      if($this->drop) $col->drop();

      $i = 0;
      while ($i < $this->entries) {
        $path = mt_rand(10,15);
        $yiid_user = mt_rand(1,2)%2==0 ? true : false;
        $clickback = (!$yiid_user&&mt_rand(1,2)%2==0) ? true : false;
        $doc = array(
          'url' => "http://".$host."/my/url/".$path,
          'date' => $this->randomDate()
        );
        $update = array('$inc' => array(
          "total" => 1,
          "yiid" => $yiid_user ? 1 : 0,
          "cb" => $clickback ? 1 : 0));

        $col->update($doc, $update, array("upsert" => true));

        $i++;
      }
    }
  }

  private function createChartData($db) {
    foreach ($this->hosts as $host) {
      $col = $db->selectCollection(sfConfig::get('app_mongodb_database_name_stats'), str_replace('.', '_', $host).".analytics.charts");
      if($this->drop) $col->drop();

      $i = 0;
      while ($i < $this->entries) {
        $path = mt_rand(10,15);
        $doc = array(
          'url' => "http://".$host."/my/url/".$path,
          'date' => $this->randomDate()
        );
        $fb_pos = mt_rand(0,1)%2==0 ? true : false;
        $fb_cb = mt_rand(0,1)%2==0 ? true : false;
        $fb_cnt = mt_rand(0,1)%2==0 ? true : false;

        $tw_pos = mt_rand(0,1)%2==0 ? true : false;
        $tw_cb = mt_rand(0,1)%2==0 ? true : false;
        $tw_cnt = mt_rand(0,1)%2==0 ? true : false;

        $li_pos = mt_rand(0,1)%2==0 ? true : false;
        $li_cb = mt_rand(0,1)%2==0 ? true : false;
        $li_cnt = mt_rand(0,1)%2==0 ? true : false;

        $gl_pos = mt_rand(0,1)%2==0 ? true : false;
        $gl_cb = mt_rand(0,1)%2==0 ? true : false;
        $gl_cnt = mt_rand(0,1)%2==0 ? true : false;

        $demografics_gender = mt_rand(0,2);
        $demografics_relationship = mt_rand(0,7);
        $demografics_age = mt_rand(0,4);

        $update = array('$inc' => array(
          "s.facebook.pos" => ($fb_pos ? 1 : 0)*5,
          "s.facebook.neg" => (!$fb_pos ? 1 : 0)*2,
          "s.facebook.cb" => $fb_cb ? 1 : 0,
          "s.facebook.cnt" => ($fb_cnt ? 1 : 0)*130,

          "s.twitter.pos" => ($tw_pos ? 1 : 0)*2,
          "s.twitter.neg" => !$tw_pos ? 1 : 0,
          "s.twitter.cb" => $tw_cb ? 1 : 0,
          "s.twitter.cnt" => ($tw_cnt ? 1 : 0)*66,

          "s.linkedin.pos" => $li_pos ? 1 : 0,
          "s.linkedin.neg" => !$li_pos ? 1 : 0,
          "s.linkedin.cb" => $li_cb ? 1 : 0,
          "s.linkedin.cnt" => ($li_cnt ? 1 : 0)*82,

          "s.google.pos" => $gl_pos ? 1 : 0,
          "s.google.neg" => !$gl_pos ? 1 : 0,
          "s.google.cb" => $gl_cb ? 1 : 0,
          "s.google.cnt" => ($gl_cnt ? 1 : 0)*14,

          "d.sex.m" => $demografics_gender==0 ? 1 : 0,
          "d.sex.f" => $demografics_gender==1 ? 1 : 0,
          "d.sex.u" => $demografics_gender==2 ? 1 : 0,

          // IdentityHelper::USER_RELATIONSHIP_STATUS_SINGLE
          "d.rel.singl" => ($demografics_relationship==0 ? 1 : 0)*10,
          // IdentityHelper::USER_RELATIONSHIP_STATUS_ENGAGED
          "d.rel.eng" => ($demografics_relationship==1 ? 1 : 0)*2,
          // IdentityHelper::USER_RELATIONSHIP_STATUS_COMPLICATED
          "d.rel.compl" => ($demografics_relationship==2 ? 1 : 0)*3,
          // IdentityHelper::USER_RELATIONSHIP_STATUS_MARRIED
          "d.rel.mar" => ($demografics_relationship==3 ? 1 : 0)*4,
          // IdentityHelper::USER_RELATIONSHIP_STATUS_IN_RELATIONSHIP
          "d.rel.rel" => ($demografics_relationship==4 ? 1 : 0)*8,
          // IdentityHelper::USER_RELATIONSHIP_STATUS_IN_OPEN_RELATIONSHIP
          "d.rel.ior" => $demografics_relationship==5 ? 1 : 0,
          // IdentityHelper::USER_RELATIONSHIP_STATUS_WIDOWED
          "d.rel.wid" => $demografics_relationship==6 ? 1 : 0,
          // Unknown
          "d.rel.u" => $demografics_relationship==7 ? 1 : 0,

          "d.age.u_18" => ($demografics_age==0 ? 1 : 0)*2,
          "d.age.b_18_24" => ($demografics_age==1 ? 1 : 0)*4,
          "d.age.b_25_34" => ($demografics_age==2 ? 1 : 0)*3,
          "d.age.b_35_54" => $demografics_age==3 ? 1 : 0,
          "d.age.o_55" => $demografics_age==4 ? 1 : 0,
        ));

        $col->update($doc, $update, array("upsert" => true));
        $i++;
      }
    }
  }

}
