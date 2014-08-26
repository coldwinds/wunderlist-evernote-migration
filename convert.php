<?php
header('Content-Type: text/html; charset=utf-8');

error_reporting(0);

require_once __DIR__.'/vendor/autoload.php';
$c = require_once __DIR__.'/config.php';

use Kaf\WunderlistToEvernoteMigration20140825\WunderlistJsonReader;
use Kaf\WunderlistToEvernoteMigration20140825\EvernoteEnexWriter;
use Kaf\WunderlistToEvernoteMigration20140825\Migrate;

$m = new Migrate(array(
	'wunderlist' => new WunderlistJsonReader($c['wunderlist']),
	'evernote' => new EvernoteEnexWriter($c['evernote']),
));

$m->process();

echo 'done';