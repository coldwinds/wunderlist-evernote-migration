<?php
header('Content-Type: text/html; charset=utf-8');

/**
 * This file will dump wunderlist's json backup file structure
 */

require_once __DIR__.'/vendor/autoload.php';
$c = require_once __DIR__.'/config.php';

use Kaf\WunderlistToEvernoteMigration20140825\WunderlistJsonReader;

$w = new WunderlistJsonReader($c['wunderlist']);
$w->loadFile();
$w->parse();

krumo($w->data);