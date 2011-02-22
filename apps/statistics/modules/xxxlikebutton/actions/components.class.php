<?php

class likebuttonComponents extends sfComponents
{

  /**
   * component for description
   *
   * @author Christian Schätzle
   *
   * @param sfWebRequest $request
   */
  public function executeDescription(sfWebRequest $request) {
		$this->pUser = $this->getUser();
  }

	/**
	 * component for configurator
	 *
	 * @author Christian Schätzle
	 *
	 * @param sfWebRequest $request
	 */
  public function executeConfigurator(sfWebRequest $request) {

  }

  /**
   * component for configurator description
   *
   * @author Christian Schätzle
   *
   * @param sfWebRequest $request
   */
  public function executeConfigurator_desc(sfWebRequest $request) {

  }

  public function executeChoose_app(sfWebRequest $request) {
  	$this->pServices = SupportedServicesTable::getAll();
  }

}
?>