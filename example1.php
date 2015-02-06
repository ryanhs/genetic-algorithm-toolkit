<?php

require 'vendor/autoload.php';
use \Ryanhs\Hook\Hook;
use \Ryanhs\GAToolkit\Toolkit;
use \Ryanhs\GAToolkit\Chromosome\SimpleString;

$ga = new Toolkit();

$ga->goal = isset($argv['1']) ? $argv['1'] : 'test';
//$ga->chromosome = '\Ryanhs\GAToolkit\Chromosome\SimpleStringOptimized';
$ga->chromosome = '\Ryanhs\GAToolkit\Chromosome\SimpleStringStd';

$ga->selection = 0.9;
$ga->mutation = 0.1;

//$ga->max_generation = 20;
$ga->max_population = 20;

Hook::on(Toolkit::HOOK_REGENERATION, function($params){
	$ga = $params['object'];
	echo 'Generation #' . $ga->generation . ' -> ' . $ga->solution . PHP_EOL;
	
	time_nanosleep(0, 50000000);
});

Hook::on(Toolkit::HOOK_FINISH_GOAL, function($params){
	$ga = $params['object'];
	echo 'Solution get on generation #' . $ga->generation . ' -> ' . $ga->solution . PHP_EOL;
});

Hook::on(Toolkit::HOOK_FINISH_NOGOAL, function($params){
	$ga = $params['object'];
	echo 'No Solution! reach max generation #' . $ga->generation . PHP_EOL;
});

$ga->run();
