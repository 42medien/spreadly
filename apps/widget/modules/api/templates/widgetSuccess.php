<?php use_helper('Text'); ?>
<!doctype html>
<html>
<head>
	<meta charset=utf-8 >
	<title>Spreadly Widget</title>
  
  <style type="text/css">
  body {
    font-family: Arial, Helvetica, sans-serif;
    margin: 0;
  }
  header {
    position: relative;
    width: 100%;
  }
  h1 {
    font-size: 14px;
    border-bottom: 1px solid #ccc;
    padding: 7px;
    margin: 0;
  }
  h1 span {
    font-weight: normal;
    font-size: 12px;
  }
  a {
    text-decoration: none;
    color: inherit;
  }
  a:hover {
    text-decoration: underline;
  }
  h2 {
    text-align: right;
    font-size: 12px;
    color: #aaaaaa;
    font-weight: normal;
    padding: 7px;
    margin: 0px;
  }
  .spreadly-button {
    position: absolute;
    top: 0;
    right: 0;
  }
  #container {
    width: 100%;
    position: relative;
    top: 0;
  }
  #top-urls {
    position: absolute;
    top: 0;
    left: 0;
    width: 340px;
    font-size: 12px;
  }
  #latest-sharer {
    position: absolute;
    top: 0;
    right: 0;
    width: 180px;
  }
  table {
    width: 100%;
    padding: 0px;
    margin: 0px;
    border-spacing: 0;
  }
  th {
    font-weight: normal;
    font-size: 12px;
    color: #aaaaaa;
    width: 100%;
    text-align: right;
  }
  td {
    border-bottom: 1px solid #cccccc;
  }
  td, th {
    padding: 7px;
  }
  ul {
    padding: 0px;
    padding-right: 10px;
    margin: 0px;
    list-style-type: none;
  }
  li {
    float: right;
    padding: 0px 0px 6px 6px;
    margin: 0px;
    width: 48px;
    height: 48px;
    overflow: hidden;
    overflow-x: hidden;
    overflow-y: hidden;
  }
  li img {
    width: 48px;
  }
  .left-box {
    border-right: 1px solid #cccccc;
  }
  .right-box {
    margin: 0 auto;
  }
  .counter {
    text-align: right;
  }
  </style>
</head>
<body>
  <header>
    <h1><a href="http://spreadly.com/" target="_blank" title="Get your own sharing-button!">Spreadly <span>- Social Sharing</span></a></h1>
    <iframe class="spreadly-button" src="//button.spread.local/?url=<?php echo urlencode($url); ?>&amp;social=0" style="overflow:hidden; width: 150px; height: 30px; padding: 0px;" frameborder="0" scrolling="no" marginheight="0" allowTransparency="true"></iframe>
  </header>
  
  <div id="container">
    <div id="top-urls">
      <div class="box left-box">
        <h2>latest shares</h2>
        <table>
          <tbody>
            <?php foreach ($urls as $url) { ?>
            <tr class="even">
              <td><?php echo link_to(truncate_text($url->getTitle() . " - " . $url->getUrl(), 50, "..."), $url->getUrl(), array("target" => "_top", "title" => $url->getUrl())); ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
    <div id="latest-sharer">
      <div class="box right-box">
        <h2>latest sharer</h2>
        <ul>
          <?php
            foreach ($activities as $activity) {
              $user = $activity->getUser();
          ?>
          <li>
            <a href="<?php echo $user->getProfileUrl(); ?>" title="<?php echo $user->getFullname(); ?>" >
              <img src="<?php echo $user->getAvatar(); ?>" alt="<?php echo $user->getFullname(); ?>" />
            </a>
          </li>
          <?php } ?>
        </ul>
      </div>
    </div>
  </div>
  
  <footer>
    
  </footer>
</body>
</html>