<?php
require_once(dirname(__FILE__).'/../../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('platform', 'batch', false);
sfContext::createInstance($configuration);


$lUserHugo = UserTable::retrieveByUsername('hugo');
$lUserHans = UserTable::retrieveByUsername('hans');
$lUserKarl = UserTable::retrieveByUsername('karl');
$lUserJames = UserTable::retrieveByUsername('james');
$lUserSnirgelchen = UserTable::retrieveByUsername('snirgelchen');
$lUserManni = UserTable::retrieveByUsername('manni');
$lUserAffe = UserTable::retrieveByUsername('affe');

$lHugoOis = $lUserHugo->getOnlineIdentitesAsArray();
$lUserHansOis = $lUserHans->getOnlineIdentitesAsArray();
$lUserKarlOis = $lUserKarl->getOnlineIdentitesAsArray();
$lUserJamesOis = $lUserJames->getOnlineIdentitesAsArray();
$lUserSnirgelchenOis = $lUserSnirgelchen->getOnlineIdentitesAsArray();
$lUserManniOis = $lUserManni->getOnlineIdentitesAsArray();
$lUserAffeOis = $lUserAffe->getOnlineIdentitesAsArray();

$lCommunityTwitter = CommunityTable::retrieveByCommunity('twitter');
$lCommunityFb = CommunityTable::retrieveByCommunity('facebook');

$lOiHansTwitter = OnlineIdentityTable::retrieveByIdentifier('hans_twitter', $lCommunityTwitter->getId());
$lOiHansFb = OnlineIdentityTable::retrieveByIdentifier('hans_fb', $lCommunityFb->getId());

$lOiHugoTwitter = OnlineIdentityTable::retrieveByIdentifier('hugo_twitter', $lCommunityTwitter->getId());
$lOiHugoFb = OnlineIdentityTable::retrieveByIdentifier('hugo_fb', $lCommunityFb->getId());

$lOiJamesFb = OnlineIdentityTable::retrieveByIdentifier('james_fb', $lCommunityFb->getId());
$lOiSnirgelchenFb = OnlineIdentityTable::retrieveByIdentifier('snirgelchen_fb', $lCommunityFb->getId());
$lOiManniFb = OnlineIdentityTable::retrieveByIdentifier('manni_fb', $lCommunityFb->getId());
$lOiAffeFb = OnlineIdentityTable::retrieveByIdentifier('affe_fb', $lCommunityFb->getId());

$lOiKarlTwitter = OnlineIdentityTable::retrieveByIdentifier('karl_twitter', $lCommunityTwitter->getId());

//$lObject = SocialObjectTable::createSocialObject('http://affen.de', null, 'affen title', 'affen description', null);

YiidActivityTable::saveLikeActivitys($lUserHugo->getId(), 'http://affen.de', $lHugoOis, array($lOiHugoTwitter->getId()), 1, 'like', 'affen title');
YiidActivityTable::saveLikeActivitys($lUserHans->getId(), 'http://affen.de', $lUserHansOis, array($lOiHansFb->getId()), 1, 'like', 'affen title');
YiidActivityTable::saveLikeActivitys($lUserKarl->getId(), 'http://affen.de', $lUserKarlOis, array($lOiKarlTwitter->getId()), 1, 'like', 'affen title');

YiidActivityTable::saveLikeActivitys($lUserHans->getId(), 'http://bim.bo', $lUserHansOis, array($lOiHansTwitter->getId()), 1, 'like', 'bimbo title');
YiidActivityTable::saveLikeActivitys($lUserJames->getId(), 'http://bim.bo', $lUserJamesOis, array($lOiJamesFb->getId()), -1, 'like', 'bimbo title');
YiidActivityTable::saveLikeActivitys($lUserSnirgelchen->getId(), 'http://bim.bo', $lUserSnirgelchenOis, array($lOiSnirgelchenFb->getId()), 1, 'like', 'bimbo title');
YiidActivityTable::saveLikeActivitys($lUserManni->getId(), 'http://bim.bo', $lUserManniOis, array($lOiManniFb->getId()), -1, 'like', 'bimbo title');
YiidActivityTable::saveLikeActivitys($lUserAffe->getId(), 'http://bim.bo', $lUserAffeOis, array($lOiAffeFb->getId()), 1, 'like', 'bimbo title');

YiidActivityTable::saveLikeActivitys($lUserHans->getId(), 'http://spiegel.de', $lUserHansOis, array($lOiHansFb->getId(), $lOiHansTwitter->getId()), 1, 'like', 'spiegel.de title title');
YiidActivityTable::saveLikeActivitys($lUserKarl->getId(), 'http://spiegel.de', $lUserKarlOis, array($lOiKarlTwitter->getId()), 1, 'like', 'spiegel.de title title');

YiidActivityTable::saveLikeActivitys($lUserHans->getId(), 'http://snirgel.de', $lUserHansOis, array($lOiHansTwitter->getId()), -1, 'like', 'snirgel.de title title');
YiidActivityTable::saveLikeActivitys($lUserKarl->getId(), 'http://snirgel.de', $lUserKarlOis, array($lOiKarlTwitter->getId()), -1, 'like', 'snirgel.de title title');
YiidActivityTable::saveLikeActivitys($lUserHugo->getId(), 'http://snirgel.de', $lHugoOis, array($lOiHugoTwitter->getId()), -1, 'like', 'snirgel.de title title');


$lObject5 = SocialObjectTable::createSocialObject('http://der-fusssballblogger.de', null, 'fussball title', 'fussball description', null);
$lObject5->updateObjectOnLikeActivity(array($lOiKarlTwitter->getId(), $lOiHugoTwitter->getId()), 'http://der-fusssballblogger.de', 1);
$lObject5->updateObjectOnLikeActivity(array($lOiHansTwitter->getId()), 'http://der-fusssballblogger.de', -1);



?>