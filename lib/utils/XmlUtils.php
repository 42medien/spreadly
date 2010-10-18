<?php
class XmlUtils {
  public static function XML2Array ( $xml , $recursive = false ){
      if ( ! $recursive )
      {
          $array = simplexml_load_string ( $xml ) ;
      }
      else
      {
          $array = $xml ;
      }

      $newArray = array () ;
      $array = ( array ) $array ;
      foreach ( $array as $key => $value )
      {
          $value = ( array ) $value ;
          if ( isset ( $value [ 0 ] ) )
          {
              $newArray [ $key ] = trim ( $value [ 0 ] ) ;
          }
          else
          {
              $newArray [ $key ] = self::XML2Array ( $value , true ) ;
          }
      }
      return $newArray ;
  }
}
?>