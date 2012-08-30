	<ul>
		<?php if($pService == 'static') { ?>
			<li><?php include_partial('configurator/widget_static', array('pUrl' => $pUrl)); ?></li>
		<?php } else {?>
			<li><?php include_partial('configurator/widget_like', array('pUrl' => $pUrl)); ?></li>
			<li class="last">
				<?php include_partial('configurator/widget_full', array('pUrl' => $pUrl)); ?>
				<img src="img/dummy_friend_list.png" id="social_avatars" />
			</li>
		<?php } ?>
	</ul>
