<?php
include_once 'lib/index.php';

foreach($versions as $version => $dir) {
  if (!is_dir($dir)) {
    echo "\e[031m * Directory \e[034m$dir\e[031m does not exist\e[0m" . PHP_EOL;
    continue;
  }
  echo "\e[032m * Processing version \e[034m$version\e[0m" . PHP_EOL;
  $files = scandir($dir);
  foreach($files as $file)
  {
    if (pathinfo($file, PATHINFO_EXTENSION) == "jar") {
      $filePath = $dir . $file;
      echo "\e[032m * Processing \e[034m$filePath\e[0m" . PHP_EOL;
      system("php " . BASEDIR . "/bin/extract.php $version \"$filePath\"");
    }
  }
}

