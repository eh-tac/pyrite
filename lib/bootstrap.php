<?php
set_error_handler(function (int $severity, string $message, string $file, int $line): bool {
  if (error_reporting() & $severity) {
    // minor stuff
    echo "<pre>";
    print_r(['error', $severity, $message, $file, $line]);
    echo "</pre>";
  } else {
    throw new ErrorException($message, 0, $severity, $file, $line);
  }
  return false; // call normal PHP error handler as well
});

function pyriteLoader(string $class)
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
    if (strpos($class, 'Base') !== false) {
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
