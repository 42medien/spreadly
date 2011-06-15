<?php

function upDownClass($value) {
  return $value === 0 ? 'neutral' : (($value > 0 || $value=='∞') ? 'positive' : 'negative');
}

function absOrInfinity($value) {
  return $value == '∞' ? $value : abs($value);
}