<?php
// $dir = "/data/Games/com.modrinth.theseus/profiles/Lillas Create/mods/";
$dir = "/data/Games/com.modrinth.theseus/profiles/Bayi_s Create Skyblock Pack/mods/";
$files = scandir($dir);

foreach($files as $file)
{
  if (pathinfo($file, PATHINFO_EXTENSION) == "jar") {
    $filePath = $dir . $file;
    echo "\e[032m * Processing \e[034m$filePath\e[0m" . PHP_EOL;
    system("php extract.php \"$filePath\"");
  }
}
