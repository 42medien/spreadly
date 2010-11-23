<?php


class sfGuardUserProfileTable extends PluginsfGuardUserProfileTable
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('sfGuardUserProfile');
    }
}