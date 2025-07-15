<?php
include_once 'lib/index.php';
include_once 'lib/progress.php';

$targets = ['active', 'merged'];
$mods = [];
foreach($versions as $version => $_pack)
{
  foreach($targets as $target)
  {
    $dir = BASEDIR . '/src/' . $version . '/' . $target;
    if (!is_dir($dir)) {
      echo "\e[031m * Directory \e[034m$dir\e[031m does not exist\e[0m" . PHP_EOL;
      continue;
    }
    
    $subdirs = array_filter(glob($dir . '/*'), 'is_dir');
    foreach ($subdirs as $subdir) {
      $modName = basename($subdir);
      if (!isset($mods[$modName]))
        $mods[$modName] = ['versions' => [], 'targets' => [], 'meta' => [], 'crowdin' => null];
      $mods[$modName]['folder'] = $modName;
      $mods[$modName]['versions'][$version] = ['status' => $target, 'pr' => false, 'merged' => false, 'crowdin' => false, 'missingKeys' => false, 'progress' => 0];
      $mods[$modName]['notes'] = '';

      $upstreamDir = BASEDIR . '/src/' . $version . '/upstream/' . $modName;
      if (is_dir($upstreamDir)) {
        if (file_exists($upstreamDir . '/pr')) {
          $mods[$modName]['versions'][$version]['pr'] = true;
        }
        if (file_exists($upstreamDir . '/merged')) {
          $mods[$modName]['versions'][$version]['merged'] = true;
        }
        if (file_exists($upstreamDir . '/modrinth.json')) {
          $mods[$modName]['meta'] = json_decode(file_get_contents($upstreamDir . '/modrinth.json'), true);
        } else if (file_exists($upstreamDir . '/github.json')) {
          $mods[$modName]['meta'] = json_decode(file_get_contents($upstreamDir . '/github.json'), true);
        }
        $progressData = getProgress($version, $modName, $target);
        if ($progressData === null)
          $mods[$modName]['versions'][$version]['progress'] = '?';
        else {
          $mods[$modName]['versions'][$version]['progress'] = $progressData['percent'];
          if (isset($progressData['missingKeys']) && is_array($progressData['missingKeys']) && count($progressData['missingKeys']) > 0) {
            $mods[$modName]['versions'][$version]['missingKeys'] = true;
          }
        }

        if (file_exists($upstreamDir . '/notes')) {
          $notes = file_get_contents($upstreamDir . '/notes');
          $mods[$modName]['notes'] .= trim($notes);
        }
        if (file_exists($upstreamDir . '/crowdin')) {
          $mods[$modName]['crowdin'] = file_get_contents($upstreamDir . '/crowdin');
        }
      }
    }
  }
}

uasort($mods, function($a, $b) use ($versions) {

  // Sort by merge status first
  $hasMergedA = false;
  $hasMergedB = false;
  foreach ($a['versions'] as $versionData) {
    if ($versionData['status'] === 'merged') {
      $hasMergedA = true;
      break;
    }
  }
  foreach ($b['versions'] as $versionData) {
    if ($versionData['status'] === 'merged') {
      $hasMergedB = true;
      break;
    }
  }
  if ($hasMergedA && !$hasMergedB) return -1;
  if (!$hasMergedA && $hasMergedB) return 1;

  // Sort by version
  $versionA = array_search('1.21.1', array_keys($a['versions'])) !== false ? 0 : 1;
  $versionB = array_search('1.21.1', array_keys($b['versions'])) !== false ? 0 : 1;
  
  if ($versionA !== $versionB) {
    return $versionA - $versionB;
  }

  // Determine which version to use for further sorting
  if (isset($a['versions']['1.21.1']) && isset($b['versions']['1.21.1'])) {
    $versionDataA = $a['versions']['1.21.1'];
    $versionDataB = $b['versions']['1.21.1'];
    $usedVersion = '1.21.1';
  } else {
    $modVersions = array_keys($a['versions']);
    if (empty($versions)) return 0; // No versions to compare
    $versionDataA = $a['versions'][$modVersions[0]];
    $versionDataB = $b['versions'][$modVersions[0]];
    $usedVersion = $modVersions[0];
  }

  // Sort by status: merged > active
  $statusA = $versionDataA['status'] ?? '?';
  $statusB = $versionDataA['status'] ?? '?';
  
  if ($statusA === 'merged' && $statusB !== 'merged') return -1;
  if ($statusA !== 'merged' && $statusB === 'merged') return 1;

  $prStatusA = ($versionDataA['merged'] ?? false) ? 'merged' : (($versionDataA['pr'] ?? false) ? 'pr' : 'active');
  $prStatusB = ($versionDataB['merged'] ?? false) ? 'merged' : (($versionDataB['pr'] ?? false) ? 'pr' : 'active');
  // Sort by PR status
  if ($prStatusA === 'merged' && $prStatusB !== 'merged') return -1;
  if ($prStatusA !== 'merged' && $prStatusB === 'merged') return 1;
  if ($prStatusA === 'pr' && $prStatusB !== 'pr') return -1;
  if ($prStatusA !== 'pr' && $prStatusB === 'pr') return 1;

  // Sort by progress for active mods
  if ($statusA === 'active' && $statusB === 'active') {
    $progressA = (int) floatval($a['versions'][$usedVersion]['progress']);
    $progressB = (int) floatval($b['versions'][$usedVersion]['progress']);
    return $progressB - $progressA; // Higher progress first
  }

  // Finally sort alphabetically by mod name
  return strcmp($a['folder'], $b['folder']);
});

