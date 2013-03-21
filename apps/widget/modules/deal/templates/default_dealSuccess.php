<h1 class="title"><?php echo __("Your share &amp; bookmark was successful!"); ?></h1>
<div class="clear"></div>

<div class="red_bg_sh">
  <div class="red_bg no_deals">
    <div class="mid_text">
      <p>
        <script language="javascript" type="text/javascript">
          var shopid = "e61af732b11d5acd6334147b22bec82c";
          var transactionid = "<?php echo $hash; ?>";
          var salt = Math.random();
          document.write('<script type="text/javascript" src="'
            + document.location.protocol
            + '//api.kunden-bonus.de/?'
            + 'sh=' + shopid
            + '&tr=' + transactionid
            + '&s=' + salt + '"><\/script>');
        </script>
        
        <div class="clear"></div>
      </p>
    </div>
  </div>
</div>