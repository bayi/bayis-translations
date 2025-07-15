<?php
include_once 'lib/index.php';

$api = new Modrinth();
$api->auth($env['MODRINTH_TOKEN']);

$gameVersion = $argv[1] ?? '1.20.1';
$version = trim(file_get_contents(BASEDIR . '/VERSION'));
$changelog = trim(file_get_contents(BASEDIR . '/CHANGELOG.md'));

$file = BASEDIR . '/dist/BayisHungarianTranslations-' . $version . '-' . $gameVersion . '.zip';
if (!file_exists($file)) {
    echo "File not found: $file\n";
    exit(1);
}
$cfile = curl_file_create($file, 'application/zip', basename($file));

$supportedVersionsFile = BASEDIR . '/src/' . $gameVersion . '/supported-versions.json';
if (file_exists($supportedVersionsFile)) {
    $supportedVersions = json_decode(file_get_contents($supportedVersionsFile));
} else $supportedVersions = [$gameVersion];

$data = [
  'name' => 'v1.' . $version,
  'version_number' => (string) $version,
  'changelog' => $changelog,
  'dependencies' => [],
  'game_versions' => $supportedVersions,
  'version_type' => 'release',
  'loaders' => ['minecraft'],
  'featured' => false,
  'status' => 'listed',
  'requested_status' => 'listed',
  'project_id' => $env['MODRINTH_PROJECT'],
  'file_parts' => ['main_file'],
  'primary_file' => 'main_file',
];

$payload = [
  'data' => json_encode($data),
  'main_file' => $cfile,
];

echo " * Publishing version $version for Minecraft $gameVersion on Modrinth ...\n";

$res = null;
// $res = $api->listVersions($env['MODRINTH_PROJECT']);
$res = $api->createVersion($payload);
// $res = $api->deleteVersion('');

echo " * Result: " . json_encode($res, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n";
