<?php
use Doctrine\Common\ClassLoader,
    Doctrine\Common\Annotations\AnnotationReader,
    Doctrine\ODM\MongoDB\Configuration,
    Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver,
    Doctrine\MongoDB\Connection,
    Doctrine\ODM\MongoDB\DocumentManager,
    \sfConfig;

class MongoManager {
  static private $document_manager = null;
  static private $stats_document_manager = null;

  private function __construct(){}
  private function __clone(){}

  public static function getStatsDM() {
    if (null === self::$document_manager) {
      self::$stats_document_manager = self::instantiateDocumentManager("stats");
    }

    return self::$stats_document_manager;
  }

  public static function getDM() {
    if (null === self::$document_manager) {
      self::$document_manager = self::instantiateDocumentManager();
    }

    return self::$document_manager;
  }

  private function instantiateDocumentManager($db = null) {
    if ($db = "stats") {
      $db = sfConfig::get("database_name_stats");
    } else {
      $db = sfConfig::get("database_name");
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

    return DocumentManager::create(new Connection(), $config);
  }

}