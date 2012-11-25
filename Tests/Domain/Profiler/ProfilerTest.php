<?php


require_once ('../Classes/Domain/Profiler/ProfileSample.php');
require_once ('../Classes/Domain/Profiler/ProfileSampleCollection.php');
require_once ('../Classes/Domain/Profiler/Profiler.php');

class Tx_Takeoff_Profiler_ProfilerTest extends PHPUnit_Framework_TestCase {

	/**
	 * @test
	 */
	public function canCountZeroTicks() {
		$profiler = new Tx_Takeoff_Domain_Profiler_Profiler();
		declare(ticks=1);

		$profiler->start();
		$profiler->stop();

		$this->assertEquals(0,$profiler->getSampleCount(),'Profiler doe not report 0 statements, when nothing was done');
	}

	/**
	 * @test
	 */
	public function canCountSimpleStatements() {
		$profiler = new Tx_Takeoff_Domain_Profiler_Profiler();
		declare(ticks=1);

		$profiler->start();
			$i = 0;
			$i = 1;
			$k = 'das ist ein test';
			$z = array();
		$profiler->stop();

		$this->assertEquals(4,$profiler->getSampleCount(),'Could not count two simple statements');
	}
}