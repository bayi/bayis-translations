<?php
function printHeader(string $label) : void
{
  echo "\e[34m ----- $label -----\e[0m\n\n";
}

function printKv(string $key, string $value, ?bool $inLine = false) : void
{
  echo "\e[33m $key\e[0m: \e[31m$value\e[0m";
  if (!$inLine) echo "\n";
}

function printKeys(string $label, array $keys) : void
{
  if(count($keys) == 0) return;
  printHeader($label);
  foreach ($keys as $key => $value) printKv($key, $value);
  echo "\n";
  printHeader('End of ' . $label);
}

function getProgress(string $version, string $key, string $target = 'active') : array
{
  try {
    $src = loadFile(BASEDIR . '/src/' . $version . '/upstream/'  . $key . '/lang/en_us.json');
    $dst = loadFile(BASEDIR . '/src/' . $version . '/' . $target . '/'  . $key . '/lang/hu_hu.json');
  } catch (Exception $e) {
    die("! Error: Failed loading resources: " . $e->getMessage() . "\n");
  }
  $data = [
    'missingKeys' => [],
    'extraKeys' => [],
    'untranslatedKeys' => [],
    'totalKeysCount' => count($src),
    'percent' => 0.0,
  ];

  foreach ($src as $key => $value) {
    if (!array_key_exists($key, $dst)) {
      $data['missingKeys'][$key] = $value;
      continue;
    }
    if ($value === $dst[$key]) {
      if (!str_starts_with($key, '_')) {
        $data['untranslatedKeys'][$key] = $value;
        continue;
      }
    }
  }

  foreach ($dst as $key => $value)
    if (!array_key_exists($key, $src)) $data['extraKeys'][$key] = $value;

  $data['percent'] = number_format(100 - (count($data['untranslatedKeys']) / $data['totalKeysCount'] * 100), 2);

  return $data;
}

