<?php


class TransUnitTable extends Doctrine_Table
{

  public static function getInstance()
  {
    return Doctrine_Core::getTable('TransUnit');
  }




  public static function createWildcard($wildcard, $catalogue)
  {
    // get all available languages
    $langs = LanguageTable::getAllLanguages(false);

    foreach($langs as $l)
    {
      $lQuery = Doctrine_Query::create()
      ->from('Catalogue c')
      ->select('c.cat_id')
      ->where('c.name= ?', $catalogue . '.' . $l->getLang());

      $catId = $lQuery->execute(array(), Doctrine_Core::HYDRATE_NONE);
      $catId = HydrationUtils::flattenArray($catId);

      if(!$catId) continue;

      $t = new TransUnit();
      $t->setCatId($catId[0]);
      $t->setSource($wildcard);
      $t->save();
    }
  }


  /**
   * This function returns the trans unit object for the transfered wildcard, culture and catalogue
   *
   * @author Christian Schätzle
   *
   * @param string $pCulture
   * @param string $pCatalogue
   * @param string $pWildcard
   * @return TransUnit
   */
  public static function retrieveWildcardObject($pCulture, $pCatalogue = 'messages', $pWildcard) {
    // culture catalogue
    $lCatalogueObject = CatalogueTable::retrieveByCulture($pCulture, $pCatalogue);
    var_dump($pWildcard);die();

    if($lCatalogueObject) {
      return self::retrieveByCatId($lCatalogueObject->getCatId(), $pWildcard);
    } else {
      return false;
    }
  }

  /**
   * This function searchs the trans unit object for the transfered wildcard
   *
   * @author Christian Schätzle
   *
   * @param string $pWildcardString
   * @param bool $pCirca
   * @return TransUnit
   */
  public static function searchWildcard($pWildcardString, $pCirca = false, $pDistinct = true) {
    if ($pCirca) {
      $pWildcardString = '%'.$pWildcardString.'%';
    }

    $lQ = Doctrine_Query::create()
    ->from('TransUnit t')
    ->where('t.source = ?', $pWildcardString);

    if ($pDistinct) {
      $lQ->groupBy('t.source');
    }

    return $lQ->execute();
  }


  /**
   * This function returns the trans unit object for the transfered catalogue id and source
   *
   * @author Christian Schätzle
   *
   * @param int $pCatId
   * @param string $pSource
   * @return TransUnit
   */
  public static function retrieveByCatId($pCatId, $pSource) {

     $lQ = Doctrine_Query::create()
    ->from('TransUnit t')
    ->where('t.source = ?', $pSource)
    ->andWhere('t.cat_id = ?', $pCatId);

    return $lQ->fetchOne();
  }

}