<?php use_helper("CustomTags"); ?>
<div class="page-header">
  <?php include_component("shares", "global_order_by"); ?>
  <h1><?php echo __("Global Share-Stream"); ?> <small><?php echo $activities->getNbResults()." ".__("Results"); ?></small></h1>
</div>

<div class="row">
  <?php include_component("shares", "pager", array("pager" => $activities)); ?>
</div>

<hr />

<?php foreach ($activities->getResults() as $activity) { ?>
  <div class="row">
    <div class="span2">
      <?php if ($activity->getThumb()) { ?>
      <div class="thumbnail"><img src="<?php echo $activity->getThumb(); ?>" /></div>
      <?php } else { ?>
      &nbsp;
      <?php } ?>
    </div>
    <div class="span7">
      <h2><?php echo $activity->getTitle(); ?></h2>
      <p><strong><?php echo $activity->getDescr(); ?></strong></p>
      <?php if ($activity->getComment()) { ?>
        <p><i class="icon-comment"></i> <?php echo $activity->getComment(); ?></p>
      <?php } ?>
      <p><i class="icon-time"></i> <?php echo date("d.m.Y / H:i", $activity->getC()); ?></p>
      <p><i class="icon-user"></i> <?php echo $activity->getUser()->getFullname(); ?></p>
      <p><i class="icon-external-link"></i> <?php echo link_to($activity->getUrl(), $activity->getUrl(), array("target" => "_blank")); ?></p>
      <?php if ($activity->getTags()) { ?>
        <i class="icon-tags"></i> <?php echo simple_tag_list($activity->getTags(), array("separator" => ","), "shares/index?t="); ?>
      <?php } ?>
      
      <div id="disqus_thread"></div>
      <script type="text/javascript">
          /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
          var disqus_shortname = 'myspreadly'; // required: replace example with your forum shortname
          var disqus_identifier = '<?php echo $activity->getId(); ?>';
          var disqus_developer = 1; // developer mode is on

          /* * * DON'T EDIT BELOW THIS LINE * * */
          (function() {
              var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
              dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
              (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
          })();
      </script>
      <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
      <a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>
    </div>
    <div class="span3">
      <table class="table table-bordered table-striped table-condensed">
        <thead>
          <tr>
            <th><i class="icon-bar-chart"></i> Stats</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><a rel="tooltip" title="<?php echo __("How many people have potentially seen this share."); ?>" href="#"><?php echo __("Reach") ?></a></td>
            <td><span class="badge badge-success"><?php echo $activity->getAnalyticsActivity()->getMediaPenetration(); ?></span></td>
          </tr>
          <tr>
            <td><a rel="tooltip" title="<?php echo __("How many people clicked on one of your shares."); ?>" href="#"><?php echo __("Clickbacks"); ?></a></td>
            <td><?php echo $activity->getCb()?$activity->getCb():0; ?></td>
          </tr>
          <tr>
            <td><a rel="tooltip" title="<?php echo __("To how many networks you have shared this link."); ?>" href="#"><?php echo __("Spreads"); ?></a></td>
            <td><?php echo $activity->getAnalyticsActivity()->getShares(); ?></td>
          </tr>
        </tbody>
      </table>
      <?php echo __("More %s stats", array("%s" => link_to($activity->getHost(), "@host_stats?id=".$activity->getSocialObject()->getId()))); ?>
    </div>
  </div>
  <hr />
<?php } ?>

<div class="row">
  <?php include_component("shares", "global_pager", array("pager" => $activities)); ?>
</div>