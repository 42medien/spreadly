<?php for($i=0;$i<7;$i++) { ?>
	<li class="clearfix">
		<div class="so_share_image left"><?php echo image_tag('/img/global/yiid-logo.png', array('width' => 30)); ?></div>
		<div class="so_share_information left">
		  <span class="icon_small_service icon_small_facebook">&nbsp;</span> 
		  <?php echo link_to('Billy Brown', '@homepage', array('class' => 'text_important')); ?>
		  <span class="url">via Twitter 2 minutes ago</span>
		  <p class="so_comment">lorem ipsum pfefferle affenkopf</p>
		</div>
	</li>
<?php } ?>	

<div class="right right_shares_pager">
  <a href="#" id="item-stream-pager-link" class="pager_load_more" data-obj='{"action":"stream/get_item_detail_stream", "callback":"ItemDetailStream.show", "case":"all", "itemid":"1", "page":"1"}'>Load more...</a>
</div>