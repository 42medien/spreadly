<?php
namespace Documents;

/**
 * @Document(collection="error_log", repositoryClass="Repositories\ApiErrorLogRepository")
 * @author Matthias Pfefferle
 */
class ApiErrorLog extends ErrorLog {

  /** @Int */
  protected $oi_id;

  /** @Int */
  protected $u_id;
}