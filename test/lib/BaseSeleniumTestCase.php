<?php

require_once 'PHPUnit/Extensions/SeleniumTestCase.php';
require_once realpath( dirname(__file__).'/../config/config.php' );


abstract class BaseSeleniumTestCase extends PHPUnit_Extensions_SeleniumTestCase{

    protected $coverageScriptUrl = 'http://communipedia/phpunit_coverage.php';


    public function setUp(){
       global $CONF;

       $this->setBrowser( $CONF['browser'] );
       $this->setBrowserUrl( $CONF['browserurl'] );
  //     PHPUnit_Util_Filter::addDirectoryToWhitelist( SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps/communipedia/modules/', '.php');
    }

}


?>
