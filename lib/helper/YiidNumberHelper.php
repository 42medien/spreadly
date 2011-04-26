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
    return null;
  }

  return number_format($number, 0, '', '.');
}