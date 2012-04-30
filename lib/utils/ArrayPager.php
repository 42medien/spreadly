<?php
/**
 * A class to simulate a database pager-result
 *
 */
class ArrayPager extends sfPager {
  protected $resultsArray = null;
  protected $max = null;

  public function __construct($class = null, $maxPerPage = 10) {
    parent::__construct($class, $maxPerPage);
  }

  public function init() {
    $this->setNbResults($this->getMax());

    if (($this->getPage() == 0 || $this->getMaxPerPage() == 0)) {
     $this->setLastPage(0);
    } else {
     $this->setLastPage(ceil($this->getNbResults() / $this->getMaxPerPage()));
    }
  }
  
  public function hasToPaginate() {
    return $this->getNbResults() > $this->getMaxPerPage();
  }

  public function setResultArray($array) {
    $this->resultsArray = $array;
  }

  public function getResultArray() {
    return $this->resultsArray;
  }

  public function setMax($max) {
    $this->max = $max;
  }

  public function getMax() {
    return $this->max;
  }

  public function retrieveObject($offset) {
    return $this->resultsArray[$offset];
  }

  public function getResults() {
    return $this->resultsArray;
  }

}