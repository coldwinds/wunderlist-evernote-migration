<?php
namespace Kaf\WunderlistToEvernoteMigration20140825;

/**
 * Class Migrate
 * @package Kaf\WunderlistToEvernoteMigration20140825
 *
 * This class will not convert reminders
 * If you want to, you may consult https://dev.evernote.com/doc/articles/reminders.php
 */
class Migrate extends Support{

	public
		$codePage,
		$wunderlist,
		$evernote;

	/**
	 * @param $dateTime WunderlistJsonReader dateTime 2013-02-26T17:13:59.444Z
	 * @return string evernote dateTime 20140825T091815Z
	 *
	 * Convert wunderlist datetime to evernote format
	 * http://en.wikipedia.org/wiki/ISO_8601
	 */
	public function dateTimeW2E($dateTime){
		list($yyyy, $mm, $dd, $hh, $ii, $ss) = sscanf($dateTime, '%d-%d-%dT%d:%d:%d.%dZ');
		return sprintf('%04d%02d%02dT%02d%02d%02dZ', $yyyy, $mm, $dd, $hh, $ii, $ss);
	}

	/**
	 * @param $task Task entry from wunderlist tasks
	 * @return string EvernoteEnexWriter note content
	 *
	 * Convert wunderlist subtasks and note to evernote note
	 *
	 * Join subtasks with note into evernote note content,
	 * decorate completed subtasks with <strike> markup
	 *
	 * https://dev.evernote.com/doc/articles/enml.php
	 */
	public function contentW2E($task){
		$a = array();
		if(is_array($task['subtasks'])){
			foreach($task['subtasks'] as $v){
				$a[] = $v['completed'] ? sprintf('<strike>%s</strike>', $v['title']) : $v['title'];
			}
			$a[] = PHP_EOL.PHP_EOL;
		}
		$a[] = $task['note']['content'];

		return nl2br(trim(implode(PHP_EOL, $a)), true);
	}

	public function readWunderlistData(){
		$w = $this->wunderlist;
		$e = $this->evernote;

		$w->loadFile();
		$w->parse();
		$w->normalize();

		return $w->data;
	}

	public function buildEvernoteData($wunderlistData){
		$wunderlistData = $this->htmlSpecialChars($wunderlistData);

		foreach($wunderlistData as $list){
			$notes = array();
			foreach((array) $list['tasks'] as $task){
				$notes[] = array(
					'title' => $task['title'],
					'content' => $this->contentW2E($task),
					'created' => $this->dateTimeW2E($task['created_at']),
					'updated' => $this->dateTimeW2E($task['created_at']),
				);
			}

			$notebooks[$list['id']] = array(
				'id' => $list['id'],
				'title' => $list['title'],
				'notes' => $notes,
			);
		}
		return $notebooks;
	}

	public function process(){
		$e = $this->evernote;
		$notebooks = $this->buildEvernoteData($this->readWunderlistData());

		foreach($notebooks as $notebook){
			$v = $e->buildEnex($notebook['notes']);
			empty($notebook['notes']) or
				$e->saveEnexAsFile(sprintf('%s-%s', mb_convert_encoding($notebook['title'], $this->codePage, 'UTF8'), $notebook['id']), $e->buildEnex($notebook['notes']));
		}
	}


}
