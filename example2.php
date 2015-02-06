<?php

require 'vendor/autoload.php';
use \Ryanhs\Hook\Hook;
use \Ryanhs\GAToolkit\Generation;
use \Ryanhs\GAToolkit\Toolkit;
use \Ryanhs\GAToolkit\Chromosome\SimpleString;


class MyGeneration extends Generation{
	
	public function crossover($max = 20, $goal = null){
		$this->population_history[] = $this->population;

		$new_population = array();
		$count = count($this->population) - 1;
		for($i = 0; $i < $max; $i++){
			
			
			$tmp = array(
				'chromosome' => null,
				'fitness' => -1,
			);
			
			// breeding, get best child
			for($j = 0; $j < $max; $j++){
					
				$a = $this->population[mt_rand(0, $count)];
				$b = $this->population[mt_rand(0, $count)];
				
				$c = $a->crossover($b, array('goal' => $goal));
				$c->fitness_function($goal);
				if($c->get_fitness() > $tmp['fitness']){
					$tmp['chromosome'] = $c;
					$tmp['fitness'] = $c->get_fitness();
				}
				//echo $c->get_data() . ' => ' . $c->get_fitness(). PHP_EOL;
			}

			$new_population[] = $tmp['chromosome'];
		}

		$this->population = $new_population;
		$this->population_fitness = array();
		$this->i++;
	}
	
}


$ga = new Toolkit();

$ga->chromosome = '\Ryanhs\GAToolkit\Chromosome\SimpleStringStd';
$ga->generation = new MyGeneration($ga->chromosome);

$ga->goal = isset($argv['1']) ? $argv['1'] : 'test';
$ga->selection = 0.9;
$ga->mutation = 0.1;
$ga->max_population = 20; // set max population, mean alot!, 40 is good in (Linux, Intel i5-4210U, RAM 4GB) computer

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
