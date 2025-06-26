<?php
include_once 'lib/index.php';

$pass1 = [
  'quantum alloy' => 'kvantumötvözet',
  'quantum computer' => 'kvantumszámítógép',
  'quantum armor' => 'kvantumpáncél',
  'quantum processor' => 'kvantumprocesszor',
  'quantum infusion' => 'kvantuminfúzió',
  'pattern encoder' => 'mintakódoló',
  'pattern provider' => 'mintaszolgáltató',
  'reaction chamber' => 'reakciókamra',
  'crafting unit' => 'barkácsoló egység',
  'night vision' => 'éjjellátás',
  'infused dust' => 'infúziós por',
  'sprint speed' => 'sprintelés',
  'jump height' => 'ugrási magasság',
  'import export bus' => 'import/export busz',
  'auto stock' => 'automatikus készlet',
  'auto feeding' => 'automatikus etetés',
  'attack speed' => 'támadási sebesség',
  'processing pattern' => 'feldolgozó minta',
];

$pass2 = [
  'quantum' => 'kvantum',
  'accelerator' => 'gyorsító',
  'entangler' => 'összefonó',
  'slab' => 'lap',
  'wall' => 'fal',
  'advanced' => 'fejlett',
  'structure' => 'szerkezet',
  'storage' => 'tároló',
  'multi-threader' => 'többszálasító',
  'infusion' => 'infúzió',
  'core' => 'mag',
  'data' => 'adat',
  'extended' => 'kiterjesztett',
  'pattern' => 'minta',
  'configuration' => 'konfiguráció',
  'setting' => 'beállítás',
  'config' => 'konfig',
  'card' => 'kártya',
  'magnet' => 'mágnes',
  'luck' => 'szerencse',
  'flight' => 'repülés',
  'evasion' => 'kitérés',
  'reach' => 'elérés',
  'strength' => 'erő',
  'immunity' => 'immunitás',
  'boots' => 'csizma',
  'helmet' => 'sisak',
  'leggings' => 'lábszárvédő',
  'infused' => 'infúziós',
  'printed' => 'nyomtatott',
  'circuit' => 'áramkör',
  'portable' => 'hordozható',
  'workbench' => 'munkaaasztal',
  'recharging' => 'töltés',
  'regeneration' => 'regeneráció',
  'buffer' => 'puffer',
  'upgrade' => 'fejlesztés',
  'capacity' => 'kapacitás',
];

$pass3 = [
  // 'adv.' => 'fejlett',
  'clear' => 'törlés',
  'input' => 'bemenet',
  'output' => 'kimenet',
];

$grammar = [
];

$fixes = [
];

$data = processFile(
  '../originals/advanced_ae/en_us.json',
  [
    ...$dictionary,
    $pass1,
    $pass2,
    $pass3,
    $grammar,
    $fixes,
  ]
);

$data['gui.advanced_ae.ModName'] = 'Advanced AE';

$file = $argc > 1 ? $argv[1] ?? 'advanced_ae.json' : 'advanced_ae.json';
saveAs($data, $file, true);
