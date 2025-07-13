<?php
include_once 'lib/index.php';

$pass1 = [
  'quantum alloy' => 'kvantumötvözet',
  'quantum computer' => 'kvantumszámítógép',
  'quantum armor' => 'kvantumpáncél',
  'quantum processor' => 'kvantumprocesszor',
  'quantum infusion bucket' => 'kvantuminfúziós vödör',
  'quantum infusion' => 'kvantuminfúzió',
  'pattern encoder' => 'mintakódoló',
  'pattern provider' => 'mintaszolgáltató',
  'reaction chamber' => 'reakciókamra',
  'crafting unit' => 'barkácsoló egység',
  'night vision' => 'éjjellátás',
  'infused dust' => 'infúziós por',
  'sprint speed' => 'sprintelési sebesség',
  'jump height' => 'ugrási magasság',
  'import export bus' => 'import/export busz',
  'auto stock' => 'automatikus készlet',
  'auto feeding' => 'automatikus etetés',
  'attack speed' => 'támadási sebesség',
  'processing pattern' => 'feldolgozó minta',
  'shattered singularity' => 'törött szingularitás',
  'throughput monitor' => 'átmenő teljesítmény monitor',
  'stock export bus' => 'készlet exportbusz',
  'base card' => 'alapkártya',
  'swim speed' => 'úszási sebesség',
  'pick craft' => 'barkácsolás kiválasztással',
  'víz breathing' => 'víz alatti légzés',
  'walk speed' => 'gyaloglási sebesség',
  'step assist' => 'lépéssegítő',
  'flight drift' => 'repülési sodródás',
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
  'chestplate' => 'mellvért',
  'plate' => 'lemez',
  'inscriber' => 'karcoló',
  'configurator' => 'konfigurátor',
  'component' => 'komponens',
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
$data['key.advanced_ae.category'] = 'Advanced AE';

foreach ($data as $key => $value) {
    if (strpos($value, 'Me') !== false) {
        $data[$key] = str_replace('Me', 'ME', $value);
    }
    if (strpos($value, 'Hp') !== false) {
        $data[$key] = str_replace('Hp', 'HP', $value);
    }
    if (preg_match('/(\d+)([mM])/', $value, $matches)) {
        $data[$key] = str_replace($matches[0], $matches[1] . strtoupper($matches[2]), $value);
    }
}

$file = $argc > 1 ? $argv[1] ?? 'advanced_ae.json' : 'advanced_ae.json';
saveAs($data, $file, true);
