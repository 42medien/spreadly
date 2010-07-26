<?php
require_once(dirname(__FILE__).'/../../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('platform', 'batch', false);
sfContext::createInstance($configuration);


$lUserHugo = UserTable::retrieveByUsername('hugo');
$lUserHans = UserTable::retrieveByUsername('hans');

$lCommunityTwitter = CommunityTable::retrieveByCommunity('twitter');
$lCommunityFb = CommunityTable::retrieveByCommunity('facebook');

$lOiHansTwitter = OnlineIdentityTable::retrieveByIdentifier('hans_twitter', $lCommunityTwitter->getId());
$lOiHansFb = OnlineIdentityTable::retrieveByIdentifier('hans_fb', $lCommunityFb->getId());

$lOiHugoTwitter = OnlineIdentityTable::retrieveByIdentifier('hugo_twitter', $lCommunityTwitter->getId());
$lOiHugoFb = OnlineIdentityTable::retrieveByIdentifier('hugo_fb', $lCommunityFb->getId());

$lOiKarlTwitter = OnlineIdentityTable::retrieveByIdentifier('karl_twitter', $lCommunityTwitter->getId());

$lObject = SocialObjectTable::createSocialObject('http://affen.de', null, 'affen title', 'affen description', null);
$lObject->updateObjectOnLikeActivity(array($lOiHansTwitter->getId()), 'http://nochmehraffen.com', 1);
$lObject->updateObjectOnLikeActivity(array($lOiKarlTwitter->getId()), 'http://nochmehraffen.com', 1);
$lObject->updateObjectOnLikeActivity(array($lOiHugoFb->getId()), 'http://nochmehraffen.com', 1);


$lObject2 = SocialObjectTable::createSocialObject('http://keineaffen.de', 'http://bim.bo', 'bim.bo title', 'bim.bo description', null);
$lObject2->updateObjectOnLikeActivity(array($lOiHansFb->getId()), 'http://bim.bo', 1);

$lObject3 = SocialObjectTable::createSocialObject('http://spiegel.de', null, 'spiegel.de title', 'spiegel.de description', null);
$lObject3->updateObjectOnLikeActivity(array($lOiKarlTwitter->getId(), $lOiHugoTwitter->getId()), 'http://spiegel.de', 1);
$lObject3->updateObjectOnLikeActivity(array($lOiHansTwitter->getId()), 'http://nochmehraffen.com', 1);

$lObject4 = SocialObjectTable::createSocialObject('http://snirgel.de', null, 'snirgel.de title', 'snirgel.de description', null);
$lObject4->updateObjectOnLikeActivity(array($lOiKarlTwitter->getId(), $lOiHugoTwitter->getId()), 'http://snirgel.de', -1);
$lObject4->updateObjectOnLikeActivity(array($lOiKarlTwitter->getId()), 'http://snirgel.de', 1);
$lObject4->updateObjectOnLikeActivity(array($lOiHugoFb->getId()), 'http://snirgel.de', -1);

$lObject5 = SocialObjectTable::createSocialObject('http://der-fusssballblogger.de', null, 'fussball title', 'fussball description', null);
$lObject5->updateObjectOnLikeActivity(array($lOiKarlTwitter->getId(), $lOiHugoTwitter->getId()), 'http://der-fusssballblogger.de', 1);
$lObject5->updateObjectOnLikeActivity(array($lOiHansTwitter->getId()), 'http://der-fusssballblogger.de', -1);



?>