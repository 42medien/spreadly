<?php use_helper('Avatar'); ?>
<?php $count = 1; ?>
<ul class="icons">
   <?php foreach($pFriends as $lUserId) { ?>
     <?php $lUser = UserTable::getInstance()->find($lUserId); ?>
     <li <?php if ($count >= 3) { echo 'class="last"'; } ?>><?php echo avatar_tag($lUser->getDefaultAvatar(), 30, array('alt' => $lUser->getFullname(), 'title' => $lUser->getFullname(), 'class' => '', 'rel' => '')); ?></li>
     <?php $count++ ?>
   <?php } ?>
</ul>