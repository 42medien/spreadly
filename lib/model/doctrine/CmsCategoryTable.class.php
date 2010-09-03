<?php


class CmsCategoryTable extends Doctrine_Table
{

    public static function getInstance()
    {
        return Doctrine_Core::getTable('CmsCategory');
    }

    public static function getAllFooterCategories(){
      $lQ = Doctrine_Query::create()
      ->from('CmsCategory cc')
      ->where('cc.footer = ?', true);
      return $lQ->execute();
    }
}