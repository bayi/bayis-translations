<?php
include_once 'lib/index.php';

$version = $argv[1] ?? null;
$key = $argv[2] ?? null;
$target = $argv[3] ?? 'active';
if (is_null($key) || is_null($version)) {
    echo "Usage: php spellcheck.php <version> <key>\n";
    exit(1);
}

$file = BASEDIR . '/src/' . $version . "/" . $target . "/" . $key . "/lang/hu_hu.json";
if (!file_exists($file)) {
    echo "File not found: $file\n";
    exit(1);
}
$data = loadFile($file);

foreach ($data as $k => $v) {
  $result = trim(exec("hunspell -d hu_HU -l <<< " . escapeshellarg($v)));
  if ($result)
  {
    echo "[$k] \"$v\" \033[32m" . $result . "\033[0m" . PHP_EOL;
  }
}