$output = "# Hungarian translations / Magyar fordítások" . PHP_EOL;
$output .= PHP_EOL;
$output .= "This resource pack contains translations for various mods used in Minecraft. The status of each mod's translation is tracked below. See below what is included in the pack currently for which version and which ones were already merged upstream." . PHP_EOL;
$output .= PHP_EOL;
$output .= "Ez a resource pack különböző Minecraft modok fordításait tartalmazza. A fordítás állapotát nyomon követheted az alábbi táblázatban. Az alábbiakban látható, hogy melyik mod melyik verziójához van fordítva és melyek kerültek már be az upstreambe." . PHP_EOL;
$output .= PHP_EOL;
$output .= "## Status" . PHP_EOL;
$output .= PHP_EOL;
$output .= "| Mod | " . implode(' | ', array_keys($versions)) . " | Notes |" . PHP_EOL;
$output .= "| --- | " . str_repeat('--- | ', count($versions)) . " --- |" . PHP_EOL;

foreach($mods as $modName => $modData) {
  $modTitle = isset($modData['meta']['title']) ? "[{$modData['meta']['title']}]({$modData['meta']['url']})" : $modName;
  $output .= "| $modTitle | ";

  foreach($versions as $version => $_pack) {
    if (isset($modData['versions'][$version])) {
      $status = $modData['versions'][$version]['status'];
      if ($status == 'merged') {
        $status = '✅';
      } elseif ($status == 'active') {
        if ($modData['versions'][$version]['merged']) $status = '🟣';
        elseif ($modData['versions'][$version]['pr']) $status = ' 🔵';
        else $status = '🟢';
      } else {
        $status = '❌';
      }
      if (isset($modData['versions'][$version]['progress']) && $modData['versions'][$version]['progress'] > 0) {
        if ($modData['versions'][$version]['progress'] == '?') {
          $status .= ' (??)';
        } else {
          $progress = (int) floatval($modData['versions'][$version]['progress']);
          if ($modData['versions'][$version]['missingKeys']) {
            $status .= '⚠️';
          }
          if ($progress < 100)
            $status .= " ($progress%)";
        }
      }
      $output .= "$version $status | ";
    } else {
      $output .= "$version ❌| ";
    }
  }
  
  $output .= $modData['notes'] ?? ''; 
  if ($modData['crowdin']) {
    $crowdinLink = trim($modData['crowdin']);
    $output .= " [Crowdin]({$crowdinLink})";
  }

  $output .= " | " . PHP_EOL;
}

$output .= "
# Legend
- ✅: Not in resourcepack: Merged and Released upstream. Not included in the resource pack anymore
- 🟣: In resourcepack: PR Submitted and Merged waiting for release...
- 🔵: In resourcepack: PR Submitted
- 🟢: In resourcepack: In progress
- ❌: Not in resourcepack: Not working on it (maybe in the future)
- ⚠️: Has missing keys (needs update)

# Notes

- *1: Auto/tool generated, reviewed and fixed by hand
- *2: Autogenerated from Minecraft sources
- *3: Some keys are not possible to translate
- *4: Unused?
- Paused: Currently not working on it / mod not installed, it is still included in the resourcepack
";

echo $output . PHP_EOL;
