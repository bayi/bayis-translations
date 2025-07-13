<?php
include_once 'lib/index.php';

$version = $argv[1] ?? null;
$key = $argv[2] ?? null;
if (!$version || !$key) {
    echo "Usage: php fetch-modinfo.php <version> <key>\n";
    exit(1);
}

$upstreamDir = BASEDIR . '/src/' . $version . '/upstream/' . $key;
if (!is_dir($upstreamDir)) {
    echo "\e[031m * Directory \e[034m$upstreamDir\e[031m does not exist\e[0m" . PHP_EOL;
    exit(1);
}
$modrinthJsonPath = $upstreamDir . '/modrinth.json';

$override = $argv[3] ?? null;
$modSlug = $key;
if (is_null($override)) {
  if (file_exists($modrinthJsonPath)) {
    $meta = json_decode(file_get_contents($modrinthJsonPath), true);
    $modSlug = $meta['slug'] ?? $key;
  } else {
    $projectSlugPath = $upstreamDir . '/projectSlug';
    if (file_exists($projectSlugPath))
      $modSlug = trim(file_get_contents($projectSlugPath));
  }
} else $modSlug = $override;

$modrinth = new Modrinth();
$modInfo = $modrinth->getProject($modSlug);
if ($modInfo) {
  $meta = [
    'id' => $modInfo->id,
    'title' => $modInfo->title,
    'slug' => $modInfo->slug,
    'url' => 'https://modrinth.com/mod/' . $modInfo->slug,
  ];
  file_put_contents($modrinthJsonPath, json_encode($meta, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
}
