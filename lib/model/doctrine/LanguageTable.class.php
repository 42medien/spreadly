<?php


class LanguageTable extends Doctrine_Table
{

  public static function getInstance()  {
    return Doctrine_Core::getTable('Language');
  }

  public static function getAllLanguages($pActive = null) {
    $lQuery =  self::getInstance()->createQuery();
    if ($pActive == true) {
      $lQuery->where('is_active = ?', true);
    }
    return $lQuery->execute();
  }

  public static function getAllLanguageCodesAsArray($pActive = null) {
    $lLangArray = array();
    $lOriginalLanguages = self::getAllLanguages($pActive);
     foreach ($lOriginalLanguages as $lLang) {
      $lLangArray[] = $lLang->getLang();
    }
    return $lLangArray;
  }

  public static function getDefaultLanguage() {
    return 'en';
  }
}