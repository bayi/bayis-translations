<?php
include_once 'utils.php';

function loadDictionarySet(string $key, string $set) : array
{
  $ret = [];
  $folder = BASEDIR . '/dictionaries/' . $key . '/' . $set;
  if (is_dir($folder)) {
    $files = glob($folder . '/*.json');
    foreach ($files as $file) $ret[] = loadFile($file);
  }
  return $ret;
}

function loadDictionary(string $key, ?array $dict = []) : array
{
  $ret = [];
  $before = loadDictionarySet($key, 'before');
  $after = loadDictionarySet($key, 'after');
  foreach ($before as $d) $ret[] = $d;
  foreach ($dict as $d) $ret[] = $d;
  foreach ($after as $d) $ret[] = $d;
  return $ret;
}

$baseWords = loadDictionary('base', [
  initDictionaryFromSource(BASEDIR . '/dictionaries/minecraft/hu_hu.json', 'block.minecraft.')
]);
