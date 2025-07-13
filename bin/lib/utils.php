<?php
mb_internal_encoding('utf-8');
if (!defined('BASEDIR')) die();

function capitalizeWords($string) : string
{
  return ucwords(strtolower($string));
}

function loadFile($jsonFile) : array|null
{
  if (!file_exists($jsonFile)) throw new Exception("File not found: $jsonFile");
  $fh = fopen($jsonFile, 'r');
  if ($fh === false) throw new Exception("Could not open file: $jsonFile");
  $json = fread($fh, filesize($jsonFile));
  fclose($fh);
  return json_decode($json, true);
}

function fixCase(string $string) : string
{
  return preg_replace_callback(
    '/(?<=\.\s|^)(\w)/u',
    fn ($matches) => mb_strtoupper($matches[1]),
    mb_strtolower($string)
  );
}

function replaceWords(string $string, array $dictionary) : string
{
  $string = mb_strtolower($string);
  foreach ($dictionary as $key => $value) {
    // $string = str_replace($key, $value, $string);
    $string = preg_replace('/\b' . preg_quote($key, '/') . '\b/u', $value, $string); // Only replace full words
  }
  return $string;
}

function orderDictionary(array $dictionary) : array
{
  uasort($dictionary, function ($a, $b) {
    $aWords = explode(' ', $a);
    $bWords = explode(' ', $b);
    if (count($aWords) === count($bWords))
      return strlen($b) - strlen($a);
    return count($bWords) - count($aWords); // Order by word count then by length descending
  });
  return $dictionary;
}

function initDictionaryFromSource(string $file, string $key) : array
{
  $originals = loadFile($file);
  $data = [];
  foreach($originals as $k => $v) {
    if (str_starts_with($k, $key)) {
      // if (str_contains($k, '.')) continue;
      $newKey = str_replace($key, '', $k);
      $newKey = str_replace('.', ' ', $newKey);
      $newKey = str_replace('_', ' ', $newKey);
      $data[mb_strtolower(trim($newKey))] = mb_strtolower(trim($v));
    }
  }
  return orderDictionary($data);
}

function processFile(string $file, array $dictionaries = []) : array
{
  $data = loadFile($file);
  foreach ($data as $key => $value) {
    $line = $value;
    foreach($dictionaries as $dictionary) {
      $line = replaceWords($line, $dictionary);
    }
    $line = fixCase($line);
    $data[$key] = $line;
  }
  return $data;
}

function applyFixed(array $data, string $key) : array
{
  $fixed = loadDictionarySet($key, 'fixed');
  foreach($fixed as $fixedDictionary)
    foreach($fixedDictionary as $k => $v)
      if (isset($data[$k])) $data[$k] = $v;
  return $data;
}

function saveAs(array $data, string $file, ?bool $noIndent = false) : void
{
  $fh = fopen($file, 'w');
  if ($fh === false) throw new Exception("Could not open file: $file");
  $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
  if ($noIndent)
    $json = preg_replace('/^ +/m', '', $json); // Remove indentation
  fwrite($fh, $json);
  fclose($fh);
}

function createTemp() : ?string
{
  $path = BASEDIR . '/temp';
  if (!is_dir($path)) {
      if (!mkdir($path, 0755, true)) {
          die('Failed to create temp directory');
      }
  } else exec('rm -rf ' . $path . '/*');
  return $path;
}

function extractUpstream(string $fileName, string $version) : bool
{
  $temp = createTemp();
  $files = ['en_us.json', 'hu_hu.json'];
  foreach($files as $file) {
    $command = "unzip '$fileName' 'assets/*/lang/'" . $file . " -d $temp 2>/dev/null";
    exec($command, $output, $return_var);
  }
  if (!is_dir("$temp/assets")) { 
    echo "\e[033m ! No assets extracted from: " . $file . "\e[0m" . PHP_EOL;
    return false;
  }
  $target = BASEDIR . "/src/$version/upstream";
  try {
    $dir = new DirectoryIterator('temp/assets');
    $keys = [];
    foreach ($dir as $fileinfo) {
      if ($fileinfo->isDir() && !$fileinfo->isDot()) $keys[] = $fileinfo->getFilename();
    }

    foreach($keys as $key) {
      if (!is_dir("$target/$key/lang")) {
        if (!mkdir("$target/$key/lang", 0755, true)) {
          echo "\e[031m ! Failed to create directory: $target/$key\e[0m" . PHP_EOL;
          return false;
        }
      }

      foreach($files as $file) {
        $source = "$temp/assets/$key/lang/$file";
        $destination = "$target/$key/lang/$file";
        if (@rename($source, $destination)) {
          echo "\e[032m   * Extracted: \e[034m$file\e[0m" . PHP_EOL;
        }
      }
    }
    exec("rm -rf $temp");
  } catch (Exception $e) {
    echo "\e[031m ! Error: " . $e->getMessage() . "\e[0m" . PHP_EOL;
    return false;
  }
  return false;
}
