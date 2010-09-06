<?php include_component('components', 'error_msg') ?>
<?php include_component('components', 'info_msg') ?>
<div class="clearfix">
  <div class="robo-404">&nbsp;</div>
  <div class="content-404">
    <h2><?php //echo __('ERROR_404_HEADLINE')?></h2>
    <?php echo image_tag('/img/robo/error404.gif')?>
    <div class="rounded-corner-box">
       <div class="rounded-corner-top"><div></div></div>
          <div class="rounded-corner-content">
              <?php echo __('ERROR_404_NOTFOUND')?>
         </div>
       <div class="rounded-corner-bottom"><div></div></div>
    </div>
   <span class="contact-404"><?php echo __('ERROR_404_CONTACT',array('%1'=>link_to(__('ERROR_404_CONTACT_LINK'), 'static/contactform')));?></span>
   <span class="search-404"><?php echo __('ERROR_404_SEARCH',array('%1'=>link_to(__('ERROR_404_SEARCH_LINK'), 'search/index')));?></span>                
  </div>
</div>