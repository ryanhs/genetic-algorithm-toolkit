<?php

namespace Ryanhs\GAToolkit\Chromosome;

require 'vendor/autoload.php';

class SimpleStringOptimized extends SimpleString{
		
	public function crossover($partner, $options = array()){		
		$tmp_options = array_merge(self::$options_default, $options);
		
		$goal = str_split($options['goal']);
		$a = str_split($partner->get_data());
		$b = str_split($this->data);
		
		$c_data = '';
		foreach($goal as $i => $chr){
			
			if(isset($a[$i]) && isset($b[$i])){
				$c_data .= $chr == $a[$i] ? $a[$i] : $b[$i];
			}
			else if(isset($a[$i]) && !isset($b[$i])){
				$c_data .= $a[$i];
			}
			else if(isset($b[$i]) && !isset($a[$i])){
				$c_data .= $b[$i];
			}
			else{
				$c_data .= mt_rand(0, strlen($tmp_options['seed']) - 1);
			}
		}
		$class_name = get_called_class();
		return new $class_name($c_data);
	}
	
	// implement later
	public function mutation1($goal = false){
		
	}
	
}
