<?php


class SupportedServicesTable extends Doctrine_Table
{

    public static function getInstance()
    {
        return Doctrine_Core::getTable('SupportedServices');
    }

    public static function getAll() {
	    $lQuery = Doctrine_Query::create()
	    ->from('SupportedServices ss');

	    return $lQuery->execute();
    }
}