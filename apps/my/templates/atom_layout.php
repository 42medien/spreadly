<?php header('Content-Type: application/atom+xml; charset=UTF-8'); ?>
<?php echo '<?xml version="1.0" encoding="UTF-8"?>'."\n"; ?>
<feed xml:lang="en"
      xml:base="<?php echo $sf_request->getUri(); ?>"
      xmlns="http://www.w3.org/2005/Atom"
      xmlns:activity="http://activitystrea.ms/spec/1.0/"
      xmlns:media="http//purl.org/syndication/atommedia">
  <link rel="self" type="application/atom+xml" href="<?php echo $sf_request->getUri(); ?>" />
  <link rel="hub" href="http://pubsubhubbub.appspot.com/" />
  <generator uri="http://spread.ly/">Spreadly</generator>
  <activity:service>
	  <title>Spreadly</title>
	  <link rel="icon" href="http://spread.ly/favicon.ico" />
	  <link rel="alternate" href="http://spread.ly/" />
  </activity:service>

  <?php echo $sf_content ?>
</feed>