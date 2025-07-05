<?php

$source = $argv[1] ?? null;
if (!$source) {
    echo "Usage: php csv-to-json.php <source.csv>\n";
    exit(1);
}

$destination = $argv[2] ?? 'output.json';

if (!file_exists($source)) {
    echo "Error: Source file '$source' does not exist.\n";
    exit(1);
}

$fh = fopen($source, 'r');
if (!$fh) {
    echo "Error: Could not open source file '$source'.\n";
    exit(1);
}

$data = [];
$headers = fgetcsv($fh);
while (($row = fgetcsv($fh)) !== false)
  $data[$row[0]] = $row[1];

fclose($fh);
$formatted = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
$formatted = str_replace('    ', '  ', $formatted);
file_put_contents($destination, $formatted);
