<?php
namespace Kaf\WunderlistToEvernoteMigration20140825;

class EvernoteEnexWriter extends Support{

	public
		$savePath;

	public function saveEnexAsFile($name, $data){
		file_put_contents(sprintf('%s/%s.enex', $this->savePath, $name), $data);
	}

	public function buildEnex($notes = array()){
		$tpl = '<?xml version="1.0" encoding="UTF-8"?>
			<!DOCTYPE en-export SYSTEM "http://xml.evernote.com/pub/evernote-export2.dtd">
			<en-export export-date="20140823T175604Z" application="EvernoteEnexWriter/Windows" version="5.x">%s</en-export>';

		return sprintf($tpl, implode('', $this->buildNotes($notes)));
	}

	public function buildNotes($notes = array()){
		foreach($notes as $k => $note){
			$notes[$k] = $this->buildNote($note);
		}
		return $notes;
	}

	public function buildNote($note = array()){
		$tpl = '<note><title>%s</title><content>%s</content><created>%s</created><updated>%s</updated></note>';

		return sprintf($tpl, htmlentities($note['title'], ENT_QUOTES, 'UTF-8'), $this->buildNoteContent($note['content']), $note['created'], $note['updated']);
	}

	public function buildNoteContent($content){
		$tpl = '<![CDATA[<?xml version="1.0" encoding="UTF-8"?>
			<!DOCTYPE en-note SYSTEM "http://xml.evernote.com/pub/enml2.dtd">
			<en-note style="word-wrap: break-word; -webkit-nbsp-mode: space; -webkit-line-break: after-white-space;">%s</en-note>]]>';

		return sprintf($tpl, sprintf('<div>%s</div>', $content));
	}




}