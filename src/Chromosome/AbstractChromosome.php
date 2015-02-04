<?php

namespace Ryanhs\GAToolkit\Chromosome;

require 'vendor/autoload.php';


abstract class AbstractChromosome{
	
	// mixed, chromosome data
	protected $data;
	
	// array of tmp, may usefull for algorithm to attach some information about this chromosome
	public $tmp = array();
	
	// generate new random chromosome (usefull for init population)
	// MUST INHERITE THIS METHOD!
	public static function generate($options){
		$class_name = get_called_class();
		return new $class_name(null);
	}
	
	// get data, breeding purpose?
	public function get_data(){
		return $this->data;
	}
	
	// check this chromosome fitness
	public abstract function fitness_function();
	
	// crossover? mating? yeah be a parent
	public abstract function breeding($partner, $options = array());
	
	// alias of breeding
	public function crossover($partner, $options = array()){
		return $this->breeding($partner, $options);
	}
	
	// become a wolverine, yeah!!
	public abstract function mutation($goal = false);
}
