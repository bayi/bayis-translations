<?php
include_once 'lib/index.php';

$minecraft = loadFile('../originals/minecraft/hu_hu.json');
$target = $argv[1] ?? 'vanillabackport';

$source = loadFile('../originals/' . $target . '/en_us.json');
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

saveAs($result, '../src/assets/' . $target . '/lang/hu_hu.json');
