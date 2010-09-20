<?php
class YiidImportContacts {
  public static function import($pMessage) {
    $lObject = ImportApiFactory::factory();
    $lObject->importContacts();
  }
}