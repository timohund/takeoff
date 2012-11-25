<?php

require_once PATH_tx_takeoff.'Classes/Domain/Profiler/Profiler.php';
require_once PATH_tx_takeoff.'Classes/Contribute/firelogger.php';


class user_Tx_Takeoff_Hooks_Profiling {

	/**
	 * @var Tx_Takeoff_Domain_Profiler_Profiler
	 */
	protected static $profiler;

	/**
	 * @return void
	 */
	public function start() {
		self::$profiler = new Tx_Takeoff_Domain_Profiler_Profiler();
		self::$profiler->start();
	}

	/**
	 * @param $byte
	 * @return float
	 */
	protected function toMegaByte($byte) {
		return $byte / (1024 * 1024);
	}

	/**
	 * @return void
	 */
	public function stop() {
		self::$profiler->stop();

		$profileDataItems 	= self::$profiler->getSamples();
		$memoryItems 		= $profileDataItems->getMostMemoryConsuming();
		$timeItems 			= $profileDataItems->getMostTimeConsuming();
		$overallUsage		= self::$profiler->getOverallMemoryUsage();
		$sampleCount		= self::$profiler->getSampleCount();
		$timeSpend			= self::$profiler->getMilliSecondsSpend();
		$peakUsage			= self::$profiler->getPeakMemoryUsage();

			//send firelogger headers for the ui
		flog('OverallMemoryUsage',$this->toMegaByte($overallUsage),'MB');
		flog('PeakMemoryUsage',$this->toMegaByte($peakUsage),'MB');
		flog('TimeSpend',$timeSpend,'ms');
		flog('SampleCount',$sampleCount);
		flog('TopMemoryUsers',array_slice($memoryItems,0,50));
		flog('TopCpuUsers',array_slice($timeItems,0,50));

			//send own x header for automated testing
		header('X-Takeoff-OverallMemory: '.  $this->toMegaByte($overallUsage));
		header('X-Takeoff-PeakMemory: '. $this->toMegaByte($peakUsage) );
		header('X-Takeoff-TimeSpend: '. $timeSpend);
		header('X-Takeoff-SampleCount: '.$sampleCount);
		header('Y-Takeoff-TopMemoryUsers: '.json_encode(array_slice($memoryItems,0,10)));
		header('Y-Takeoff-TopCpuUsers: '.json_encode(array_slice($timeItems,0,10)));
	}
}