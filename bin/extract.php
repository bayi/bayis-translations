<?php
include_once 'lib/index.php';

if ($argc < 3) {
    echo "Usage: php extract.php <version> <filename>" . PHP_EOL;
    exit(1);
}
$version = $argv[1];
$filename = $argv[2];
extractUpstream($filename, $version);
