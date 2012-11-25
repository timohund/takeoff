<?php


class Tx_Takeoff_View_PhpView {

	/**
	 * @param $variable
	 * @param $value
	 */
	public function assign($variable, $value) {
		$this->{$variable} = $value;
	}

	/**
	 * @return string
	 */
	public function render() {
		ob_start();
		include PATH_tx_takeoff.'Resources/Templates/Report.php';
		$result = ob_get_contents();
		ob_end_clean();

		return $result;
	}

	/**
	 * @param $bytes
	 * @return float
	 */
	protected function toMb($bytes) {
		return round($bytes / (1024 * 1024),2);
	}
}