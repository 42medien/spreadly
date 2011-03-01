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
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'translation'),
      new sfCommandOption('no-confirmation', null, sfCommandOption::PARAMETER_NONE, 'Do not prompt for confirmation')
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
    // run only in dev mode
    $this->logSection('yiid', 'Syncing the i18n db for env='.$options['env']);
    if ($options['env'] == "dev" || $options['env'] == "staging") {
      $databaseManager = new sfDatabaseManager($this->configuration);
      $database = $databaseManager->getDatabase($options['connection']);

      $u = $database->getParameter('username');
      $p = $database->getParameter('password');
      $dsn = $database->getParameter('dsn');

      $results = array();
      preg_match("~host=(\w+)~i", $dsn, $results);
      $h = $results[1];

      $results = array();
      preg_match("~dbname=(\w+)~i", $dsn, $results);
      $d = $results[1];

      $query = "mysql --host=".$h." -u ".$u." -p".$p." ".$d." < i18n.sql";

      if ($options['no-confirmation'] || "y" == $this->ask("run: '".$query."'?")) {
        $this->logSection('yiid', 'import i18n db');
        $this->getFilesystem()->execute("wget http://yiid:affen2010@staging.yiiddev.com/service/i18n.sql");
        $this->getFilesystem()->execute($query);
        $this->getFilesystem()->execute("rm ./i18n.sql");
      }
    } else {
      $this->logSection('yiid', 'ignore i18n import');
    }
  }
}
