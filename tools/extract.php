<?php
include_once 'lib/index.php';

if ($argc < 2) {
    echo "Usage: php extract.php <filename>" . PHP_EOL;
    exit(1);
}
$filename = $argv[1];

if (!is_dir('temp')) {
    if (!mkdir('temp', 0755, true)) {
        die('Failed to create temp directory');
    }
} else exec('rm -rf temp/*');

$files = ['en_us.json', 'hu_hu.json'];

foreach($files as $file) {
  $command = "unzip '$filename' 'assets/*/lang/'" . $file . " -d temp 2>/dev/null";
  exec($command, $output, $return_var);
}

if (!is_dir('temp/assets')) {
  echo "\e[033m ! No assets extracted from: " . $filename . "\e[0m" . PHP_EOL;
  exit(0);
}

try {
  $dir = new DirectoryIterator('temp/assets');
  $keys = [];
  foreach ($dir as $fileinfo) {
      if ($fileinfo->isDir() && !$fileinfo->isDot()) {
          $keys[] = $fileinfo->getFilename();
      }
  }

  foreach($keys as $key) {
    if (!is_dir("../originals/$key")) {
        if (!mkdir("../originals2/$key", 0755, true)) {
            die('Failed to create directory');
        }
    }

    foreach($files as $file)
    {
      $source = "temp/assets/$key/lang/$file";
      $destination = "../originals2/$key/$file";
      if (@rename($source, $destination)) echo "\e[032m   * Extracted: \e[034m$file\e[0m" . PHP_EOL;
    }
  }

  exec('rm -rf temp/*');

} catch (Exception $e) {
  echo "\e[031m ! Error: " . $e->getMessage() . "\e[0m" . PHP_EOL;
}

