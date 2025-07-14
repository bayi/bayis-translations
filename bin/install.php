<?php
include_once 'lib/index.php';

$zipName = $argv[1] ?? null;
$currentVersion = $argv[2] ?? null;
$distFolder = $argv[3] ?? null;

foreach($versions as $version => $folder)
{
  echo " \033[32m* Processing version $version ...\033[0m\n";
  $zipFileName = $zipName . '-' . $currentVersion . '-' . $version . '.zip';
  $zipFile = BASEDIR . '/' . $distFolder . '/' . $zipFileName;
  if (!file_exists($zipFile)) {
    echo " * File $zipFile does not exist.\n";
    continue;
  }

  $targetFolder = $folder . '../config/openloader/packs';

  if (!file_exists($targetFolder)) {
    echo " * Target folder $targetFolder does not exist.\n";
    $targetFolder = $folder . '../config/openloader/resources';
    if (!file_exists($targetFolder)) {
      echo " * Target folder $targetFolder does not exist.\n";
      continue;
    }
  }

  $files = glob($targetFolder . '/' . $zipName . '-*.zip');
  foreach ($files as $file) {
    if (is_file($file)) {
      echo " * Removing old file: $file\n";
      unlink($file);
    }
  }

  echo " * Copying $zipFile to $targetFolder/$zipFileName\n";
  copy($zipFile, $targetFolder . '/' . $zipFileName);

}
