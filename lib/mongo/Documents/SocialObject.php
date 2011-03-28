<?php
namespace Documents;

/**
 * @Document(collection="social_object")
 * @HasLifecycleCallbacks
 */
class SocialObject {
  /** @Id */
  private $id;

  public function setId($id) {
    $this->id = $id;
  }

  public function getId() {
    return $this->id;
  }
}