<?php
include_once 'lib/index.php';

$version = $argv[1] ?? '1.21.1';
$target = $argv[2] ?? 'vanillabackport';
$minecraft = loadFile(BASEDIR . '/dictionaries/minecraft/hu_hu.json');
$source = loadFile(BASEDIR . '/src/' . $version . '/upstream/' . $target . '/lang/en_us.json');
$result = [];

foreach($source as $key => $value) {
  $minecraftKey = str_replace('.' . $target . '.', '.minecraft.', $key);

  if ($minecraft[$minecraftKey] ?? null) {
    $minecraftValue = $minecraft[$minecraftKey];
    $result[$key] = $minecraftValue;
  } else {
    $result[$key] = $value;
  }
}

$file = $target . '.json';
if ($argc > 3)
    $file = $argv[3];
saveAs($result, $file, true);
