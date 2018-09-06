<?php
/**
 * Resque Queue System helper
 *
 * Uses 'php-resque' library for communication with Resque
 * https://github.com/chrisboulton/php-resque
 */
class QueueUtility {

  private static function init() {
    Resque::setBackend(Yii::app()->params['resque']['host']);
  }

  private static function jobName($job_key) {
    return Yii::app()->params['resque']['jobs'][$job_key];
  }

  /**
   * Creates a new job in the application queue
   * @param  string $job     The key of the desired job, as found in config/main.php in params['resque']
   * @param  array $job_data Associative array with parameters for the new job
   * @return mixed   Returns the new Job ID on success, throws exception on failure
   */
  public static function queue($job = null, $job_data = null) {
    if ($job && $job_data) {
      self::init();
      return Resque::enqueue('yii', self::jobName($job), $job_data);
    } else {
      throw new Exception("Job Name and Job Data required to queue job!");
    }
  }
}