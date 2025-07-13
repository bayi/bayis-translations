<?php
include_once 'lib/index.php';

$key = $argv[1] ?? null;
if (is_null($key)) {
    echo "Usage: php translate.php <key> [output]\n";
    exit(1);
}

$originalFile = '/en_us.json';

$words = loadDictionary($key, $baseWords);
$data = processFile(
    BASEDIR . '/originals/' . $key . $originalFile,
    [
        ...$words,
    ]
);
$data = applyFixed($data, $key);

// Post processing ....
$original = loadFile(BASEDIR . '/originals/' . $key . $originalFile);
foreach ($original as $k => $v) {
  // All uppercase words
  if (preg_match('/^[A-Z]{2,}$/', $v)) $data[$k] = mb_strtoupper($data[$k]);
  // Mid word abbreviations
  if (preg_match('/\b[A-Z]{2,}\b/u', $v)) {
    $abbreviations = preg_split('/\s+/', $v);
    foreach ($abbreviations as $abbreviation) {
      if (mb_strlen($abbreviation) > 1 && mb_strtoupper($abbreviation) === $abbreviation) {
        $abbreviation = ucfirst(mb_strtolower($abbreviation));
        $data[$k] = preg_replace('/\b' . preg_quote($abbreviation, '/') . '\b/u', mb_strtoupper($abbreviation), $data[$k]);
      }
    }
  }
}

$file = $key . '.json';
if ($argc > 2)
    $file = $argv[2];
saveAs($data, $file, true);
