<?php


class TagTable extends PluginTagTable
{

    public static function getInstance()
    {
        return Doctrine_Core::getTable('Tag');
    }

    public static function getAllTagsByString($pString) {

      $lQuery = Doctrine_Query::create()
      ->select('DISTINCT t.name')
      ->from('Tag t')
      ->where('t.name LIKE ?', '%'.$pString.'%');



      return $lQuery->fetchArray();
    }
}