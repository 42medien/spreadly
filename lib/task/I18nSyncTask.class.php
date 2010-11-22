<?php
/**
 * i18n tasks
 *
 * @author Matthias Pfefferle
 */
class I18nSyncTask extends sfBaseTask {

  /**
   * configuration file
   */
  protected function configure() {
    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
    ));

    $this->namespace        = 'yiid';
    $this->name             = 'i18n-sync';
    $this->briefDescription = 'Sync all translations';
    $this->detailedDescription = <<<EOF
The [I18nSync|INFO] task does things.
Call it with:

  [php symfony I18nSync|INFO]
EOF;
  }

  /**
   * get sql dump and
   * import it in own db
   */
  protected function execute($arguments = array(), $options = array()) {
    $this->logSection('yiid', 'import i18n db');
    $this->getFilesystem()->execute("wget http://yiid:affen2010@staging.yiiddev.com/service/i18n.sql");
    $this->getFilesystem()->execute("mysql -u yiid_i18n -pfdsmolds32dfs yiid_i18n < i18n.sql");
    $this->getFilesystem()->execute("rm ./i18n.sql");
    // add your code here
  }
}
