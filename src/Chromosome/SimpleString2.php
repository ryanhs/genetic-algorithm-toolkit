<?php

namespace Ryanhs\GAToolkit\Chromosome;

require 'vendor/autoload.php';

class SimpleString2 extends SimpleString{
	
	protected $options;
	
	public function __construct($data, $options){
		$this->data = $data;
		$this->options = $options;
	}
	
	public static function generate($options){
		$data = '';
		
		$tmp_options = array_merge(self::$options_default, $options);
		for($i = 0; $i < rand(0, intval($tmp_options['length'])); $i++){
			$c = $tmp_options['seed'][rand(0, strlen($tmp_options['seed']) - 1)];
			$data .= $c;
		}
		return new SimpleString($data, $options);
	}
	
	public function breeding($partner, $options = array()){
		$class_name = get_called_class();
		
		$tmp_a = str_split($partner->get_data());
		$tmp_b = str_split($this->data);

		$tmp_c = $class_name::generate($options);
		
		$c_data = '';
		foreach($tmp_c->get_data() as $i => $chr){
			if(isset($a[$i]) && isset($b[$i])){
				$c_data .= rand(0, 1) == 1 ? $a[$i] : $b[$i];
			}
			elseif(isset($a[$i])){
				$c_data .= $a[$i];
			}
			elseif(isset($b[$i])){
				$c_data .= $b[$i];
			}
		}
		
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
