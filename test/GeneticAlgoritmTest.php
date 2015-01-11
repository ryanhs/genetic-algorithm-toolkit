<?php

require 'vendor/autoload.php';

class GeneticAlgoritmTest extends PHPUnit_Framework_TestCase{	
	
	public function testInit(){
		$d = new \Ryanhs\GAToolkit\Dependency();
		$ga = new \Ryanhs\GAToolkit\GeneticAlgorithm($d);
		
		$this->assertInstanceOf('\Ryanhs\GAToolkit\GeneticAlgorithm', $ga);
	}
	
	public function testOption(){
		$d = new \Ryanhs\GAToolkit\Dependency();
		$ga = new \Ryanhs\GAToolkit\GeneticAlgorithm($d);
		
		$ga->set_option('a', '1');
		$ga->set_option('b', '2');
		
		$this->assertEquals('1', $ga->get_option('a'));
		$this->assertEquals('2', $ga->get_option('b'));
	}
	
	public function testOptionArray(){
		$d = new \Ryanhs\GAToolkit\Dependency();
		$ga = new \Ryanhs\GAToolkit\GeneticAlgorithm($d);
		
		$ga->set_option(array(
			'a' => '1',
			'b' => '2'
		));
		
		$this->assertEquals('1', $ga->get_option('a'));
		$this->assertEquals('2', $ga->get_option('b'));
	}
}
