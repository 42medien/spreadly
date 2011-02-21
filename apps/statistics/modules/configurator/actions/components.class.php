<?php

class configuratorComponents extends sfComponents
{

  public function executeChoose_app(sfWebRequest $request) {
  	$this->pServices = SupportedServicesTable::getAll();
  }

}
?>