<?php

namespace Ryanhs\GAToolkit;

require 'vendor/autoload.php';

use \Ryanhs\Hook\Hook;

class Dependency{
	
	const HOOK_INIT = 'Dependency_init';
	const HOOK_SET = 'Dependency_set_';
	const HOOK_GET = 'Dependency_get_';
	const HOOK_CALL = 'Dependency_call_';
	const HOOK_UNSET = 'Dependency_unset_';
	
	protected $dependencies = array();
	
	public function __construct(){
		Hook::call(self::HOOK_INIT);
	}
	
	public function __set($var, $value){
		$this->dependencies[$var] = $value;
		
		Hook::call(self::HOOK_SET . $var);
	}
	
	public function __get($var){
		if (array_key_exists($var, $this->dependencies)) {	
			Hook::call(self::HOOK_GET . $var);
            return $this->dependencies[$var];
        }
        
        return null;
	}
	
	public function __call($var, $params = array()){
		if (array_key_exists($var, $this->dependencies)) {
			Hook::call(self::HOOK_GET . $var);
			Hook::call(self::HOOK_CALL . $var);
            return call_user_func_array($this->dependencies[$var], $params);
        }
	}
	
	public function __isset($var){
		return isset($this->dependencies[$var]);
	}
	
	public function __unset($var){
		unset($this->dependencies[$var]);
		Hook::call(self::HOOK_UNSET . $var);
	}
}
