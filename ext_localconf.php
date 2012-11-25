<?php

define('PATH_tx_takeoff',t3lib_extMgm::extPath($_EXTKEY));

$config = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['takeoff']);

if(is_array($config) && array_key_exists('enable_profiler',$config)) {
	declare(ticks=100);
	$TYPO3_CONF_VARS['SC_OPTIONS']['tslib/index_ts.php']['preprocessRequest'][] = PATH_tx_takeoff.'Classes/Hooks/Profiling.php:user_Tx_Takeoff_Hooks_Profiling->start';
	$TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_fe.php']['hook_eofe'][] = PATH_tx_takeoff.'Classes/Hooks/Profiling.php:user_Tx_Takeoff_Hooks_Profiling->stop';

}

