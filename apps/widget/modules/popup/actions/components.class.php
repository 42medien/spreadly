<?php

class popupComponents extends sfComponents
{

  /**
   * component for spread_description
   *
   * @author Christian Schätzle
   *
   * @param sfWebRequest $request
   */
  public function executeSpread_description(sfWebRequest $request) {}

  /**
   * component for welcome_user
   *
   * @author Christian Schätzle
   *
   * @param sfWebRequest $request
   */
  public function executeWelcome_user(sfWebRequest $request) {
    $this->pUser = $this->getUser()->getUser();
  }

}
?>