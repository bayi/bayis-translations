<?php
include_once 'lib/index.php';
$api = new Modrinth();
$api->auth($env['MODRINTH_TOKEN']);
$project = $env['MODRINTH_PROJECT'];

$description = file_get_contents(BASEDIR . '/README.md');

echo "Update project: " . json_encode($api->updateProject($project, [
    'body' => $description,
]), JSON_PRETTY_PRINT) . "\n";
