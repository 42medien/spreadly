<?php
function rgb2hsl($rgb){
  $rgb = str_replace("#", "", $rgb);

  $redhex  = substr($rgb,0,2);
  $greenhex = substr($rgb,2,2);
  $bluehex = substr($rgb,4,2);

  $var_r = (hexdec($redhex)) / 255;
  $var_g = (hexdec($greenhex)) / 255;
  $var_b = (hexdec($bluehex)) / 255;
  $var_min = min($var_r,$var_g,$var_b);
  $var_max = max($var_r,$var_g,$var_b);
  $del_max = $var_max - $var_min;

  $l = ($var_max + $var_min) / 2;

  if ($del_max == 0) {
    $h = 0;
    $s = 0;
  }
  else {
    if ($l < 0.5) {
      $s = $del_max / ($var_max + $var_min);
    } else {
      $s = $del_max / (2 - $var_max - $var_min);
    };

    $del_r = ((($var_max - $var_r) / 6) + ($del_max / 2)) / $del_max;
    $del_g = ((($var_max - $var_g) / 6) + ($del_max / 2)) / $del_max;
    $del_b = ((($var_max - $var_b) / 6) + ($del_max / 2)) / $del_max;

    if ($var_r == $var_max) {
      $h = $del_b - $del_g;
    } elseif ($var_g == $var_max) {
      $h = (1 / 3) + $del_r - $del_b;
    } elseif ($var_b == $var_max) {
      $h = (2 / 3) + $del_g - $del_r;
    };

    if ($h < 0) {
      $h += 1;
    };

    if ($h > 1) {
      $h -= 1;
    };
  };

  return array(round($h * 360), $s * 100, $l * 100);
}