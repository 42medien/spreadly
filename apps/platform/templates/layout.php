<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <script type="text/javascript" src="/js/main/include/platform-<?php echo sfConfig::get('app_release_name') ?>.js"></script>
    <?php //include_javascripts() ?>
    <?php //echo cdn_javascript_tag('include/'.sfConfig::get('app_release_name').'.min.js'); ?>    
  </head>
  <body class="bg_light">
    <div id="container" class="bd_round clearfix">
      
      <div id="header" class="clearfix">
        <ul id="nav_main" class="right clearfix">
          <li><?php echo link_to('Home', '@homepage', array('id' => 'nav_home')); ?></li>
          <li><?php echo link_to('Profile', '@homepage', array('id' => 'nav_profile')); ?></li>
          <li><?php echo link_to('Settings', '@homepage', array('id' => 'nav_settings')); ?></li>
        </ul>
	    </div>
      
      <div id="content" class="clearfix">
        
        <div id="content_sub" class="left">
          <div id="photo_filter_box" class="bg_light bd_diagonal bd_normal_light clearfix">
            <div class="photo_big" id="stream_photo">
              <?php echo image_tag('/img/global/yiid-logo.png', array('width' => 96, 'height' => 96)); ?>
            </div>
          
            <form action="<?php echo url_for('@homepage'); ?>" method="post">
	            <p class="dark_rounded_right">All Networks</p>
	            <ul class="normal_list">
                <li class="clearfix"><input type="checkbox" id="check_facebook" class="left" /><label for="check_facebook" class="icon_service icon_facebook left">facebook.com</label></li>
	              <li class="clearfix"><input type="checkbox" id="check_twitter" class="left" /><label for="check_twitter" class="icon_service icon_twitter left">twitter.com</label></li>
	            </ul>
	            
	            <p class="dark_rounded_right">Friends Active</p>
              <ul class="normal_list">
                <?php for($i=0;$i<=2;$i++) { ?>
                <li class="clearfix">
                  <input type="checkbox" id="check_user<?php echo $i; ?>" class="left" />
                  <label for="check_user<?php echo $i; ?>" class="left"><?php echo image_tag('/img/global/yiid-logo.png', array('width' => 16, 'height' => 16, 'class' => 'icon_user')); ?></label>
                  <?php use_helper('Text'); ?>
                  <label for="check_user<?php echo $i; ?>" class="left text_user"><?php echo truncate_text('Matthias Affenkopf', 18, '...'); ?></label>
                </li>
                <?php } ?>
              </ul>
	            
	            <input type="submit" value="Update" class="btn right" /> 
	          </form>
          </div>
	      </div>
      
	      <div id="content_main" class="left">
          <div id="stream_left">
            <div id="stream_left_top" class="clearfix">
              <div id="stream_left_top5">
	              <div id="stream_left_top1" class="left"></div>
	              <div id="stream_left_top2" class="left"><p>What's Hot</p></div>
	              <div id="stream_left_top3" class="left"></div>
	              <div id="stream_left_top4" class="left"><p>What's Not</p></div>
                <div id="stream_left_top6" class="left"></div>
	              <div class="right">
                  <div id="stream_left_top7" class="left"></div>
		              <div id="stream_left_top8" class="left"><p>New</p></div>
		              <div id="stream_left_top9" class="left"></div>
		            </div>
	            </div>
            </div>
            
            <div id="stream_left_bottom" class="bg_light clearfix">
              <ul id="new_shares">
              <?php for($i=0;$i<15;$i++) { ?>
                <li class="clearfix">
                  <div class="so_image left">
                    <?php echo image_tag('/img/global/yiid-logo.png', array('width' => 50)); ?>
                  </div>
                  <div class="so_information left">
                    
	                  <div class="green_arrow2">
		                  
		                  <div class="clearfix">
			                  <div class="green_top_left left"></div>
			                  <div class="green_top_middle left">
			                    <div class="info_area">
			                      <div class="left so_headline_left">
						                  <span class="icon_small_service icon_small_facebook">&nbsp;</span>
						                  <?php echo link_to('Matthias Affenkopf', '@homepage', array('class' => 'text_important')); ?>
						                  <span class="url">via Twitter 2 minutes ago</span>
						                </div>
					                  <div class="right">
					                    <a href="#" class="icon_like icon_small_use">&nbsp;</a>
						                  <span class="url" id="like_so">3 like</span>
					                    <a href="#" class="icon_dislike icon_small_use">&nbsp;</a>
						                  <span class="url" id="dislike_so">3 dislike</span>
						                </div>
					                </div>
			                  </div>
			                  <div class="green_top_right left"></div>
			                </div>
	                    
		                  <div class="clearfix">   
                        <div class="green_middle_left left"></div>
                        <div class="green_middle_middle left">
                          <p class="so_comment">lorem ipsum pfefferle affenkopf lorem ipsum pfefferle affenkopf lorem ipsum pfefferle affenkopf lorem ipsum pfefferle affenkopf lorem ipsum pfefferle affenkopf lorem ipsum pfefferle affenkopf ipsum pfefferle affenkopf lorem ipsum pfefferle affenkopf lorem ipsum pfefferle affenkopf lorem ipsum pfefferle affenkopf lorem ipsum pfefferle affenkopf</p>
	                        
	                        <!-----------  Das folgende div muss auf style="display:none;" gesetzt und nur bei hover angezeigt werden ------------------------------>
	                        <div class="actions right">
	                          <a href="#" class="icon_comment icon_small_use text_action">comment</a>
	                          <a href="#" class="icon_favorite icon_small_use text_action">favorite</a>
	                          <a href="#" class="icon_hide icon_small_use text_action">hide</a>
	                        </div>
	                        <!-----------  Das vorige div muss auf style="display:none;" gesetzt und nur bei hover angezeigt werden ------------------------------>
	                        
                        </div>
	                    </div>
	                    
		                  <div class="clearfix">
		                    <div class="green_bottom_left left"></div>
		                    <div class="green_bottom_middle left"></div>
		                    <div class="green_bottom_right left"></div>
		                  </div>    
	                  </div>
                      
                  </div>
                </li>
              <?php } ?>
              </ul>
            </div>
            
          </div>
	      </div>
	      
	      <div id="content_supp" class="left">
	      
          <div>
            <form action="<?php echo url_for('@homepage'); ?>" class="clearfix" id="search" method="post">
              <input type="text" id="search1" class="left" value="Search..." />
              <input type="submit" id="search2" class="left bg_light bd_normal_light" value="&nbsp;" />
              <div id="search3" class="left"></div>
            </form>
          </div>
          
	        <div id="stream_right" class="bg_light bd_normal_light">
            <div id="so_right_view" class="clearfix">
              <div id="so_image" class="left">
                <?php echo image_tag('/img/global/yiid-logo.png', array('width' => 50)); ?>
              </div>
              <div id="so_information" class="left">
                <h3>Giant solar-powered</h3>
                <h5>
                  <?php echo link_to('http://www.youtube.com/watch/pfefferle=affenkopf', 'http://www.youtube.com/watch/pfefferle=affenkopf', array('class' => 'url')); ?>
                </h5>
                <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.</p>
              </div>
            </div>
	        
            <div id="stream_right_top" class="clearfix">
              <div id="stream_right_top7">
                <div id="stream_right_top1"></div>
                <div id="stream_right_top1b"><a href="#" class="thumb_up_down icon_thumbs">&nbsp;</a></div>
	              <div id="stream_right_top2"></div>
	              <div id="stream_right_top3"><a href="#" class="thumb_up icon_thumb">&nbsp;</a></div>
	              <div id="stream_right_top4"></div>
	              <div id="stream_right_top5"><a href="#" class="thumb_down icon_thumb">&nbsp;</a></div>
	              <div id="stream_right_top6"></div>
	            </div>
            </div>
            <div id="stream_right_bottom">
              <ul id="shares">
              <?php for($i=0;$i<7;$i++) { ?>
                <li class="clearfix">
                  <div class="so_share_image left">
                    <?php echo image_tag('/img/global/yiid-logo.png', array('width' => 30)); ?>
                  </div>
                  <div class="so_share_information left">
                    <span class="icon_small_service icon_small_facebook">&nbsp;</span>
                    <?php echo link_to('Billy Brown', '@homepage', array('class' => 'text_important')); ?>
                    <span class="url">via Twitter 2 minutes ago</span>
                    <p class="so_comment">lorem ipsum pfefferle affenkopf</p>
                  </div>
                </li>
              <?php } ?>
              </ul>
            </div>
	        </div>
	      </div>
     
      
	    </div>
      
      
    </div>
    
    <div id="footer" class="clearfix">
	    
	  </div>        
  <script type="text/javascript">
    jQuery(document).ready( function() {
      <?php include_partial('global/jsinit_general.js'); ?>
      <?php if (has_slot('js_document_ready')) { ?>
        <?php include_slot('js_document_ready'); ?>
      <?php } ?>
    });
  </script>    
  </body>
</html>