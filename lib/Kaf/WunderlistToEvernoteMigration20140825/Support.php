<?php
namespace Kaf\WunderlistToEvernoteMigration20140825;

class Support{

	public function __construct($config = array()){
		foreach($config as $k => $v){
			$this->$k = $v;
		}
	}

	public function arrayGroupByCol($arr, $col){
		$new = array();

		foreach($arr as $v){
			$new[$v[$col]][] = $v;
		}
		return $new;
	}

	public function arrayMakeColAsKey($arr, $col){
		$new = array();

		foreach($arr as $v){
			$new[$v[$col]] = $v;
		}
		return $new;
	}

}