<?php
include_once 'lib/index.php';
include_once 'lib/progress.php';

$version = $argv[1] ?? null;
$key = $argv[2] ?? null;
$target = $argv[3] ?? 'active';

if (is_null($version) || is_null($key) || $argc < 3) die("* Usage: " . $argv[0] . " <version> <key>\n");

$data = getProgress($version, $key, $target);
if ($data === null)
    die("\e[031m * Error: Failed loading resources for version \e[034m$version\e[031m and key \e[034m$target/$key\e[031m\e[0m\n");

echo "\n";
printKeys('Extra keys', $data['extraKeys']);
printKeys('Untranslated keys', $data['untranslatedKeys']);
printKeys('Missing keys', $data['missingKeys']);

printHeader("Progress");
printKv("Total Keys", $data['totalKeysCount'], true);
printKv("Translated keys", $data['totalKeysCount'] - count($data['missingKeys']) - count($data['untranslatedKeys']));
if (count($data['extraKeys'])) printKv("Extra keys", count($data['extraKeys']));
if (count($data['untranslatedKeys'])) printKv("Untranslated keys", count($data['untranslatedKeys']));
if (count($data['missingKeys'])) printKv("Missing keys", count($data['missingKeys']));
printKv("Progress", "\e[32m". $data['percent'] . "%\e[0m (" . $data['totalKeysCount'] . "/" . count($data['untranslatedKeys']) .")");
echo "\n";
