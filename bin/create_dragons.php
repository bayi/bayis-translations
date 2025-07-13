<?php
include_once 'lib/index.php';

$pass1 = [
  'dyes' => 'festékek',
  'fluid hatch' => 'folyadéknyílás',
  'coloring' => 'festés',
  'freezing' => 'fagyasztás',
  'sanding' => 'csiszolás',
  'ending' => 'endezés',
  'can be frozen' => 'fagyasztható',
  'can be sanded' => 'csiszolható',
  'can be ended' => 'endezhető',
  'cannot be frozen' => 'nem fagyasztható',
  'cannot be sanded' => 'nem csiszolható',
  'cannot be ended' => 'nem endezhető',
  'dragon\'s breath' => 'sárkánylehelet',
  'dragon breath' => 'sárkánylehelet',
  'smithing template' => 'kovácssablon',
  'blaze burner' => 'őrlángégő',
  // 'fan behind' => 'mögötti ventilátor',
];

$pass2 = [
  'dye' => 'festék',
  'bulk' => 'nagyüzemi',
  'blaze' => 'őrláng',
  'upgrade' => 'fejlesztés',
  'catalysts' => 'katalizátorok',
  'passive' => 'passzív',
  'freezer' => 'fagyasztó',
  'freezers' => 'fagyasztók',
  'working' => 'működő',
];

$pass3 = [
  'festék bucket' => 'festékes vödör',
  'festék buckets' => 'festékes vödrök',
];

$grammar = [
  'buckets' => 'vödrök',
];

$fixes = [
];

$data = processFile(
  '../originals/create_dragons_plus/en_us.json',
  [
    ...$dictionary,
    $pass1,
    $pass2,
    $pass3,
    $grammar,
    $fixes,
  ]
);

foreach ($data as $key => $value) {
}

$file = $argc > 1 ? $argv[1] ?? 'create_dragons_plus.json' : 'create_dragons_plus.json';
saveAs($data, $file, true);
