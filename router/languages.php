<?php
class lang_array{
	var $otherlang;
	var $defaultlang;
	var $alllangs;
	
	function __construct(){
		//Set website's deafault Language
		$this->defaultlang = 'tr';
		//Set Countries that website will be shown in their own languages
		$this->otherlang = array('fr','de','it','es','gr','en');
		
		//Do not touch to this one
		$this->alllangs = array();		
		array_push($this->alllangs,$this->defaultlang);
		$this->alllangs = array_merge($this->alllangs,$this->otherlang);
		$this->alllangs = array_unique($this->alllangs);
		$this->alllangs = array_values($this->alllangs);
	}
	
}
?>