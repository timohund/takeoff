<?php

/**
 * A collection class for samples.
 * Can be used to retrieve groups of samples.
 *
 * @package Domain\Profiler
 * @author Timo Schmidt <timo-schmidt@gmx.net>
 */
class Tx_Takeoff_Domain_Profiler_ProfileSampleCollection extends ArrayObject {

	/**
	 * @var null
	 */
	protected $groupedData = null;

	/**
	 * @param Tx_Takeoff_Domain_Profiler_ProfileSample $item
	 */
	public function append(Tx_Takeoff_Domain_Profiler_ProfileSample $item) {
		return parent::append($item);
	}

	/**
	 * @return Tx_Takeoff_Domain_Profiler_ProfileSampleCollection
	 */
	protected function getGroupedProfileData() {
		if($this->groupedData == null) {
			$this->groupedData = new Tx_Takeoff_Domain_Profiler_ProfileSampleCollection();

			foreach($this as $item) {
				/** @var $item Tx_Takeoff_Domain_Profiler_ProfileSample */
				$key = $item->getClosestStackItem();
				if($this->groupedData->offsetExists($key)) {
					/** @var $oldItem Tx_Takeoff_Domain_Profiler_ProfileSample */
					$oldItem = $this->groupedData->offsetGet($key);
					$oldItem->setMemoryUsage($oldItem->getMemoryUsage()+$item->getMemoryUsage());
					$oldItem->setCosts($oldItem->getCosts()+1);

					$this->groupedData->offsetSet($key,$oldItem);
				} else {
					$this->groupedData->offsetSet($key,$item);
				}
			}
		}

		return $this->groupedData;
	}

	/**
	 * @return Tx_Takeoff_Domain_Profiler_ProfileSampleCollection
	 */
	public function getMostMemoryConsuming() {
		$result	= $this->getGroupedProfileData();
		$result->getIterator()->uasort(array($this,'sortByMemory'));
		return $result->getArrayCopy();
	}

	/**
	 * @return Tx_Takeoff_Domain_Profiler_ProfileSampleCollection
	 */
	public function getMostTimeConsuming() {
		$result	= $this->getGroupedProfileData();
		$result->getIterator()->uasort(array($this,'sortByCosts'));
		return $result->getArrayCopy();
	}

	/**
	 * @param Tx_Takeoff_Domain_Profiler_ProfileSample $a
	 * @param Tx_Takeoff_Domain_Profiler_ProfileSample $b
	 * @return int
	 */
	public function sortByMemory(Tx_Takeoff_Domain_Profiler_ProfileSample $a,
								 Tx_Takeoff_Domain_Profiler_ProfileSample $b) {
		if ($a->getMemoryUsage() == $b->getMemoryUsage()) {
			return 0;
		}
		return ($a->getMemoryUsage() > $b->getMemoryUsage()) ? -1 : 1;
	}

	/**
	 * @param Tx_Takeoff_Domain_Profiler_ProfileSample $a
	 * @param Tx_Takeoff_Domain_Profiler_ProfileSample $b
	 * @return int
	 */
	public function sortByCosts(Tx_Takeoff_Domain_Profiler_ProfileSample $a,
								Tx_Takeoff_Domain_Profiler_ProfileSample $b) {
		if ($a->getCosts() == $b->getCosts()) {
			return 0;
		}
		return ($a->getCosts() > $b->getCosts()) ? -1 : 1;
	}
}