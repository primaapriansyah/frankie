// If you decide to minify this file then be sure to update the link in functions.php
// remap jQuery to $
(function($){})(window.jQuery);

$(document).ready(function (){

	// Toggling mobile menu
	$('a.navigation-mobile').click(function(){
		$('#main-navigation').toggleClass("open");
	}); 

	// Your functions go here

});