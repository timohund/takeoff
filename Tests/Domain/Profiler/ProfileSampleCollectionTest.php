<?php


require_once ('../Classes/Domain/Profiler/ProfileSample.php');
require_once ('../Classes/Domain/Profiler/ProfileSampleCollection.php');
require_once ('../Classes/Domain/Profiler/Profiler.php');

class Tx_Takeoff_Profiler_ProfileSampleCollectionTest extends PHPUnit_Framework_TestCase {

	/**
	 * @test
	 */
	public function canGetTopMemoryConsumers() {
		$collection = new Tx_Takeoff_Domain_Profiler_ProfileSampleCollection();

		$sampleA = new Tx_Takeoff_Domain_Profiler_ProfileSample();
		$sampleA->setCosts(1);
		$sampleA->setClosestStackItem('foo->bar');
		$sampleA->setMemoryUsage(100);

		$sampleB = new Tx_Takeoff_Domain_Profiler_ProfileSample();
		$sampleB->setCosts(1);
		$sampleB->setClosestStackItem('foo->x');
		$sampleB->setMemoryUsage(100);

		$sampleC = new Tx_Takeoff_Domain_Profiler_ProfileSample();
		$sampleC->setCosts(1);
		$sampleC->setClosestStackItem('foo->x');
		$sampleC->setMemoryUsage(120);

		$collection->append($sampleA);
		$collection->append($sampleB);
		$collection->append($sampleC);

		$topMemoryUsers = $collection->getMostMemoryConsuming();
		$first = array_shift($topMemoryUsers);

		$this->assertEquals(220, $first->getMemoryUsage(),'Unexpected memory usage');
	}

}