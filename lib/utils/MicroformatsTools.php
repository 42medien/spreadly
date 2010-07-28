<?php
/**
 * a toolkit for microformats operations
 *
 * @author Matthias Pfefferle
 */
class MicroformatsTools {
  /**
   * split the hCard fn attribute
   *
   * @link http://microformats.org/wiki/hCard#Implied_.22n.22_Optimization
   *
   * @param string $pFn
   * @return array
   */
  public static function splitFN($pFn) {
    $lArray = array();
    if (sizeof(explode(' ', $pFn)) == 2){
      $patterns = array();
      $patterns[] = array('/^(\S+),\s*([\S\pL]{1})$/', 2, 1);   // Lastname, Initial
      $patterns[] = array('/^(\S+)\s*([\S\pL]{1})\.*$/u', 2, 1);  // Lastname Initial(.)
      $patterns[] = array('/^(\S+),\s*(\S+)$/', 2, 1);        // Lastname, Firstname
      $patterns[] = array('/^(\S+)\s*(\S+)$/', 1, 2);         // Firstname Lastname

      foreach ($patterns as $pattern){
        if (preg_match($pattern[0], $pFn, $matches) === 1){
          $lArray['firstname'] = $matches[$pattern[1]];
          $lArray['lastname'] = $matches[$pattern[2]];

          //@TODO macht das hier sinn?
          return $lArray;
        }
      }
    }
    return $lArray;
  }
}