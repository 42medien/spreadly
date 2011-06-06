<?php
namespace Documents;

/**
 * @author Matthias Pfefferle
 *
 * @MappedSuperclass
 * @Document(collection="error_log")
 * @HasLifecycleCallbacks
 * @InheritanceType("SINGLE_COLLECTION")
 * @DiscriminatorField(fieldName="type")
 * @DiscriminatorMap({"api"="ApiErrorLog"})
 */
class ErrorLog extends BaseDocument {

  /** @Id */
  protected $id;

  /** @String */
  protected $code;

  /** @String */
  protected $message;

  /** @Date */
  protected $c;

  /**
   * pre-save hook
   *
   * @PrePersist
   *
   * @author Matthias Pfefferle
   */
  public function prePersist() {
    if(!$this->getC()) {
      $this->setC(time());
    }
  }
}