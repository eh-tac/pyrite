<?php

function pyriteLoader($class)
{
    $ds      = DIRECTORY_SEPARATOR;
    $rootDir = dirname(__FILE__) . $ds;
    $path    = [$rootDir, 'lib' . $ds];

    // Pyrite\TIE\Mission\Base
    $class = str_replace('Pyrite\\', '', $class); //strip project name;
    // TIE\Mission\Base
    $bits = explode('\\', $class);
    $path = implode($ds, $bits) . '.php';
    if (file_exists($path)) {
        require_once $path;
    } else {
        echo "Tried to turn $class into $path but its not there\n";
    }
}

spl_autoload_register('pyriteLoader');

$dir = dirname(dirname(__FILE__)) . '/lib/';
$builder = new Pyrite\Build\Builder($dir);
//$ts = new Pyrite\Build\TSBuilder($dir, $dir . 'editor/pyrite/src/model/');

$out = $builder->run(['TIE']);
//$out = $ts->run(['TIE']);