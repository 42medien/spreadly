<?php

class widgetComponents extends sfComponents {

  public function executeDislike_pager($request) {
    $this->pPage = $request->getParameter('page', 1);
  }

}
?>