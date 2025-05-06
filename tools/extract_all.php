<?php
$dir = "/data/Games/com.modrinth.theseus/profiles/Lillas Create/mods/";
$files = scandir($dir);

foreach($files as $file)
{
  if (pathinfo($file, PATHINFO_EXTENSION) == "jar") {
    $filePath = $dir . $file;
    echo "\e[032m * Processing \e[034m$filePath\e[0m" . PHP_EOL;
    system("php extract.php \"$filePath\"");
  }
}
