<?php

namespace Ryanhs\GAToolkit;

require 'vendor/autoload.php';

use \Ryanhs\Hook\Hook;

class GeneticAlgorithm{
	
	const HOOK_INIT = 'GeneticAlgoritm_init';
	const HOOK_INIT_POPULATION = 'GeneticAlgoritm_init_population';
	const HOOK_FITNESS_FUNCTION = 'GeneticAlgoritm_fitness_function';
	const HOOK_SELECTION = 'GeneticAlgoritm_selection';
	const HOOK_BREEDING = 'GeneticAlgoritm_breeding';
	const HOOK_CROSSOVER = self::HOOK_BREEDING;
	const HOOK_MUTATION = 'GeneticAlgoritm_mutation';
	const HOOK_FINISH = 'GeneticAlgoritm_finish';
	const HOOK_FINISH_GOAL = 'GeneticAlgoritm_finish_goal';
	
	protected $dependency;
	protected $options = array(
		'goal' => false,
				
		'max_generation' => 1000,
		'max_population' => 20,
		'selection' => 90, // percent
		'mutation' => 1, // percent
	);
	
	protected $population;
	protected $population_fitness;
	protected $population_historic;
	
	public function __construct(Dependency $dependency){
		$this->dependency = $dependency;
		
		$this->population = array();
		$this->population_fitness = array();
		$this->population_historic = array();
		
		Hook::call(self::HOOK_INIT);
	}
	
	public function set_option($key_options, $value = null){
		if(is_array($key_options)){
			$this->options = array_merge($this->options, $key_options);
			return true;
		}
		
		$this->options[$key_options] = $value;
		return true;
	}
	
	public function get_option($key){
		return isset($this->options[$key]) ? $this->options[$key] : null;
	}
	
	public function init_population($options = array()){
		$this->population = array();
		$this->population_fitness = array();
		$this->population_historic = array();
		
		for($i = 0; $i < $this->options['max_population']; $i++){
			$this->population[] = call_user_func($this->dependency->chromosome . '::generate', $options);
		}
		Hook::call(self::HOOK_INIT_POPULATION);
		
		return $this;
	}
	
	public function fitness_function(){
		foreach($this->population as $index => $chromosome){
			$fitness = $chromosome->fitness_function($this->options['goal']);
			
			$this->population[$index]->tmp['fitness'] = $fitness;
			$this->population_fitness[$index] = $fitness;
		}
		
		arsort($this->population_fitness);
		Hook::call(self::HOOK_FITNESS_FUNCTION);
		
		return $this;
	}
	
	public function selection(){
		
		Hook::call(self::HOOK_SELECTION);
	}
	
	public function mutation(){
		
		Hook::call(self::HOOK_MUTATION);
	}
	
	public function get_best(){
		return new $this->dependency();
	}
	
	public function get_population(){
		return $this->population;
	}
	
	public function get_population_fitness(){
		return $this->population_fitness;
	}
	
	
	public function run($chromosome_options){
		$this->init_population($chromosome_options);
		
		$match_goal = false;
		$i = 0;
		while($i < $this->options['max_generation']){
			$i++;
			
			$this->fitness_function();
			$this->selection();
			$this->mutation();
			
			// compare the best chromosome to goal
			if($this->get_best()->get_data() == $this->options['goal']){
				$match_goal = true;
				break;
			}
		}
		
		Hook::call(self::HOOK_FINISH);
		
		if($match_goal){
			Hook::call(self::HOOK_FINISH_GOAL);
		}
	}
}
