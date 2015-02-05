<?php

namespace Ryanhs\GAToolkit\Chromosome;

require 'vendor/autoload.php';

class SimpleStringStd extends SimpleString{
	
	public function crossover($partner, $options = array()){
		$a = $partner->get_data();
		$b = $this->data;
		
		$a_c = strlen($a);
		$b_c = strlen($b);
		
		$c = '';
		$c_c = $a_c >= $b_c ? $a_c : $b_c;
		
		// if it has same length, great!, use std algorithm
		if($a_c == $b_c){
			$left = mt_rand(0, 1) == 1 ? $a : $b;
			$right = $left == $b ? $a : $b;
			
			$sp = mt_rand(0, $c_c);
			$c .= substr($left, 0, $sp);
			$c .= substr($right, $sp);
		}else{
			/*
			 * put shorter chromosome, in longer chromosome
			 * example:
			 *   a: aaaa
			 *   b: bb
			 *   result: aabb OR abba OR bbaa
			 * */
			$longer = $c_c == $a_c ? 'a' : 'b';
			$shorter = $longer == 'b' ? 'a' : 'b';
			
			$sp_begin = mt_rand(0, ${$longer . '_c'} - ${$shorter . '_c'});
			
			$tmp = substr_replace(${$longer}, ${$shorter}, -$sp_begin);
			$c .= $tmp . substr(${$longer}, strlen($tmp));
		}
		
		$class_name = get_called_class();
		return new $class_name($c);
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
