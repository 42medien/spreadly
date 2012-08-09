          <ul id="like-submit">
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