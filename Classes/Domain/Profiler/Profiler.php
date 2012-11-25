<?php

/**
 * Profiler object that collects data from the processed code.
 *
 * Usage:
 *
 * declare(ticks=10);
 * $profiler = new Tx_Takeoff_Domain_Profiler_Profiler();
 * $profiler->start();
 * 		.. your code ..
 * $profiler->end();
 *
 * @author Timo Schmidt <timo-schmidt@gmx.net>
 * @package Domain\Profiler
 */
class Tx_Takeoff_Domain_Profiler_Profiler {

	/**
	 * @var int
	 */
	protected $sampleCount = 0;

	/**
	 * @var int
	 */
	protected $memoryUsageOverall = 0;

	/**
	 * @var int
	 */
	protected $startMemoryUsage = 0;

	/**
	 * @var Tx_Takeoff_Domain_Profiler_ProfileSampleCollection
	 */
	protected $profileSamples = null;

	/**
	 * @var int
	 */
	protected $timeStart;

	/**
	 * @var int
	 */
	protected $timeStop;

	/**
	 * @var bool
	 */
	protected static $running = false;

	/**
	 * @return void
	 */
	public function start() {
		if(!self::$running) {
			unregister_tick_function(array(&$this,'handleSample'));
			$this->timeStart = microtime(true);
			$this->profileSamples = new Tx_Takeoff_Domain_Profiler_ProfileSampleCollection();
			$this->sampleCount = 0;
			$this->startMemoryUsage = memory_get_usage();

			self::$running = true;
			register_tick_function(array(&$this,'handleSample'));
		}
	}

	/**
	 * @return void
	 */
	public function stop() {
		unregister_tick_function(array(&$this,'handleSample'));
		$this->timeStop = microtime(true);
		self::$running = false;
	}

	/**
	 * @return array
	 */
	protected function getStackTrace() {
		return debug_backtrace(0,10);
	}

	/**
	 * @return array
	 */
	protected function getRelevantStackTrace() {
		$trace 	= array_reverse($this->getStackTrace());

		//we remove the two first stack items since the come from the profiler itself
		array_pop($trace);
		array_pop($trace);
		array_pop($trace);

		return $trace;
	}

	/**
	 * @return void
	 */
	public function handleSample() {
		$this->sampleCount++;

			//@todo why do we sometimes get a negative value here
		$sampleUsage = max(0,memory_get_usage() - $this->startMemoryUsage - $this->memoryUsageOverall);

		$trace 	= $this->getRelevantStackTrace();
		if(array($trace)) {
			$path = '';
			foreach($trace as $item) {
				$lastPath = $item['class'].' -> '.$item['function'];
				$path .= $lastPath.' / ';
			}
		}

		$profileItem = new Tx_Takeoff_Domain_Profiler_ProfileSample();
		$profileItem->setSampleNumber($this->sampleCount);
		$profileItem->setMemoryUsage($sampleUsage);
		$profileItem->setStackPosition($path);
		$profileItem->setClosestStackItem($lastPath);

		$profileItem->setCosts(1);

		$this->profileSamples->append($profileItem);
		$this->memoryUsageLastSample = $sampleUsage;
		$this->memoryUsageOverall += $sampleUsage;
	}

	/**
	 * @return Tx_Takeoff_Domain_Profiler_ProfileSampleCollection
	 */
	public function getSamples() {
		return $this->profileSamples;
	}

	/**
	 * @return int
	 */
	public function getSampleCount() {
		return $this->sampleCount - 4;
	}

	/**
	 * @return int
	 */
	public function getOverallMemoryUsage() {
		return $this->memoryUsageOverall + $this->startMemoryUsage;
	}

	/**
	 * @return float
	 */
	public function getMilliSecondsSpend() {
		return round(($this->timeStop - $this->timeStart) * 1000);
	}

	/**
	 * @return int
	 */
	public function getPeakMemoryUsage() {
		return memory_get_peak_usage();
	}
}