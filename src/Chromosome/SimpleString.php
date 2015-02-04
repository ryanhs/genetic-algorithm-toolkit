<?php

namespace Ryanhs\GAToolkit\Chromosome;

require 'vendor/autoload.php';

class SimpleString extends AbstractChromosome{
	
	protected static $options_default = array(
		'seed' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890 !@#$%^&*()_+'
		//'seed' => 'abcdefghijklmnopqrstuvwxyz '
	);
	
	public function __construct($data){
		$this->data = $data;
	}
	
	public static function generate($options = array()){
		$data = '';
		
		$tmp_options = array_merge(self::$options_default, $options);
		
		if(!isset($tmp_options['length'])){
			$tmp_options['length'] = strlen($options['goal']);
		}
		
		for($i = 0; $i < intval($tmp_options['length']); $i++){
			$c = $tmp_options['seed'][mt_rand(0, strlen($tmp_options['seed']) - 1)];
			$data .= $c;
		}
		return new SimpleString($data);
	}
	
	public function fitness_function($goal = null){
		$goal = str_split(strval($goal));
		$data = str_split($this->data);
		
		$fitness = 0;
		
		foreach($data as $i => $c){
			if(!empty($goal[$i])){
				if($goal[$i] == $c)
					$fitness++;
			}
		}
		
		$this->fitness = $fitness;
		return $fitness;
	}
	
	public function crossover($partner, $options = array()){
		$tmp_options = array_merge(self::$options_default, $options);
		
		$goal = str_split($options['goal']);
		$a = str_split($partner->get_data());
		$b = str_split($this->data);
		
		$c_data = '';
		foreach($goal as $i => $chr){
			
			if(isset($a[$i]) && isset($b[$i])){
				$c_data .= mt_rand(0, 1) == 1 ? $a[$i] : $b[$i];
			}
			else if(isset($a[$i])){
				$c_data .= $a[$i];
			}
			else if(isset($b[$i])){
				$c_data .= $b[$i];
			}
			else{
				$c_data .= mt_rand(0, strlen($tmp_options['seed']) - 1);
			}
		}
		$class_name = get_called_class();
		return new $class_name($c_data);
	}
	
	public function mutation($goal = false){
		if($goal === false)
			return $this;
		
		$new_data = str_split($this->data);
		$goal = str_split(strval($goal));
		
		$chromosome_i = mt_rand(0, count($goal) - 1);
		if(isset($new_data[$chromosome_i])){
			$new_data[$chromosome_i] = $goal[$chromosome_i];
		}
		
		$this->data = implode($new_data);
	}
	
}
