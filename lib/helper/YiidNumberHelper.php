<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * YiidNumberHelper.
 *
 * @package    symfony
 * @subpackage helper
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: NumberHelper.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */

function point_format($number, $culture = null)
{
  if (null === $number)
  {
    return 0;
  }

  return number_format(intval($number), 0, '', '.');
}

function truncate_number($number)
{
  if ($number >= 1000000) {
    return '<abbr title="'.$number.'">'.intval($number/1000000) . 'M</abbr>';
  } elseif ($number >= 10000) {
    return '<abbr title="'.$number.'">'.intval($number/1000) . 'k</abbr>';
  } else {
    return $number;
  }
}