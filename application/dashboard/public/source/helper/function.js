function log(message, type) {
	return Bienvenue.log(message, type);
}


function isset(variable) {
	if(typeof(variable)==='undefined') {
		return false;
	}
	else {
		return true;
	}
}


function isFunction(functionToCheck) {
	var getType = {};
	return functionToCheck && getType.toString.call(functionToCheck) === '[object Function]';
}



function getScript(url, callback) {
	return $.getScript(url, callback.bind(this));
}

function loadComponent(componentName, callback) {


	var componentBaseURL='source/class/Component/'+componentName;
	var componentBootstrapURL='source/class/Component/'+componentName+'/'+componentName+'.js';


	log('Loading component "'+componentBaseURL+'"');

	return getScript('source/class/Component/'+componentName+'/'+componentName+'.js', function() {



		if(isFunction(callback)) {
			inherit(Bienvenue.Component[componentName], Bienvenue.Component);

			Bienvenue.Component[componentName].prototype.baseURL=componentBaseURL;
			callback(componentName);
		}
	});
}



function inherit(destinationClass, fromClass) {
	return Bienvenue.extends(destinationClass, fromClass);
}

