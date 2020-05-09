# Cr8Router

PHP Router for Apache Server to refractor URLs without extension and multilingual support (Geolocation). It is designed to take control of the routing from Apache Server and implement it by PHP application itself. The main purposes of the router are creating SEO Friendly URLs without file extension and detect the user's language on first visit to show the website with customers language if available.


## Instructions

 - Copy all files and paste into your Apache server's `public_html`  folder.
 - Change `.htaccess` to you domain name.
 - Change `router` > `languages.php` and set your default language and if exist mention other languages. Leave blank if only single language.
 - Change `router` > `pages.php` and set domain name to yours.
 - Change `router` > `pages.php` and set which file will be called with which name (you can set more than one names as it is an array).
 - Change `router` > `pages.php` and set default opening pages for each language.



Use Views folder for each page of the website and for each language create a folder same with country code and keep the website pages there.
When you create new page do not forget to add it into `router` > `pages.php`.

Router guesses user language from his/her location + keyboard language and if that language is exist opens the page at first visit with that language. If that language is not exist it will open with default language. If a user changes to another language browser will save it into cookies and show the website in that language even after quiting and returning.

You can check user language from `cookies` named `sitelang`.
