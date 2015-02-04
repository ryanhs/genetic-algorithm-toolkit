<?php

namespace Ryanhs\GAToolkit;

require 'vendor/autoload.php';
use \Ryanhs\Hook\Hook;
use \Ryanhs\Dependency\Dependency;


class Toolkit extends Dependency{
	
	const HOOK_INIT = 'RGTToolkit_init';
	const HOOK_INIT_POPULATION = 'RGTToolkit_init_population';
	const HOOK_REGENERATION = 'RGTToolkit_regeneration';
	const HOOK_FINISH_GOAL = 'RGTToolkit_finish_goal';
	const HOOK_FINISH_NOGOAL = 'RGTToolkit_finish_no_goal';
	
	public function __construct(){
		
		$this->selection = 0.75;
		$this->mutation = 0.01;
		
		$this->max_generation = 10000;
		$this->max_population = 20;
		
		$this->generation_history = array();
		$this->generation = null;
		$this->best_chromosome = null;
		
		$this->solution = null;
		
		Hook::call(self::HOOK_INIT, array(
			'object' => $this
		));
		
		parent::__construct();
	}
	
	public function run(){
		$this->generation = new Generation($this->chromosome);
		$this->generation->init_population($this->max_population, $this->goal);
		
	// first generation	
		$this->generation->fitness_function($this->goal);
		$this->solution = $this->generation->best_chromosome->get_data();
		Hook::call(self::HOOK_REGENERATION, array(
			'object' => $this
		));
		
		while(intval($this->generation->__toString()) < $this->max_generation){
			
			// for some reason we have to work on this, Notice: Indirect modification of overloaded property
			//$this->dependency['generation_history'][] = $this->generation->get_population();
			
			$this->generation->selection($this->selection);
			$this->generation->crossover($this->max_population, $this->goal);
			$this->generation->mutation($this->mutation, $this->goal);
			
			$this->generation->fitness_function($this->goal);
			$this->solution = $this->generation->best_chromosome->get_data();
			
			if($this->solution == $this->goal){
				Hook::call(self::HOOK_FINISH_GOAL, array(
					'object' => $this
				));
				return true;
			}
			
			Hook::call(self::HOOK_REGENERATION, array(
				'object' => $this
			));
		}
		
		Hook::call(self::HOOK_FINISH_NOGOAL, array(
			'object' => $this
		));
		
		return false;
	}
}
