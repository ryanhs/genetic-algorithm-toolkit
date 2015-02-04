<?php

namespace Ryanhs\GAToolkit;

require 'vendor/autoload.php';
use \Ryanhs\Hook\Hook;
use \Ryanhs\Dependency\Dependency;


class Generation{
	
	const HOOK_INIT = 'RGTGeneration_init';
	const HOOK_INIT_POPULATION = 'RGTGeneration_init_population';
	const HOOK_FITNESS_FUNCTION = 'RGTGeneration_fitness_function';
	const HOOK_SELECTION = 'RGTGeneration_selection';
	const HOOK_CROSSOVER = 'RGTGeneration_crossover';
	const HOOK_MUTATION = 'RGTGeneration_mutation';
	
	protected $chromosome_class;
	public $best_chromosome;
	protected $population;
	protected $population_history;
	protected $population_fitness;
	protected $i = 1;
	
	public function __construct($chromosome_class){
		$this->chromosome_class = $chromosome_class;
		$this->best_chromosome = null;
		$this->population = array();
		$this->population_fitness = array();
		$this->population_history = array();
		
		Hook::call(self::HOOK_INIT, array(
			'object' => $this
		));
	}
	
	public function __toString(){
		return strval($this->i);
	}
	
	public function get_chromosome_class(){
		return $this->chromosome_class;
	}
	
	public function get_population(){
		return $this->population;
	}
	
	public function init_population($max = 20, $goal){
		for($i = 0; $i < $max; $i++){
			$this->population[] = call_user_func(array($this->chromosome_class, 'generate'), array('goal' => $goal));
		}
	}
	
	public function fitness_function($goal = null){
		$best = 0;
		foreach($this->population as $index => $entity){
			$entity->fitness_function($goal);
			$this->population_fitness[$index] = $entity->get_fitness();
			
			if($entity->get_fitness() > $this->population[$best]->get_fitness()){
				$best = $index;
			}
		}
		
		arsort($this->population_fitness);
		
		$this->best_chromosome = $this->population[$best];
	}
	
	public function selection($rate = 0.75){
		$pc = count($this->population);
		$pc_to = floor($rate / 1 * $pc);

		// get slice based on fitness_function
		$this->population_fitness = array_slice($this->population_fitness, 0, $pc_to - 1);
		$new_population = array();
		foreach($this->population_fitness as $i => $fitness){
			$new_population[] = $this->population[$i];
			
			//echo $this->population[$i]->get_data() . PHP_EOL;
		}

		$this->population = $new_population;
	}
	
	public function crossover($max = 20, $goal = null){
		$this->population_history[] = $this->population;

		$new_population = array();
		$count = count($this->population) - 1;
		for($i = 0; $i < $max; $i++){
			$a = $this->population[mt_rand(0, $count)];
			$b = $this->population[mt_rand(0, $count)];

			$c = $a->crossover($b, array('goal' => $goal));
			$new_population[] = $c;
		}

		$this->population = $new_population;
		$this->population_fitness = array();
		$this->i++;
	}
	
	public function mutation($chance = 0.01, $goal = null){
		foreach($this->population as $index => $entity){
			if(mt_rand() / mt_getrandmax() < $chance){
				$entity->mutation($goal);
			}
		}
	}
}
