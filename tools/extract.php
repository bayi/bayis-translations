<?php
include_once 'lib/index.php';

if ($argc < 2) {
    echo "Usage: php extract.php <filename>\n";
    exit(1);
}
$filename = $argv[1];

if (!is_dir('temp')) {
    if (!mkdir('temp', 0755, true)) {
        die('Failed to create temp directory');
    }
} else exec('rm -rf temp/*');
$command = "unzip '$filename' 'assets/*/lang/en_us.json' -d temp";
exec($command, $output, $return_var);
$command = "unzip '$filename' 'assets/*/lang/hu_hu.json' -d temp";
exec($command, $output, $return_var);

// first directory is the key
$dir = new DirectoryIterator('temp/assets');
$keys = [];
foreach ($dir as $fileinfo) {
    if ($fileinfo->isDir() && !$fileinfo->isDot()) {
        $keys[] = $fileinfo->getFilename();
    }
}

foreach($keys as $key) {
  if (!is_dir("../originals/$key")) {
      if (!mkdir("../originals/$key", 0755, true)) {
          die('Failed to create directory');
      }
  }

  $files = ['en_us.json', 'hu_hu.json'];
  foreach($files as $file)
  {
    $source = "temp/assets/$key/lang/$file";
    $destination = "../originals/$key/$file";
    if (!rename($source, $destination)) {
        echo('Failed to move file: ' . $file . PHP_EOL);
    }
  }
}

exec('rm -rf temp/*');
