<?php

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Extension for performance profiling',
	'description' => 'Extension to retrieve profiling information during website rendering, to display in firebug or automated testing',
	'category' => 'plugin',
	'author' => 'Timo Schmidt',
	'author_email' => 'timo-schmidt@gmx.net',
	'author_company' => '',
	'shy' => '',
	'dependencies' => 'cms',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'alpha',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'version' => '0.1.0',
	'constraints' => array(
		'depends' => array(
			'cms' => '',
			'php' => '5.3.0',
			'typo3' => '4.5.0-0.0.0',
		),
		'conflicts' => array(
		),
		'suggests' => array(
			'typo3' => '4.6.0-0.0.0',
		),
	),
);

?>
