# Cr8Router
Php Router for Apache Server to refractor URLs without extension and multilingual support (Geolocation)
It is designed to take control of the routing from Apache Server and implement it by PHP application itself. The main purposes of the router are creating SEO Friendly URLs without file extension and detect the user's language on first visit to show the website with customers language if available.

Instructions
1- Copy all files and paste into your Apache server's `public_html` folder.
2- Change `.htaccess` to you domain name.
3- Change `router` > `languages.php` and set your default language and if exist mention other languages. Leave blank if only single language.
4- Change `router` > `pages.php` and set domain name to yours.
5- Change `router` > `pages.php` and set which file will be called with which name (you can set more than one names as it is an array).
6- Change `router` > `pages.php` and set default opening pages for each language.


Use Views folder for each page of the website and for each language create a folder same with country code and keep the website pages there.
When you create new page do not forget to add it into `router` > `pages.php`.
