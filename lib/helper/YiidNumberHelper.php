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
 * @package    spreadly
 * @subpackage helper
 * @author     Matthias Pfefferle
 */

function truncate_number($number)
{
  if ($number >= 1000) {
    return '<abbr title="'.$number.'">'.intval($number/1000) . 'k</abbr>';
  } elseif ($number >= 1000000) {
    return '<abbr title="'.$number.'">'.intval($number/1000000) . 'm</abbr>';
  } else {
    return $number;
  }
}