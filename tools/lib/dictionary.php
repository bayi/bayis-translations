<?php
include_once 'utils.php';

// Inventory => Felszerelés

$colors = [
  'light blue' => 'világoskék',
  'light gray' => 'világosszürke',
  'black' => 'fekete',
  'blue' => 'kék',
  'brown' => 'barna',
  'cyan' => 'türkizkék',
  'gray' => 'szürke',
  'green' => 'zöld',
  'lime' => 'világoszöld',
  'magenta' => 'bíbor',
  'orange' => 'narancssárga',
  'pink' => 'rózsaszín',
  'purple' => 'lila',
  'red' => 'vörös',
  'white' => 'fehér',
  'yellow' => 'sárga',
];

$pass_b1 = [
  'stained glass panes' => 'festett üveglapok',
  'glass panes' => 'üveglapok',
];

$pass_a1 = [
  'concrete powder' => 'szárazbeton',
  'coal blocks' => 'szénblokk',
  'fungus cluster' => 'gombatelep',
  'fungus bulb' => 'gombahagyma',
  'fungus trio' => 'gombatrió',
  'fungus bushel' => 'gombaköteg',
  'mushroom stems' => 'gombatönk',
  'mushroom stem' => 'gombatönk',
  'mushroom bulb' => 'gombahagyma',
  'mushroom cluster' => 'gombatelep',
  'gomba cluster' => 'gombatelep',
  'gomba bushel' => 'gombaköteg',
  'gomba trio' => 'gombatrió',
  'gomba bulb' => 'gombahagyma',
];

$pass_a2 = [
  // Woods
  'acacia' => 'akáciafa',
  'dark oak' => 'sötéttölgy',
  'jungle' => 'dzsungelfa',
  'mangrove' => 'mangrovefa',
  'oak' => 'tölgyfa',
  'pale oak' => 'sápadttölgy',
  'spruce' => 'fenyőfa',
  'cherry' => 'cseresznyefa',
  'birch' => 'nyírfa',
  'bamboo' => 'bambusz',
  'crimson' => 'karmazsin',
  'warped' => 'torz',
  // Minerals
  'coal' => 'szén',
  'copper' => 'réz',
  'gold' => 'arany',
  'iron' => 'vas',
  'diamond' => 'gyémánt',
  'netherite' => 'netherit',
  // Misc
  'wool' => 'gyapjú',
  'concrete' => 'beton',
  'ancient' => 'ősi',
  'vines' => 'indák',
  'vine' => 'inda',
  'tiles' => 'csempe',
  'tile' => 'csempe',
  'pillar' => 'oszlop',
  'stained' => 'festett',
  'arrow' => 'nyíl',
  'mushroom' => 'gomba',
  'mushrooms' => 'gombák',
  'logs' => 'rönkök',
  'doors' => 'ajtók',
  'pumpkins' => 'tökök',
  'trapdoors' => 'csapóajtók',
  'trapdoor' => 'csapóajtó',
  'blocks' => 'blokkok',
  'block' => 'blokk',
  'carpet' => 'szőnyeg',
  'carpets' => 'szőnyegek',
  'barrels' => 'hordók',
  'glazed' => 'mázas',
  'paper' => 'papír',
  'lily pads' => 'tavirózsák',
  'torches' => 'fáklyák',
  'lamps' => 'lámpák',
  'column' => 'oszlop',
  'budding' => 'kristályosodó',
  'bowl' => 'tál',
  'mossy' => 'mohás',
  'empty' => 'üres',
  'pale' => 'sápadt',
  'plank' => 'deszka',
  'polished' => 'csiszolt',
  'reinforced' => 'megerősített',
  'stairs' => 'lépcső',
  'door' => 'ajtó',
  'nugget' => 'rög',
  'ingot' => 'rúd',
];

$pass_modded_a1 = [
  'crate' => 'láda',
  'brass' => 'sárgaréz',
  'zinc' => 'cink',
  'sheet' => 'lemez',
  'rope' => 'kötél',
  'ash' => 'hamu',
];

$blocks = initDictionaryFromSource('../originals/minecraft/hu_hu.json', 'block.minecraft.');
// @TODO: Load items from minecraft file

$dictionary = [
  $colors,
  $pass_b1,
  $blocks,
  $pass_a1,
  $pass_a2,
  $pass_modded_a1,
];

