<?php
declare(strict_types=1);

use Loader\Psr4Autoloader;

require_once('loader' .DIRECTORY_SEPARATOR . 'Psr4Autoloader.php');

(new Psr4Autoloader())
    ->addNamespace('App','classes/app')
    ->addNamespace('App','classes/library')
    ->addNamespace('Tests','classes/unit')
    ->register();

$a = new \App\SampleClass();
$b = new \App\AnotherSampleClass();
$c = new \Tests\tests\SampleTestClass();

var_dump($a, $b, $c);