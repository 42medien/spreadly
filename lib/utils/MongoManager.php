<?php
use Doctrine\Common\ClassLoader,
    Doctrine\Common\Annotations\AnnotationReader,
    Doctrine\ODM\MongoDB\Configuration,
    Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver,
    Doctrine\MongoDB\Connection,
    Doctrine\ODM\MongoDB\DocumentManager,
    \sfConfig;

/**
 * Enter description here...
 *
 * @author Matthias Pfefferle
 */
class MongoManager {
  static private $document_manager = null;
  static private $stats_document_manager = null;

  private function __construct(){}
  private function __clone(){}

  /**
   * returns the document manager for the stats db
   *
   * @return Doctrine\ODM\MongoDB\DocumentManager
   */
  public static function getStatsDM() {
    if (null === self::$document_manager) {
      self::$stats_document_manager = self::instantiateDocumentManager("stats");
    }

    return self::$stats_document_manager;
  }

  /**
   * returns the document manager for the main db
   *
   * @return Doctrine\ODM\MongoDB\DocumentManager
   */
  public static function getDM() {
    if (null === self::$document_manager) {
      self::$document_manager = self::instantiateDocumentManager();
    }

    return self::$document_manager;
  }

  /**
   * generates the needed document manager
   *
   * @param string $db
   * @return Doctrine\ODM\MongoDB\DocumentManager
   */
  private function instantiateDocumentManager($db = null) {
    if ($db = "stats") {
      $db = sfConfig::get("app_mongodb_database_name_stats");
    } else {
      $db = sfConfig::get("app_mongodb_database_name");
    }

    $config = new Configuration();

    $config->setProxyDir(sfConfig::get('sf_cache_dir').'/Proxies');
    $config->setProxyNamespace('Proxies');

    $config->setHydratorDir(sfConfig::get('sf_cache_dir').'/Hydrators');
    $config->setHydratorNamespace('Hydrators');

    $config->setDefaultDB($db);

    $reader = new AnnotationReader();
    $reader->setDefaultAnnotationNamespace('Doctrine\ODM\MongoDB\Mapping\\');
    $config->setMetadataDriverImpl(new AnnotationDriver($reader, __DIR__ . '/Documents'));

    return DocumentManager::create(new Connection(sfConfig::get("app_mongodb_host")), $config);
  }

}