<?php
define( 'BASEDIR', dirname( __FILE__ , 3));

$env = [];
if (file_exists(BASEDIR . '/.env'))
{
  $env = parse_ini_file(BASEDIR . '/.env');
}

$versions = [];
$srcDir = BASEDIR . '/src';
if (is_dir($srcDir)) {
    $dir = new DirectoryIterator($srcDir);
    foreach ($dir as $fileinfo) {
        if ($fileinfo->isDir() && !$fileinfo->isDot()) {
            $name = $fileinfo->getFilename();
            $envName = 'PACK_' . strtoupper(str_replace('.', '_', $name));
            $versions[$name] = $env[$envName] ?? null;
        }
    }
}

include_once 'dictionary.php';
include_once 'modrinth.php';
include_once 'utils.php';

