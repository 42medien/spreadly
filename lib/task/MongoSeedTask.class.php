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
      new sfCommandOption('hosts', null, sfCommandOption::PARAMETER_OPTIONAL, 'The comma separated hosts to use as test data in MongoDB', "www.snirgel.de,notizblog.org,www.missmotz.de"),
      new sfCommandOption('drop', null, sfCommandOption::PARAMETER_OPTIONAL, 'Drop the MongoDB collections.', true),
      new sfCommandOption('rand', null, sfCommandOption::PARAMETER_OPTIONAL, 'Use random numbers. Do not for testing with consistent but dumb data.', true),
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
    date_default_timezone_set('Europe/Berlin');
    $db = new Mongo(sfConfig::get('app_mongodb_host'));
    $this->hosts = explode(',', $options['hosts']);
    $this->entries = $options['count'];
    $this->drop = $options['drop'];
    $this->rand = $options['rand'];
    $this->log("Using host: ".sfConfig::get('app_mongodb_host'));
    $this->log("Creating ".$this->entries." entries in MongoDB ...");
    $this->createActivitiesData($db);
    $this->createPiData($db);
    $this->createChartData($db);
    $this->createDealData($db);
    $this->createDomainSettings($db);
  }

  private function sometimesRand($from, $to) {
    if($this->rand==true) {
      return mt_rand($from, $to);
    } else {
      return $to;
    }
  }
  
  /**
   * adds some DomainSettings for testing purposes
   */
  private function createDomainSettings($db) {
    $ds = new Documents\DomainSettings();
    $ds->setDomain("blog.local");
    $ds->setMute(0);
    $ds->save();
  }

  private function sometimesRandBoolean() {
    if($this->rand==true) {
      return mt_rand(0,1)%2==0 ? true : false;
    } else {
      return true;
    }
  }

  private function createActivitiesData($db) {
    $this->log("analytics.activities in collection: ".sfConfig::get('app_mongodb_database_name_stats'));

    $activitiesCol = $db->selectCollection(sfConfig::get('app_mongodb_database_name_stats'), "analytics.activities");
    if($this->drop) $activitiesCol->drop();
    $tags = array('Schuhe', 'Hosen', 'Jacken');
    $i = 0;
    while ($i < $this->entries) {
      $host = $this->hosts[$this->sometimesRand(0,2)];
      $path = $this->sometimesRand(10,15);
      $activitiesCol->insert(array(
          'host' => $host,
          'url' => "http://".$host."/my/url/".$path,
          'title' => "$host and $path Title",
          'date' => $this->randomDate(),
          'pos' => $this->sometimesRandBoolean(),
          'verb' => $this->sometimesRandBoolean() ? 'like' : 'dislike',
          'gender' => $this->sometimesRandBoolean() ? 'm' : 'f',
          'user_id' => $this->sometimesRand(1,1000000),
          'ya_id' => $this->sometimesRand(1,1000000),
          'age' => $this->sometimesRand(14,65),
          'zip' => "".$this->sometimesRand(10000,99999),
          'rel' => $this->sometimesRandBoolean() ? 'single' : 'married',
          'tags' => array($tags[$this->sometimesRand(0,2)]),
          'cb' => array(
            array('name' => 'facebook', 'ya_id' => $this->sometimesRand(1,1000000)),
          ),
          'oi' => array(
            array('name' => 'facebook', 'cnt' => $this->sometimesRand(1,200)),
            array('name' => 'linkedin', 'cnt' => $this->sometimesRand(1,200)),
            array('name' => 'google', 'cnt' => $this->sometimesRand(1,200)),
            array('name' => 'twitter', 'cnt' => $this->sometimesRand(1,200))
          )
      ));
      $i++;
    }

    // Deals
    $i = 0;
    while ($i < $this->entries) {
      $host = $this->hosts[$this->sometimesRand(0,2)];
      $path = $this->sometimesRand(10,15);
      $activitiesCol->insert(array(
          'host' => $host,
          'url' => "http://".$host."/my/url/".$path,
          'date' => $this->randomDate(),
          'pos' => $this->sometimesRandBoolean(),
          'verb' => $this->sometimesRandBoolean() ? 'like' : 'dislike',
          'gender' => $this->sometimesRandBoolean() ? 'm' : 'f',
          'user_id' => $this->sometimesRand(1,1000000),
          'ya_id' => $this->sometimesRand(1,1000000),
          'age' => $this->sometimesRand(14,65),
          #'d_id' => $this->sometimesRand(1,3),
          'zip' => "".$this->sometimesRand(10000,99999),
          'rel' => $this->sometimesRandBoolean() ? 'single' : 'married',
          'tags' => $tags[$this->sometimesRand(0,2)],
          'cb' => array(
            array('name' => 'facebook', 'ya_id' => $this->sometimesRand(1,1000000)),
          ),
          'oi' => array(
            array('name' => 'facebook', 'cnt' => $this->sometimesRand(1,200)),
            array('name' => 'linkedin', 'cnt' => $this->sometimesRand(1,200)),
            array('name' => 'google', 'cnt' => $this->sometimesRand(1,200)),
            array('name' => 'twitter', 'cnt' => $this->sometimesRand(1,200))
          )
      ));
      $i++;
    }

  }

  private function randomDate() {
    if($this->rand==true) {
      return new MongoDate(strtotime("today " . $this->sometimesRand(-14,0) . " day"));
    } else {
      return new MongoDate(strtotime("today"));
    }
  }

  private function createPiData($db) {
    foreach ($this->hosts as $host) {
      $col = $db->selectCollection(sfConfig::get('app_mongodb_database_name_stats'), str_replace('.', '_', $host).".analytics.pis");
      if($this->drop) $col->drop();

      $i = 0;
      while ($i < $this->entries) {
        $path = $this->sometimesRand(10,15);
        $yiid_user = $this->sometimesRandBoolean();
        $clickback = (!$yiid_user&&$this->sometimesRandBoolean());
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
        $path = $this->sometimesRand(10,15);
        $doc = array(
          'url' => "http://".$host."/my/url/".$path,
          'date' => $this->randomDate()
        );
        $fb_pos = $this->sometimesRandBoolean();
        $fb_cb = $this->sometimesRandBoolean();
        $fb_cnt = $this->sometimesRandBoolean();

        $tw_pos = $this->sometimesRandBoolean();
        $tw_cb = $this->sometimesRandBoolean();
        $tw_cnt = $this->sometimesRandBoolean();

        $li_pos = $this->sometimesRandBoolean();
        $li_cb = $this->sometimesRandBoolean();
        $li_cnt = $this->sometimesRandBoolean();

        $gl_pos = $this->sometimesRandBoolean();
        $gl_cb = $this->sometimesRandBoolean();
        $gl_cnt = $this->sometimesRandBoolean();

        $schuhe_pos = $this->sometimesRandBoolean();
        $schuhe_cb = $this->sometimesRandBoolean();
        $schuhe_cnt = $this->sometimesRandBoolean();

        $hosen_pos = $this->sometimesRandBoolean();
        $hosen_cb = $this->sometimesRandBoolean();
        $hosen_cnt = $this->sometimesRandBoolean();

        $jacken_pos = $this->sometimesRandBoolean();
        $jacken_cb = $this->sometimesRandBoolean();
        $jacken_cnt = $this->sometimesRandBoolean();

        $demografics_gender = $this->sometimesRand(0,2);
        $demografics_relationship = $this->sometimesRand(0,7);
        $demografics_age = $this->sometimesRand(0,4);

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

          "t.Schuhe.pos" => ($schuhe_pos ? 1 : 0)*5,
          "t.Schuhe.neg" => (!$schuhe_pos ? 1 : 0)*1,
          "t.Schuhe.cb" => $schuhe_cb ? 1 : 0,
          "t.Schuhe.cnt" => ($schuhe_cnt ? 1 : 0)*110,

          "t.Hosen.pos" => ($hosen_pos ? 1 : 0)*4,
          "t.Hosen.neg" => (!$hosen_pos ? 1 : 0)*2,
          "t.Hosen.cb" => $hosen_cb ? 1 : 0,
          "t.Hosen.cnt" => ($hosen_cnt ? 1 : 0)*90,

          "t.Jacken.pos" => ($jacken_pos ? 1 : 0)*3,
          "t.Jacken.neg" => (!$jacken_pos ? 1 : 0)*1,
          "t.Jacken.cb" => $jacken_cb ? 1 : 0,
          "t.Jacken.cnt" => ($jacken_cnt ? 1 : 0)*30,

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

  private function createDealData($db) {
    foreach ($this->hosts as $host) {
      $col = $db->selectCollection(sfConfig::get('app_mongodb_database_name_stats'), str_replace('.', '_', $host).".analytics.deals");
      if($this->drop) $col->drop();

      $i = 0;
      while ($i < $this->entries) {
        $path = $this->sometimesRand(10,15);
        $doc = array(
          'url' => "http://".$host."/my/url/".$path,
          #'d_id' => $this->sometimesRand(1,3),
          'date' => $this->randomDate()
        );
        $fb_pos = $this->sometimesRandBoolean();
        $fb_cb = $this->sometimesRandBoolean();
        $fb_cnt = $this->sometimesRandBoolean();

        $tw_pos = $this->sometimesRandBoolean();
        $tw_cb = $this->sometimesRandBoolean();
        $tw_cnt = $this->sometimesRandBoolean();

        $li_pos = $this->sometimesRandBoolean();
        $li_cb = $this->sometimesRandBoolean();
        $li_cnt = $this->sometimesRandBoolean();

        $gl_pos = $this->sometimesRandBoolean();
        $gl_cb = $this->sometimesRandBoolean();
        $gl_cnt = $this->sometimesRandBoolean();

        $schuhe_pos = $this->sometimesRandBoolean();
        $schuhe_cb = $this->sometimesRandBoolean();
        $schuhe_cnt = $this->sometimesRandBoolean();

        $hosen_pos = $this->sometimesRandBoolean();
        $hosen_cb = $this->sometimesRandBoolean();
        $hosen_cnt = $this->sometimesRandBoolean();

        $jacken_pos = $this->sometimesRandBoolean();
        $jacken_cb = $this->sometimesRandBoolean();
        $jacken_cnt = $this->sometimesRandBoolean();

        $demografics_gender = $this->sometimesRand(0,2);
        $demografics_relationship = $this->sometimesRand(0,7);
        $demografics_age = $this->sometimesRand(0,4);

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

          "t.Schuhe.pos" => ($schuhe_pos ? 1 : 0)*5,
          "t.Schuhe.neg" => (!$schuhe_pos ? 1 : 0)*1,
          "t.Schuhe.cb" => $schuhe_cb ? 1 : 0,
          "t.Schuhe.cnt" => ($schuhe_cnt ? 1 : 0)*110,

          "t.Hosen.pos" => ($hosen_pos ? 1 : 0)*4,
          "t.Hosen.neg" => (!$hosen_pos ? 1 : 0)*2,
          "t.Hosen.cb" => $hosen_cb ? 1 : 0,
          "t.Hosen.cnt" => ($hosen_cnt ? 1 : 0)*90,

          "t.Jacken.pos" => ($jacken_pos ? 1 : 0)*3,
          "t.Jacken.neg" => (!$jacken_pos ? 1 : 0)*1,
          "t.Jacken.cb" => $jacken_cb ? 1 : 0,
          "t.Jacken.cnt" => ($jacken_cnt ? 1 : 0)*30,

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
