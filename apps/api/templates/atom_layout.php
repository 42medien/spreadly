<?php header('Content-Type: application/atom+xml'); ?>
<?php echo '<?xml version="1.0" encoding="UTF-8"?>'."\n"; ?>
<feed xmlns="http://www.w3.org/2005/Atom" xmlns:t="http://purl.org/syndication/thread/1.0" xmlns:activity="http://activitystrea.ms/spec/1.0/" xmlns:media="http//purl.org/syndication/atommedia">
  <title>global share stream</title>
  <link rel="self" type="application/atom+xml" href="http://api.spreadly.com/feeds/global" />
  <link rel="hub" href="http://pubsubhubbub.appspot.com/" />
  <generator uri="http://spreadly.com/">Spreadly</generator>
  <activity:service>
	  <title>Spreadly</title>
	  <link rel="icon" href="http://spreadly.com/favicon.ico" />
	  <link rel="alternate" href="http://spreadly.com/" />
  </activity:service>
  <id>tag:spreadly.com,<?php echo date("Y"); ?>:api.spreadly.com/feeds/global</id>

  <?php echo $sf_content ?>
</feed>