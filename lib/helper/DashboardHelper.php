<?php

function upDownClass($value) {
  return $value === 0 ? 'neutral' : (($value > 0 || $value=='∞') ? 'positive' : 'negative');
}

function upDownArrow($value) {
  return $value === 0 ? '&#9658' : (($value > 0 || $value=='∞') ? '&#9650' : '&#9660');
}

function absOrInfinity($value) {
  return $value == '∞' ? $value : abs($value);
}