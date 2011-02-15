<?php include("buttonheader.php"); ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>spread.ly</title>
  <!--[if lte IE 6]>
    <style type="text/css">a { behavior: url(./../js/widget/iepngfix.htc); }</style>
  <![endif]-->
  <style type="text/css">
  * { margin: 0; padding: 0; }

  a.button {
    cursor: pointer;
    display: block;
    width: 101px;
    height: 22px;
    line-height: 22px;
    position: relative;
    overflow: hidden;
    color: #782a4f;
    font-size: 10px;
    text-decoration: none;
  }
  a.button span {
    position: absolute;
    display: block;
    height: 22px;
    background: transparent url('/img/sprites/spreadly_button_sprite.png') no-repeat scroll 0 0;
    font-family: Tahoma, Verdana, Arial, sans-serif;
  }
  a.button span.like {
    width: 60px;
    left: 0;
  }
  a.button span.count {
    width: 41px;
    left: 60px;
    text-align: center;
    background-position: 0 -600px;
  }
  a.button span.like:hover {
    background-position: 0 -100px;
  }
  a.button.disabled span.like {
    background-position: 0 -200px;
  }
  a.deal span.like {
    background-position: 0 -300px;
  }
  a.deal span.like:hover {
    background-position: 0 -400px;
  }
  a.deal.disabled span.like {
    background-position: 0 -500px;
  }
  div.text {
    position: absolute; 
    top: 0; 
    font-family: Tahoma, Verdana, Arial, sans-serif;
    line-height: 22px; 
    color: #444;
    font-size: 10px; 
    left: 110px;
    white-space: nowrap;
  }
  </style>
</head>
<body>
  <a href="<?php echo $lPopupUrl ?>" rel="like" onclick="window.open(this.href, 'popup', 'width=580,height=435,scrollbars=no,toolbar=no,status=no,resizable=no,menubar=no,location=0,directories=no,top=150,left=150'); return false;" class="button <?php echo $pButtonClass; ?>"><span class="like">&nbsp;</span><span class="count"><?php echo intval($pSocialObjectArray['l_cnt']) ?></span></a>
  <?php if($lActiveDeal): ?>
    <div class="text"><?php echo $lActiveDeal['button_wording']; ?></div>
  <?php endif; ?>
</body>
</html>