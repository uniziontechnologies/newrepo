<?php

class Form{
	var $formPath;
	var $popArr;
	
	function __construct(){
		$this->popArr = array();
	}
	function display() {
	
		$str = ROOT_PATH . $this->formPath;
		require ROOT_PATH . '/language/language.php';
		require_once(ROOT_PATH.$this->formPath);
	}

}


?>
