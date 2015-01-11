<?php

namespace Ryanhs\GAToolkit;

require 'vendor/autoload.php';

use Ryanhs\Hook\Hook;

class Dependency{
	
	static $hook_init = 'Dependency_init';
	static $hook_set = 'Dependency_set_';
	static $hook_get = 'Dependency_get_';
	static $hook_call = 'Dependency_call_';
	static $hook_unset = 'Dependency_unset_';
	
	protected $dependencies = array();
	
	public function __construct(){
		Hook::call(self::$hook_init);
	}
	
	public function __set($var, $value){
		$this->dependencies[$var] = $value;
		
		Hook::call(self::$hook_set . $var);
	}
	
	public function __get($var){
		if (array_key_exists($var, $this->dependencies)) {	
			Hook::call(self::$hook_get . $var);
            return $this->dependencies[$var];
        }
        
        return null;
	}
	
	public function __call($var, $params = array()){
		if (array_key_exists($var, $this->dependencies)) {
			Hook::call(self::$hook_get . $var);
			Hook::call(self::$hook_call . $var);
            return call_user_func_array($this->dependencies[$var], $params);
        }
	}
	
	public function __isset($var){
		return isset($this->dependencies[$var]);
	}
	
	public function __unset($var){
		unset($this->dependencies[$var]);
	}
}
