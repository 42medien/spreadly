<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
  <style type="text/css">
  * {
    margin: 0;
    padding: 0;
  }
  #background {
    position: relative;
  }
  #button {
    position: absolute;
  }

  #background.vettel {
    background: #fff url('./bildvettel.png') no-repeat scroll top left;
    width: 1089px;
    height: 1127px;    
  }
  #background.vettel #button {
    top: 675px;
    left: 410px;
  }

  #background.galaxy {
    background: #fff url('./bildgalaxy.png') no-repeat scroll top left;
    width: 1089px;
    height: 1887px;    
  }
  #background.galaxy #button {
    top: 762px;
    left: 410px;
  }

  #background.dfb {
    background: #fff url('./bilddfb.png') no-repeat scroll top left;
    width: 1089px;
    height: 1141px;    
  }
  #background.dfb #button {
    top: 688px;
    left: 410px;
  }  
  
  </style>
  </head>
  <body>
    <div id="background" class="<?php echo in_array($_GET['style'], array('vettel', 'galaxy', 'dfb')) ? $_GET['style'] : 'vettel' ?>">
      <iframe id="button" scrolling="no" frameborder="0" allowtransparency="true" src="http://widgets.yiiddev.com/w/like/like.php?cult=de&amp;type=like&amp;url=http%3A%2F%2F<?php echo $_GET['id'] ?>.yiiddev.com&amp;title=<?php echo $_GET['id'] ?>&amp;color=%23000000&amp;social=0" style="overflow: hidden; width: 420px; height: 62px;" marginheight="0" marginwidth="0">
      </iframe>
    </div>
  </body>
</html>

