Bienvenue.Component=function()
{

};

Bienvenue.Component.prototype.__construct=function() {

};


Bienvenue.Component.prototype.loadCSS=function(files) {

	for(var i=0; i<files.length; i++) {

		log('Loading css "'+this.baseURL+'/'+files[i]+'"');

		var cssURL=this.baseURL+'/'+files[i]+'?'+Math.random();
		Bienvenue.loadCSS(cssURL);
	}
}


Bienvenue.Component.prototype.attach=function() {
	console.debug(1);
};