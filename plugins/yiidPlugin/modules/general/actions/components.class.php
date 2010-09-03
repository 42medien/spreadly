<?php

class generalComponents extends sfComponents {


  public function executeFooter() {
    $lCulture = $this->getUser()->getCulture();
    $lCategories = CmsCategoryTable::getAllFooterCategories();
    //$c = new Criteria();
    //$c->add(CmsCategoryPeer::FOOTER, true);
    //$lCategories = CmsCategoryTable::doSelectWithI18n();

    $this->pCategories = $lCategories;
    $this->pCulture = $lCulture;

  }


  public function executeLanguage_switch(sfWebRequest $request) {
    $this->form = new sfFormLanguage(
      $this->getUser(),
      array('languages' => array('en', 'de'))
    );
  }

}
?>