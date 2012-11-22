<?php

/**
 * domain_settings actions.
 *
 * @package    yiid
 * @subpackage domain_settings
 * @author     Matthias Pfefferle
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class domain_settingsActions extends sfActions
{
  /**
   * Executes index action
   *
   * @param sfRequest $request A request object
   */
  public function executeIndex(sfWebRequest $request) {
		$this->domain_settings = MongoManager::getDm()->getRepository('Documents\DomainSettings')->findOrdered(100);
  }
}
