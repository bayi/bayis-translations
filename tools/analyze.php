<?php
include_once 'lib/index.php';

function printHeader(string $label) : void
{
  echo "\e[34m ----- $label -----\e[0m\n\n";
}

function printKv(string $key, string $value) : void
{
  echo "\e[33m $key\e[0m: \e[31m$value\e[0m\n";
}

function printKeys(string $label, array $keys) : void
{
  if(count($keys) == 0) return;
  printHeader($label);
  foreach ($keys as $key => $value) printKv($key, $value);
  echo "\n";
  printHeader('End of ' . $label);
}

$key = $argv[1] ?? null;
if (is_null($key) || $argc < 2) die("* Usage: " . $argv[0] . " <key>\n");

try {
  $src = loadFile('../originals/' . $key . '/en_us.json');
  $dst = loadFile('../src/assets/' . $key . '/lang/hu_hu.json');
} catch (Exception $e) {
  die("! Error: Failed loading resources: " . $e->getMessage() . "\n");
}

$missingKeys = [];
$extraKeys = [];
$untranslatedKeys = [];
$totalKeysCount = count($src);

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

foreach ($dst as $key => $value)
  if (!array_key_exists($key, $src)) $extraKeys[$key] = $value;

$percent = number_format(100 - (count($untranslatedKeys) / $totalKeysCount * 100), 2);

echo "\n";
printKeys('Extra keys', $extraKeys);
printKeys('Untranslated keys', $untranslatedKeys);
printKeys('Missing keys', $missingKeys);

printHeader("Progress");
printKv("Total Keys", $totalKeysCount);
printKv("Translated keys", count($src) - count($missingKeys) - count($untranslatedKeys));
if (count($untranslatedKeys))
  printKv("Untranslated keys", count($untranslatedKeys));
if (count($missingKeys))
  printKv("Missing keys", count($missingKeys));
printKv("Progress", "\e[32m$percent%\e[0m");
echo "\n";
