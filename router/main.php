<?php
header('Content-Type: text/html; charset=utf-8');

require('router/pages.php'); // this is for pages to load variable
require("router/languages.php"); //this is default lang and optional lang options

class lang_detector {
	
	var $sitelang;
	var $ip;
	var $ct;
	var $pclang;
	var $mainlang;
	var $secondlang;
	var $secondmainlang;
	var $firstmainlang;
	
	function __construct(){
		$this->ip = $_SERVER['REMOTE_ADDR'];
		$this->pclangmain = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2);
		$this->mainlang = array();
		$this->secondlang = array();
	}
	function whichlangs(){
		$this->ct = curl_init();
        	curl_setopt($this->ct, CURLOPT_URL,"http://seofriendlyurl.com/php/c_to_l.php?ip={$this->ip}");
        	curl_setopt($this->ct, CURLOPT_RETURNTRANSFER, true);
        	$jsonRespLang = json_decode(curl_exec($this->ct));
        	curl_close($this->ct);
		return $jsonRespLang;
	}
	function pclanguage(){
		$this->pclang = explode(",", $_SERVER["HTTP_ACCEPT_LANGUAGE"]);
		foreach($this->pclang as $x){
    		$s = explode(";",$x);
    		$flang = substr($s[0],0,2);
			if(in_array(strtolower($flang),$this->whichlangs())){
				array_push($this->mainlang, strtolower($flang));
			} else {
				array_push($this->secondlang, strtolower($flang));
			}
		}
	}
	
	function sitelang_detect($defaultlang, $alllangs, $poslang=NULL){
		if(!isset($postlang) && !isset($_COOKIE['sitelang'])){
			$this->pclanguage();
			if(($this->firstmainlang = array_intersect($this->mainlang,$alllangs)) != false){
				$this->sitelang = $this->firstmainlang[0];
				setcookie('sitelang',$this->sitelang,time() + (10 * 365 * 24 * 60 * 60), "/");
			} else if(($this->secondmainlang = array_intersect($this->secondlang,$alllangs)) != false){
				$this->sitelang = $this->secondmainlang[0];
				setcookie('sitelang',$this->sitelang,time() + (10 * 365 * 24 * 60 * 60), "/");
			} else {
				$this->sitelang = strtolower($defaultlang);
				setcookie('sitelang',$this->sitelang,time() + (10 * 365 * 24 * 60 * 60), "/");
			}
		} else if(isset($postlang)){
			$this->sitelang = strtolower($postlang);
			setcookie('sitelang',$this->sitelang,time() + (10 * 365 * 24 * 60 * 60), "/");
		} else if(isset($_COOKIE['sitelang'])){
			$this->sitelang = strtolower($_COOKIE['sitelang']);
		}	
		$_SESSION['lang'] = $this->sitelang;
	}
}

class routing{
	var $lang;
	var $lang_array;
	var $sitelang;
	var $routes;
	var $qsaexplode;
	var $checkifexist;
	var $postlang;
	var $pages;
	
	function __construct(){
		$this->lang = new lang_detector();
		$this->lang_array = new lang_array();
		$this->pages = new pages();
		
		$this->checkifexist = false;
		$this->postlang = $_POST['lang'];
		
		$this->lang->sitelang_detect($this->lang_array->defaultlang,$this->lang_array->alllangs,$this->postlang);
		
		$this->sitelang = $this->lang->sitelang;
		
		$this->routes = array();
		$this->routes = explode('/', $_SERVER['REQUEST_URI']);
	}
	
	function router(){
		if(!in_array($this->routes[1], $this->lang_array->alllangs)){
			if($this->routes[2] === '' || empty($this->routes[2]) || !isset($this->routes[2])){
				if(strpos($this->routes[1],'?') !== false){
					header('Cache-Control: no-cache, must-revalidate');
					$this->qsaexplode = explode('?', $this->routes[1]);
					if($this->qsaexplode[0] === '' || empty($this->qsaexplode[0]) || !isset($this->qsaexplode[0])){
						header('location: '.$this->pages->domain.'/'.$this->sitelang.'/'.$this->pages->defaulthome[$this->sitelang].'?'.$this->qsaexplode[1]);
					} else {
						header('location: '.$this->pages->domain.'/'.$this->sitelang.'/'.$this->routes[1]);
					}
				} else {
					header('Cache-Control: no-cache, must-revalidate');
					header('location: '.$this->pages->domain.'/'.$this->sitelang.'/'.$this->routes[1]);
				}
			} else {
				header('location: '.$this->pages->domain.'/'.$this->sitelang.'/'.$this->routes[2]);
			}
		} else {
			if($this->routes[2] === '' || empty($this->routes[2]) || !isset($this->routes[2])){
			header('location:'.$this->pages->domain.'/'.$this->routes[1].'/'.$this->pages->defaulthome[$this->sitelang]);
			setcookie('sitelang',$this->routes[1],time() + (10 * 365 * 24 * 60 * 60), "/");
			} else {
				foreach($this->pages->load as $x){
					$this->qsaexplode = explode('?', $this->routes[2]);
					if(in_array($this->qsaexplode[0],$x)){
						setcookie('sitelang',$this->routes[1],time() + (10 * 365 * 24 * 60 * 60), "/");
						$_SESSION['lang'] = $this->routes[1];
						include('views/'.$this->routes[1].'/'.array_search($x,$this->pages->load));
						$this->checkifexist = true;
						break;
					}
				}
				if($this->checkifexist != true){
						setcookie('sitelang',$this->routes[1],time() + (10 * 365 * 24 * 60 * 60), "/");
						$_SESSION['lang'] = $this->routes[1];
						include('views/'.$this->routes[1].'/404.php');
						$this->checkifexist = false;
				}
			}
		}
	}
	
}
?>
