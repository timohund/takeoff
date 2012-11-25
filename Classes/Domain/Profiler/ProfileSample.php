<?php

/**
 * A ProfileSample is one item that is collected during
 * the profiling. It contains information like the position
 * in the code or the memory usage.
 *
 * @package Domain\Profiler
 * @author Timo Schmidt <timo-schmidt@gmx.net>
 */
class Tx_Takeoff_Domain_Profiler_ProfileSample {

	/**
	 * @var string
	 */
	protected $stackPosition = '';

	/**
	 * @var int
	 */
	protected $memoryUsage = 0;

	/**
	 * @var int
	 */
	protected $sampleNumber = 0;

	/**
	 * @var int
	 */
	protected $costs = 1;

	/**
	 * @var string
	 */
	protected $closestStackItem = '';

	/**
	 * @param int $memoryUsage
	 */
	public function setMemoryUsage($memoryUsage) {
		$this->memoryUsage = $memoryUsage;
	}

	/**
	 * @return int
	 */
	public function getMemoryUsage() {
		return $this->memoryUsage;
	}

	/**
	 * @param string $stackPosition
	 */
	public function setStackPosition($stackPosition) {
		$this->stackPosition = $stackPosition;
	}

	/**
	 * @return string
	 */
	public function getStackPosition() {
		return $this->stackPosition;
	}

	/**
	 * @param int $sampleNumber
	 */
	public function setSampleNumber($sampleNumber) {
		$this->sampleNumber = $sampleNumber;
	}

	/**
	 * @return int
	 */
	public function getSampleNumber() {
		return $this->sampleNumber;
	}

	/**
	 * @param int $costs
	 */
	public function setCosts($costs) {
		$this->costs = $costs;
	}

	/**
	 * @return int
	 */
	public function getCosts() {
		return $this->costs;
	}

	/**
	 * @param string $closestStackItem
	 */
	public function setClosestStackItem($closestStackItem) {
		$this->closestStackItem = $closestStackItem;
	}

	/**
	 * @return string
	 */
	public function getClosestStackItem() {
		return $this->closestStackItem;
	}
}