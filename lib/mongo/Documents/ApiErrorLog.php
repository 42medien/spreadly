<?php
namespace Documents;

/**
 * @author Matthias Pfefferle
 *
 * @Document(collection="error_log")
 */
class ApiErrorLog extends ErrorLog {

  /** @Int */
  protected $oi_id;

  /** @Int */
  protected $u_id;
}