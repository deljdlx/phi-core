var Bienvenue=function() {

};


Bienvenue.extends=function(destinationClass, fromClass) {

	for(var attribute in fromClass.prototype) {

		if(typeof(destinationClass.prototype[attribute])=='undefined') {
			destinationClass.prototype[attribute]=fromClass.prototype[attribute];
		}
	}
}


Bienvenue.log=function(message, type) {
	console.debug(message);
};



Bienvenue.loadCSS=function(url) {
	$("<link/>", {
		rel: "stylesheet",
		type: "text/css",
		href: url
	}).appendTo("head");
};