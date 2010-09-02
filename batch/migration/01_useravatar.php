<?php

require_once(dirname(__FILE__).'/../../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('platform', 'prod', true);

sfContext::createInstance($configuration);

$logger = sfContext::getInstance()->getLogger();

// Initialize database manager.
$dbManager = new sfDatabaseManager($configuration);
$dbManager->loadConfiguration();


/**
 *  we need all user id's first
 **/
$lQuery = Doctrine_Query::create()->from('User u')->select('u.id');
$lIds = $lQuery->fetchArray();
$lQuery->free();

/****
 *
 *
 * avatar migration
 *
 * email migration
 *
 * ..???
 */
echo "######################################### \r\n";
echo "Start migration: 01_useravatar.php \r\n";
echo "######################################### \r\n";
foreach ($lIds as $key => $value) {
  try{
	  $lUser = UserTable::getInstance()->retrieveByPk($value['id']);
	  //if user has a avatar in general
	  if ($lUser->getDefaultAvatar()) {
	    $lMainAvatar = UserAvatarTable::getMainAvatarForUserId($value['id']);
	    //check if he has an main avatar and if the current default-avatar is the main
	    if(!$lMainAvatar) {
	    	//if not: take the default-avatar-name and get the avatar-object
	      $lNewMain = UserAvatarTable::getAvatarForName($value['id'], $lUser->getDefaultAvatar());
	      //set the default-avatar to main
	      $lNewMain->setIsMain(true);
	      //and save
	      $lNewMain->save();
	      echo "--> new main-avatar with id: ".$lNewMain->getId()." for userid: ".$value['id']."\n\r";
	    }
    }
  } catch(Exception $e){
    echo $e->getMessage();
    continue;
  }
}
echo "######################################### \r\n";
echo "End migration: 01_useravatar.php \r\n";
echo "######################################### \r\n";