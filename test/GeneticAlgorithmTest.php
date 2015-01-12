<?php

require 'vendor/autoload.php';

class GeneticAlgorithmTest extends PHPUnit_Framework_TestCase{	
	
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
	
	public function testFitness(){
		$d = new \Ryanhs\GAToolkit\Dependency();
		$d->chromosome = '\Ryanhs\GAToolkit\Chromosome\SimpleString';
		
		$ga = new \Ryanhs\GAToolkit\GeneticAlgorithm($d);
		$ga->set_option(array(
			'goal' => 'test',
			
			'max_generation' => 5,
			'max_population' => 20,
			'selection' => 90, // percent
			'mutation' => 1, // percent
		));
		
		$chromosome_options = array(
			'length' => 4
		);
		
		$population = $ga->init_population($chromosome_options)->get_population();
		$fitness_function = $ga->fitness_function()->get_population_fitness();
		
		foreach($population as $key => $chromosome){
			$this->assertArrayHasKey($key, $fitness_function);
			$this->assertEquals($chromosome->tmp['fitness'], $fitness_function[$key]);
		}
	}
	
	public function testSelection(){
		$d = new \Ryanhs\GAToolkit\Dependency();
		$d->chromosome = '\Ryanhs\GAToolkit\Chromosome\SimpleString';
		
		$ga = new \Ryanhs\GAToolkit\GeneticAlgorithm($d);
		$ga->set_option(array(
			'goal' => 'test',
			
			'max_generation' => 5,
			'max_population' => 20,
			'selection' => 90, // percent
			'mutation' => 1, // percent
		));
		
		$chromosome_options = array(
			'length' => 4
		);
		
		$before = $ga->init_population($chromosome_options)->get_population();
		$ga->fitness_function();
		$after = $ga->selection()->get_population();
		
		$this->assertGreaterThan(count($after), count($before));
		$this->assertArraySubset($after, $before);
	}
	
	
	public function testCrossover(){
		$d = new \Ryanhs\GAToolkit\Dependency();
		$d->chromosome = '\Ryanhs\GAToolkit\Chromosome\SimpleString';
		
		$ga = new \Ryanhs\GAToolkit\GeneticAlgorithm($d);
		$ga->set_option(array(
			'goal' => 'test',
			
			'max_generation' => 5,
			'max_population' => 20,
			'selection' => 90, // percent
			'mutation' => 1, // percent
		));
		
		$chromosome_options = array(
			'length' => 4
		);
		
		$before = $ga->init_population($chromosome_options)->get_population();
		$after = $ga->crossover()->get_population();
		
		$this->assertCount(20, $after);
		$this->assertNotEquals($after, $before);
	}
}
