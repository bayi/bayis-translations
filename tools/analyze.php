<?php
include_once 'utils.php';

if ($argc < 2) die("Usage: " . $argv[0] . " <key>\n");

$key = $argv[1];

$src = loadFile('../originals/' . $key . '/en_us.json');
$dst = loadFile('../src/assets/' . $key . '/lang/hu_hu.json');

$missingKeys = [];
$extraKeys = [];
$untranslatedKeys = [];

foreach ($src as $key => $value) {
  if (!array_key_exists($key, $dst)) {
    $missingKeys[$key] = $value;
    continue;
  }
  if ($value === $dst[$key]) {
    $untranslatedKeys[$key] = $value;
    continue;
  }
}

foreach ($dst as $key => $value) {
  if (!array_key_exists($key, $src)) {
    $extraKeys[$key] = $value;
  }
}

if (count($missingKeys) > 0) {
  echo "\n \e[31m--- Missing keys:\e[0m\n";
  foreach ($missingKeys as $key => $value) {
    echo "$key: $value\n";
  }
}

if (count($untranslatedKeys) > 0) {
  echo "\n \e[32m--- Untranslated keys:\e[0m\n";
  foreach ($untranslatedKeys as $key => $value) {
    echo "$key: $value\n";
  }
}

if (count($extraKeys) > 0) {
  echo "\n \e[32m--- Extra keys:\e[0m\n";
  foreach ($extraKeys as $key => $value) {
    echo "$key: $value\n";
  }
}

echo "\n\n";
