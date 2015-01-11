# genetic-algorithm-tooklit
Genetic Algorithm Toolkit in PHP

# Description
this toolkit focused on build genetic algorithm application
you can costumize it with your own schema, like:

- chromosome
- init population
- fitness function
- mutation

###### * for selection & crossover, because it just simple act of chromosome & fitness function, just leave to this toolkit :-)

simple application may use string based chromosome,
but more complex application can use costume chromosome.

for costumizing it use dependency injection, for example:
<pre><code>&lt;?php

$d = new \Ryanhs\GAToolkit\Dependency();
$d->chromosome = new MyChromosome();

$ga = new \Ryanhs\GAToolkit\GeneticAlgorithm($d);
		
?&gt;</code></pre>

# Example

<pre><code>&lt;?php

require 'vendor/autoload.php';

$ga = new \Ryanhs\GAToolkit\GeneticAlgorithm();

$ga->set_option('debug', true);

$ga->ioc->chromosome = '\Ryanhs\GAToolkit\Chromosome\SimpleString';
$ga->ioc->init_population = '\Ryanhs\GAToolkit\InitPopulation\SimpleString';
$ga->ioc->fitness_function = '\Ryanhs\GAToolkit\FitnessFunction\SimpleString';
$ga->ioc->mutation = '\Ryanhs\GAToolkit\Mutation\SimpleString';

$ga->run();

?&gt;</code></pre>


# License
MIT License
