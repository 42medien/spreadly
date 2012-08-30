<?php


class CatalogueTable extends Doctrine_Table
{

  public static function getInstance()
  {
    return Doctrine_Core::getTable('Catalogue');
  }


  /**
   * This function returns the catalogue object for the transfered culture and message
   *
   * @author Christian Schätzle
   *
   * @param string $pCulture
   * @param string $pCatalogue
   * @return Catalogue
   */
  public static function retrieveByCulture($pCulture, $pCatalogue = 'messages') {
    $lLang = strtolower(substr($pCulture, 0, 2));
    $lCatalogueName = $pCatalogue.'.'.$lLang;
		var_dump($lCatalogueName);
		var_dump($lLang);


      $lQuery = Doctrine_Query::create()
      ->from('Catalogue c')
      ->where('c.name= ?', $lCatalogueName)
      ->andWhere('c.target_lang = ?', $lLang);

      //var_dump($lQuery->fetchOne());
      return $lQuery->fetchOne();
  }

}