<?php

require 'vendor/autoload.php';

class DependencyTest extends PHPUnit_Framework_TestCase{
	
	public function testInit(){
		$d = new \Ryanhs\GAToolkit\Dependency();
		
		$this->assertInstanceOf('\Ryanhs\GAToolkit\Dependency', $d);
	}
	
	public function testClassAlias(){
		class_alias('\Ryanhs\GAToolkit\Dependency', 'DTest');
		
		$d = new Dtest();
		
		$this->assertInstanceOf('\Ryanhs\GAToolkit\Dependency', $d);
	}
	
	public function testSetGet(){
		$o = new StdClass;
		
		$d = new \Ryanhs\GAToolkit\Dependency();
		$d->o = $o;
		
		$this->assertEquals($o, $d->o);
	}
	
	public function testSetCall(){
		$d = new \Ryanhs\GAToolkit\Dependency();
		
		$d->o = function(){
			return 1;
		};
		
		$this->assertEquals(1, $d->o());
	}
	
	public function testSetUnset(){
		$o = new StdClass;
		
		$d = new \Ryanhs\GAToolkit\Dependency();
		$d->o = $o;
		
		unset($d->o);
		
		$this->assertNotEquals($o, $d->o);
	}
	
}
