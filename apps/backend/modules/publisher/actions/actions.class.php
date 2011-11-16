<?php

/**
 * publisher actions.
 *
 * @package    yiid
 * @subpackage publisher
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class publisherActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request) {
    $date = $request->getParameter("date", date("m.Y"));

    $date = explode(".", $date);

    $dates = Doctrine_Query::create()
        ->select('month( created_at ) as month,  year( created_at ) as year, created_at')
        ->from('commission')
        ->groupBy('month, year')
        ->orderBy('created_at DESC')
        ->fetchArray();

    $this->dates = $dates;

    $commissions = Doctrine_Query::create()
        ->select('domain_profile_id, sum( price ), month( created_at ) as month,  year( created_at ) as year, count(id)')
        ->from('commission')
        ->where('month( created_at ) = ? AND year( created_at ) = ?', array($date[0], $date[1]))
        ->groupBy('month, year, domain_profile_id')
        ->orderBy('created_at DESC')
        ->fetchArray();

    $this->commissions = $commissions;
  }
}
