<?php
class pages{
	var $load;
	var $defaulthome;
	var $domain;
	function __construct(){
		
		//Name of the Domain carefull for the HTTP or HTTPS
		$this->domain = 'http://yourdomain.com';
		
		//Define your pages in here for each language
		$this->load = array(
			'home.php' => array('anasayfa','home'),
			'about.php' => array('hakkimizda','about'),
			'contact.php' => array('iletisim', 'contact'),
			'service.php' => array('servisler','services'),
			'products.php' => array('urunler','products'),
			'faq.php' => array('sss','faq'),
			'calculator.php' => array('fiyat','calculator'),
			'404.php' => array('404')
		);
		
		//Define your default home page name for each language here
		$this->defaulthome = array(
			'tr' => 'anasayfa',
			'en' => 'home'
		);
		
	}
}
?>
