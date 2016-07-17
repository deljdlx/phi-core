var Bienvenue={
	Component:{}
};


Bienvenue.extends=function(destinationClass, fromClass) {

	for(var attribute in fromClass.prototype) {

		if(typeof(destinationClass.prototype[attribute])=='undefined') {
			destinationClass.prototype[attribute]=fromClass.prototype[attribute];
		}
	}
}