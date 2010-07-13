<?php

class profileConfiguration extends sfApplicationConfiguration
{
  public function configure() {
    sfConfig::set( 'sf_upload_dir_name', 'uploads' );
  }
}
