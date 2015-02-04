<?php

namespace Ryanhs\GAToolkit\Chromosome;

require 'vendor/autoload.php';

class SimpleStringOptimized extends SimpleString{
		
	public function breeding($partner, $options = array()){
		// back compatibility
		if(!isset($options['goal']))
			return parent::breeding($partner, $options);
		
		$goal = str_split($options['goal']);
		$a = str_split($partner->get_data());
		$b = str_split($this->data);
		
		$c_data = '';
		foreach($goal as $i => $chr){
			
			$tmp_a = isset($a[$i]) ? $a[$i] : rand(0, strlen($tmp_options['seed']) - 1);
			$tmp_b = isset($b[$i]) ? $b[$i] : rand(0, strlen($tmp_options['seed']) - 1);
			
			if($tmp_a == $chr)
				$c_data .= $tmp_a;
			else if($tmp_b == $chr)
				$c_data .= $tmp_b;
			else
				$c_data .= rand(0, 1) == 1 ? $tmp_a : $tmp_b;
		}
		
		
		echo $c_data . PHP_EOL;
		
		//echo $c_data . PHP_EOL;
		$class_name = get_called_class();
		return new $class_name($c_data);
	}
	
	public function mutation($goal = false){
		if($goal === false)
			return $this;
		
		$new_data = str_split($this->data);
		$goal = str_split(strval($goal));
		
		$chromosome_i = rand(0, count($goal) - 1);
		if(isset($new_data[$chromosome_i])){
			$new_data[$chromosome_i] = $goal[$chromosome_i];
		}
		
		$this->data = implode($new_data);
		
		return $this;
	}
	
}
