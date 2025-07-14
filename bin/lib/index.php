<?php
define( 'BASEDIR', dirname( __FILE__ , 3));

$env = [];
if (file_exists(BASEDIR . '/.env'))
{
  $env = parse_ini_file(BASEDIR . '/.env');
}

include_once 'dictionary.php';
include_once 'modrinth.php';
include_once 'utils.php';

