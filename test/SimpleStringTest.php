<?php

require 'vendor/autoload.php';

class SimpleStringTest extends PHPUnit_Framework_TestCase{	
	
	public function testInit(){
		$options = array(
			'length' => 4,
		);
		$c = \Ryanhs\GAToolkit\Chromosome\SimpleString::generate($options);
		
		$this->assertInstanceOf('\Ryanhs\GAToolkit\Chromosome\AbstractChromosome', $c);
	}
	
	public function testFitness(){
		$goal = 'test';
		
		$options = array(
			'length' => strlen($goal),
		);
		$c = \Ryanhs\GAToolkit\Chromosome\SimpleString::generate($options);
		
		$this->assertGreaterThanOrEqual(0, $c->fitness_function($goal));
	}
	
	public function testBreeding(){
		$goal = 'test';
		
		$options = array(
			'length' => strlen($goal),
		);
		
		$a = \Ryanhs\GAToolkit\Chromosome\SimpleString::generate($options);
		$b = \Ryanhs\GAToolkit\Chromosome\SimpleString::generate($options);
		
		$c = $a->breeding($b);
		
		$this->assertInstanceOf('\Ryanhs\GAToolkit\Chromosome\AbstractChromosome', $c);
		$this->assertGreaterThanOrEqual(0, $c->fitness_function($goal));
	}
	
	public function testMutation(){
		$goal = 'test';
		
		$options = array(
			'length' => strlen($goal),
		);
		
		$a = \Ryanhs\GAToolkit\Chromosome\SimpleString::generate($options);
		
		$a->mutation($goal);
		
		$this->assertGreaterThanOrEqual(1, $a->fitness_function($goal));
	}
	
}
