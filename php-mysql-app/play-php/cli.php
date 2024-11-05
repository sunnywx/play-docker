<?php

if ($argc !== 2) {
  echo "Usage: php cli.php <name>" . PHP_EOL;
  exit(1);
}

// var_dump($argv);
$name=$argv[1];
echo "hello, $name". PHP_EOL;

