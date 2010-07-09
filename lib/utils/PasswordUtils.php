<?php

class PasswordUtils{


  public static function salt_password($password, $salt) {
    return md5(md5($salt).$password);
  }

  public static function random_str($length="8") {
    $set = array("a","A","b","B","c","C","d","D","e","E","f","F","g","G","h","H","i","I","j","J","k","K","l","L","m","M","n","N","o","O","p","P","q","Q","r","R","s","S","t","T","u","U","v","V","w","W","x","X","y","Y","z","Z","1","2","3","4","5","6","7","8","9");
    $str = '';
    for($i = 1; $i <= $length; $i++)
    {
      $ch = rand(0, count($set)-1);
      $str .= $set[$ch];
    }
    return $str;
  }

  public static function random_password() {
    $chars = "abcdefghijkmnopqrstuvwxyz023456789";
    srand((double)microtime()*1000000);
    $i = 0;
    $pass = '' ;
    while ($i <= 7) {
        $num = rand() % 33;
        $tmp = substr($chars, $num, 1);
        $pass = $pass . $tmp;
        $i++;
    }
    return $pass;
  }
}
?>