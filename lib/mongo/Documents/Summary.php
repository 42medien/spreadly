<?php
namespace Documents;

/**
 * @author Matthias Pfefferle
 * @author Hannes Schippmann
 *
 * @MappedSuperclass
 */
abstract class Summary {
  /** @Id */
  private $id;

  /** @Field(type="int", name="cb") */
  private $clickbacks;

  /** @Int */
  private $likes;

  /** @String */
  private $host;

  public function setId($id) {
    $this->id = $id;
  }

  public function getId() {
    return $this->id;
  }
    
  public function setHost($host) {
    $this->host = $host;
  }

  public function getHost() {
    return $this->host;
  }

  public function setLikes($likes) {
    $this->likes = $likes;
  }

  public function getLikes() {
    return $this->likes;
  }
  
  public function setClickbacks($clickbacks) {
    $this->clickbacks = $clickbacks;
  }

  public function getClickbacks() {
    return $this->clickbacks;
  }
}