<?php
namespace Kaf\WunderlistToEvernoteMigration20140825;

class WunderlistJsonReader extends Support{

	public
		$file,
		$data;

	public function loadFile(){
		$this->data = file_get_contents($this->file);
	}
	
	public function parse(){
		$this->data = json_decode($this->data, true);
	}

	/**
	 * Append tasks to associated list item
	 * Append notes and subtasks to associated task item
	 */
	public function normalize(){
		extract($this->data['data']);

		$lists = $this->arrayMakeColAsKey($lists, 'id');
		$tasks = $this->arrayMakeColAsKey($tasks, 'id');
		$notes = $this->arrayMakeColAsKey($notes, 'task_id');
		$subtasks = $this->arrayGroupByCol($subtasks, 'task_id');

		foreach($tasks as $task){
			$task['note'] = $notes[$task['id']];
			$task['subtasks'] = $subtasks[$task['id']];

			$lists[$task['list_id']]['tasks'][$task['id']] = $task;
		}

		$this->data = $lists;
	}

}