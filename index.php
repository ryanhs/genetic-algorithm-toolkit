<?php

require 'vendor/autoload.php';

$d = new \Ryanhs\GAToolkit\Dependency();
$d->chromosome = '\Ryanhs\GAToolkit\Chromosome\SimpleString';

$options = array(
	'length' => 4,
	'goal' => 'test',
	
	'max_generation' => 5
);

$ga = new \Ryanhs\GAToolkit\GeneticAlgorithm($d);


\Ryanhs\Hook\Hook::on(\Ryanhs\GAToolkit\GeneticAlgorithm::HOOK_REGENERATION, function() use ($ga){
	echo 'Regeneration ' . $ga->population_i . ' => ' . $ga->get_best()->get_data() . PHP_EOL;
});

$res = $ga->run($options);

var_dump(
	$res
);
