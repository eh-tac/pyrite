<?php
set_error_handler(function ($severity, $message, $file, $line) {
  if (error_reporting() & $severity) {
    // minor stuff
    echo "<pre>";
    print_r(['error', $severity, $message, $file, $line]);
    echo "</pre>";
  } else {
    throw new ErrorException($message, 0, $severity, $file, $line);
  }
});

function pyriteLoader($class)
{
  $ds      = DIRECTORY_SEPARATOR;
  $rootDir = dirname(__FILE__) . $ds;
  $path    = [$rootDir, 'lib'];

  // Pyrite\TIE\MissionBase
  $class = str_replace('Pyrite\\', '', $class); //strip project name;
  // TIE\MissionBase
  $bits = explode('\\', $class);
  if (count($bits) === 2) {
    list($platform, $class) = $bits;

    $path[] = $platform . $ds;
    if (strpos($class, 'Base')) {
      $path[] = 'gen' . $ds;
    }
  }

  $path[] = $class . '.php';
  $path   = implode('', $path);
  if (file_exists($path)) {
    require_once $path;
  }
}

spl_autoload_register('pyriteLoader');
