<?php


class CmsTable extends Doctrine_Table
{

    public static function getInstance()
    {
        return Doctrine_Core::getTable('Cms');
    }

    public static function getCmsByPageAndCategory($pPage, $pCategory){
      $lQ = Doctrine_Query::create()
      ->from('Cms c')
      ->where('c.page = ?', $pPage)
      ->andWhere('c.active = ?', true)
      ->leftJoin('c.CmsCategory cc')
      ->andWhere('cc.page = ?', $pCategory);
      $lCms = $lQ->fetchOne();

      return $lCms;
    }
}