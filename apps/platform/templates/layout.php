<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php //echo cdn_javascript_tag('include/'.sfConfig::get('app_release_name').'.min.js'); ?>    
  </head>
  <body class="bg_light">
    <div id="container" class="bd_round clearfix">
      
      <div id="header" class="clearfix">
        <?php include_partial('global/main_navigation'); ?>
	    </div>
      
      <div id="content" class="clearfix">
        
        <div id="content_sub" class="left">
        
          <?php if($this->hasComponentSlot('sidebar_left_main')) { ?>
            <?php include_component_slot('sidebar_left_main'); ?>
          <?php } ?>
          
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
          
          <?php if($this->hasComponentSlot('sidebar_right_top')) { ?>
            <?php include_component_slot('sidebar_right_top'); ?>
          <?php } ?>
          
          <?php if($this->hasComponentSlot('sidebar_right_main')) { ?>
            <?php include_component_slot('sidebar_right_main'); ?>
          <?php } ?>
          
	      </div>
     
      
	    </div>
      
      
    </div>
    
    <div id="footer" class="clearfix">
	    
	  </div>
  <script type="text/javascript" src="/js/main/include/platform-<?php echo sfConfig::get('app_release_name') ?>.js"></script>
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