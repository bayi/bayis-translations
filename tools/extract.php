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

// first directory is the key
$dir = new DirectoryIterator('temp/assets');
$keys = [];
foreach ($dir as $fileinfo) {
    if ($fileinfo->isDir() && !$fileinfo->isDot()) {
        $keys[] = $fileinfo->getFilename();
    }
}
$key = $keys[0] ?? null;

if (is_null($key)) {
    echo "No keys found in the zip file.\n";
    exit(1);
}

if (!is_dir("../originals/$key")) {
    if (!mkdir("../originals/$key", 0755, true)) {
        die('Failed to create directory');
    }
}

$source = "temp/assets/$key/lang/en_us.json";
$destination = "../originals/$key/en_us.json";
if (!rename($source, $destination)) {
    die('Failed to move file');
}

exec('rm -rf temp/*');
