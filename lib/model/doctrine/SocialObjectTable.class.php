<?php


class SocialObjectTable extends Doctrine_Table
{
    const MONGO_COLLECTION_NAME = 'social_object';

    public static function getInstance()
    {
        return Doctrine_Core::getTable('SocialObject');
    }

    public static function getMongoCollection() {
      return MongoDbConnector::getInstance()->getCollection(sfConfig::get('app_mongodb_database_name'), self::MONGO_COLLECTION_NAME);
    }
}