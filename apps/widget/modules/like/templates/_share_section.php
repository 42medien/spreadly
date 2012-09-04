<div class="sh_networks_content" id="like-submit">
<div class="add_networks" id="like-oi-list">
  <div class="networks_icon">
    <ul>
      <?php
      foreach($pIdentities as $lIdentity) {
        if (($sf_request->getParameter("module") == "deal") && ($lIdentity->getCommunity()->getName() == "flattr")) {
          continue;
        } else {
          include_partial("like/identity_selector", array("identity" => $lIdentity, "domain_profile" => $domain_profile));
        }
      }
      ?>
    </ul>
  </div>
  <div class="addnet">
    <ul>
      <li class="plusbtn">
        <ul>
          <li><a href="#" class="fb" onclick="window.open('<?php echo url_for("@signinto?service=facebook"); ?>', 'auth_popup', 'width=580,height=450,scrollbars=no,toolbar=no,status=no,resizable=no,menubar=no,location=0,directories=no,top=150,left=150'); return false;"></a></li>
          <li><a href="#" class="tw" onclick="window.open('<?php echo url_for("@signinto?service=twitter"); ?>', 'auth_popup', 'width=580,height=450,scrollbars=no,toolbar=no,status=no,resizable=no,menubar=no,location=0,directories=no,top=150,left=150'); return false;"></a></li>
          <li><a href="#" class="xg" onclick="window.open('<?php echo url_for("@signinto?service=xing"); ?>', 'auth_popup', 'width=580,height=450,scrollbars=no,toolbar=no,status=no,resizable=no,menubar=no,location=0,directories=no,top=150,left=150'); return false;"></a></li>
          <li><a href="#" class="lkd" onclick="window.open('<?php echo url_for("@signinto?service=linkedin"); ?>', 'auth_popup', 'width=580,height=450,scrollbars=no,toolbar=no,status=no,resizable=no,menubar=no,location=0,directories=no,top=150,left=150'); return false;"></a></li>
          <!--li><a href="#" class="mrwong"></a></li>
          <li><a href="#" class="yig"></a></li-->
          <li><a href="#" class="tmbl" onclick="window.open('<?php echo url_for("@signinto?service=tumblr"); ?>', 'auth_popup', 'width=580,height=450,scrollbars=no,toolbar=no,status=no,resizable=no,menubar=no,location=0,directories=no,top=150,left=150'); return false;"></a></li>
          <li><a href="#" class="fltr" onclick="window.open('<?php echo url_for("@signinto?service=flattr"); ?>', 'auth_popup', 'width=800,height=700,scrollbars=no,toolbar=no,status=no,resizable=no,menubar=no,location=0,directories=no,top=150,left=150'); return false;"></a></li>
        </ul>
      </li>
    </ul>
  </div>
</div>
<div id="popup-like-button" class="<?php if ($sf_user->isAuthenticated()) { echo 'sharebtn-active'; } else { echo 'sharebtn'; } ?>">
  <div class="sharebtn_graphic">
    <input type="<?php if ($sf_user->isAuthenticated()) { echo 'button'; } else { echo 'button'; } ?>" name="shared" value="share &amp; bookmark" />
    <span></span>
  </div>
</div>
</div>