<?php

namespace Ryanhs\GAToolkit;

require 'vendor/autoload.php';

use Ryanhs\Hook\Hook;

class GeneticAlgorithm{
	
	static $hook_init = 'GeneticAlgoritm_init';
	
	protected $dependency;
	protected $options = array(
		'debug' => false,
		
		'max_population' => 20,
		'selection' => 90, // percent
		'mutation' => 1, // percent
	);
	
	public function __construct(Dependency $dependency){
		$this->dependency = $dependency;
		
		Hook::call(self::$hook_init);
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
	
	
	
}
