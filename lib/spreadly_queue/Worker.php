<?php
namespace Spreadly\Queue;

/**
 * Worker
 *
 * @author Hannes Schippmann
 */
class Worker {
  // Basically the YiidDaemon, without the SQS specific stuff.
  // Runs in an infinite loop
  // Gets Jobs from JobQueue and calls execute on them
}
