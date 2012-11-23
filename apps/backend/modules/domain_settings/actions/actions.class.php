<?php

/**
 * domain_settings actions.
 *
 * @package    yiid
 * @subpackage domain_settings
 * @author     Matthias Pfefferle
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class domain_settingsActions extends sfActions {

  /**
   * Executes index action
   *
   * @param sfRequest $request A request object
   */
  public function executeIndex(sfWebRequest $request) {
		$this->search = $request->getParameter("search", null);
		$this->domain_settings = MongoManager::getDm()->getRepository('Documents\DomainSettings')->findOrdered(100, $this->search);
  }

  /**
   * Executes edit action
   *
   * @param sfRequest $request A request object
   */
	public function executeEdit(sfWebRequest $request) {
		$id = null;
		
		if ($request->isMethod("POST")) {
			$domain_settings_array = $request->getParameter("domain_settings");
			
			$domain_settings = MongoManager::getDm()->getRepository('Documents\DomainSettings')->findOneBy(array("id" => $domain_settings_array["id"]));
			
			if (!$domain_settings) {
				$this->redirect("domain_settings/index");
			}
			
			if (array_key_exists("disable_ads", $domain_settings_array)) {
				$domain_settings->setDisableAds(true);
			} else {
				$domain_settings->setDisableAds(false);
			}
			
			if (isset($domain_settings_array["mute"]) && is_numeric($domain_settings_array["mute"])) {
				$domain_settings->setMute($domain_settings_array["mute"]);
			}
			
			$domain_settings->save();
			
			$id = $domain_settings_array["id"];
		}
		
		if (!$id) {
			$id = $request->getParameter("id");
		}
		
		$this->domain_setting = MongoManager::getDm()->getRepository('Documents\DomainSettings')->findOneBy(array("id" => $id));
	}
	
  /**
   * Executes create action
   *
   * @param sfRequest $request A request object
   */
	public function executeCreate(sfWebRequest $request) {
		if ($request->isMethod("POST")) {
			$domain_settings_array = $request->getParameter("domain_settings");
			
			$domain_settings = new Documents\DomainSettings();
			
			if ($domain_settings_array["domain"]) {
				$domain_settings->setDomain($domain_settings_array["domain"]);
			} else {
				$this->redirect("domain_settings/index");
			}
			
			if (array_key_exists("disable_ads", $domain_settings_array)) {
				$domain_settings->setDisableAds(true);
			} else {
				$domain_settings->setDisableAds(false);
			}
			
			if ($domain_settings_array["mute"] && is_numeric($domain_settings_array["mute"])) {
				$domain_settings->setMute($domain_settings_array["mute"]);
			}
			
			$domain_settings->save();
			
			$this->redirect("domain_settings/index");
		}
	}
}
