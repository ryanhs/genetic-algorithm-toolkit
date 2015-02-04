<?php

namespace Ryanhs\GAToolkit\Chromosome;

require 'vendor/autoload.php';


abstract class AbstractChromosome{
	
	// mixed, chromosome data
	protected $data;
	
	// data for storing after do fitness_function
	protected $fitness;
	
	// array of tmp, may usefull for algorithm to attach some information about this chromosome
	public $tmp = array();
	
	// generate new random chromosome (usefull for init population)
	// MUST INHERITE THIS METHOD!
	public static function generate($options = array()){
		$class_name = get_called_class();
		return new $class_name(null);
	}
	
	// get data, breeding purpose?
	public function get_data(){
		return $this->data;
	}
	
	// get fitness
	public function get_fitness(){
		return $this->fitness;
	}
	
	// check this chromosome fitness
	public abstract function fitness_function($goal = null);
	
	// crossover? mating? yeah be a parent
	public abstract function crossover($partner, $options = array());
	
	// become a wolverine, yeah!!
	public abstract function mutation($goal = false);
}
